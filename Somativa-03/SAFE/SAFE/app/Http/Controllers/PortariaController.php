<?php

namespace App\Http\Controllers;

use App\Models\Authorization;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Services\NotificationService;

class PortariaController extends Controller
{
    public function __construct(
        private NotificationService $notificationService
    ) {}

    /**
     * Dashboard da Portaria.
     */
    public function dashboard()
    {
        $entriestoday = Authorization::where('type', 'entry')
            ->whereDate('checked_by_portaria_at', today())
            ->where('portaria_status', 'checked')
            ->count();

        $exitsToday = Authorization::where('type', 'exit')
            ->whereDate('checked_by_portaria_at', today())
            ->where('portaria_status', 'checked')
            ->count();

        $pendingToday = Authorization::where('status', 'authorized')
            ->where(function($q) {
                $q->whereNull('checked_by_portaria_at')
                  ->orWhereDate('checked_by_portaria_at', '!=', today());
            })
            ->count();

        $recentValidations = Authorization::with(['student', 'guardian'])
            ->whereNotNull('checked_by_portaria_at')
            ->orderBy('checked_by_portaria_at', 'desc')
            ->limit(10)
            ->get();

        return view('portaria.dashboard', compact([
            'entriestoday',
            'exitsToday',
            'pendingToday',
            'recentValidations',
        ]));
    }

    /**
     * Mostrar formulário de validação.
     */
    public function validateForm()
    {
        return view('portaria.validate-authorization');
    }

    /**
     * Validar uma autorização pelo código.
     */
    public function validateByCode(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string|size:8',
        ]);

        $authorization = Authorization::where('validation_code', strtoupper($validated['code']))
            ->where('status', 'authorized')
            ->first();

        if (!$authorization) {
            return back()->withErrors(['code' => 'Código de validação inválido ou expirado.']);
        }

        if ($authorization->expires_at < now()) {
            return back()->withErrors(['code' => 'Código expirado.']);
        }

        return view('portaria.confirm-validation', compact('authorization'));
    }

    /**
     * Confirmar validação (entrada/saída).
     */
    public function confirmValidation(Request $request, $id)
    {
        $validated = $request->validate([
            'action' => 'required|in:approve,deny',
            'notes' => 'nullable|string',
        ]);

        $authorization = Authorization::findOrFail($id);

        if ($authorization->status !== 'authorized' || $authorization->expires_at < now()) {
            return back()->withErrors(['error' => 'Autorização inválida ou expirada.']);
        }

        $portariaStatus = $validated['action'] === 'approve' ? 'checked' : 'denied';

        $authorization->update([
            'checked_by_portaria_at' => now(),
            'portaria_status' => $portariaStatus,
            'status' => $portariaStatus === 'checked' ? 'used' : 'rejected',
            'rejection_reason' => $portariaStatus === 'denied'
                ? ($validated['notes'] ?: 'Validacao negada pela portaria.')
                : $authorization->rejection_reason,
        ]);

        $authorization = $authorization->fresh(['student', 'guardian']);

        if ($portariaStatus === 'checked') {
            if ($authorization->type === 'entry') {
                $this->notificationService->sendEntryNotification($authorization);
            } else {
                $this->notificationService->sendExitNotification($authorization);
            }
        } else {
            $this->notificationService->sendRejectionNotification($authorization);
        }

        $movement = $authorization->type === 'entry'
            ? 'registrado(a) na entrada'
            : 'autorizado(a) para sair';

        $message = $portariaStatus === 'checked'
            ? "{$authorization->student->name} foi {$movement} com sucesso! Notificacao registrada."
            : 'Validacao negada pela portaria e notificacao registrada.';

        return redirect('/portaria/dashboard')->with('success', $message);
    }

    /**
     * Listar validações do dia.
     */
    public function listValidations()
    {
        $validations = Authorization::with(['student', 'guardian', 'professor'])
            ->whereNotNull('checked_by_portaria_at')
            ->orderBy('checked_by_portaria_at', 'desc')
            ->paginate(20);

        return view('portaria.list-validations', compact('validations'));
    }

    /**
     * Ver detalhes de uma validação.
     */
    public function viewValidation($id)
    {
        $authorization = Authorization::with([
            'student', 'guardian', 'professor', 'admin'
        ])->findOrFail($id);

        return view('portaria.view-validation', compact('authorization'));
    }
}
