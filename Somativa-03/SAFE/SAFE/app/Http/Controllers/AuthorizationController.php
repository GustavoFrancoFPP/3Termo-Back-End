<?php

namespace App\Http\Controllers;

use App\Models\Authorization;
use App\Models\Guardian;
use App\Models\Student;
use App\Models\Teacher;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AuthorizationController extends Controller
{
    public function __construct(
        private NotificationService $notificationService
    ) {}

    public function index()
    {
        $authorizations = Authorization::where('status', 'pending')
            ->with(['student', 'guardian', 'teacher'])
            ->latest()
            ->paginate(15);

        return view('authorizations.index', compact('authorizations'));
    }

    public function create()
    {
        $students = Student::where('is_active', true)->get();
        $guardians = Guardian::orderBy('name')->get();
        $teachers = Teacher::where('is_active', true)->orderBy('name')->get();

        return view('authorizations.create', compact('students', 'guardians', 'teachers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'guardian_id' => 'required|exists:guardians,id',
            'teacher_id' => 'nullable|exists:teachers,id',
            'type' => 'required|in:entry,exit',
            'scheduled_time' => 'required|date_format:H:i',
            'reason' => 'nullable|string|max:500',
        ]);

        $validated['status'] = 'pending';
        $validated['validation_code'] = Str::upper(Str::random(8));
        $validated['expires_at'] = now()->addHours(4);

        $authorization = Authorization::create($validated);

        $this->notificationService->sendAuthorizationRequest($authorization);

        return redirect()->route('authorizations.show', $authorization)
            ->with('success', 'Autorizacao solicitada com sucesso! Notificacao registrada para o professor responsavel do dia.');
    }

    public function show(Authorization $authorization)
    {
        $authorization->load(['student', 'guardian', 'teacher', 'notifications']);

        return view('authorizations.show', compact('authorization'));
    }

    public function authorize(Authorization $authorization)
    {
        if ($authorization->status !== 'pending') {
            return back()->with('error', 'Esta autorizacao nao esta pendente.');
        }

        $authorization->update([
            'status' => 'authorized',
            'authorized_at' => now(),
        ]);

        return back()->with('success', 'Autorizacao concedida com sucesso!');
    }

    public function reject(Request $request, Authorization $authorization)
    {
        $validated = $request->validate([
            'rejection_reason' => 'required|string|max:500',
        ]);

        $authorization->update([
            'status' => 'rejected',
            'rejection_reason' => $validated['rejection_reason'],
        ]);

        $this->notificationService->sendRejectionNotification($authorization);

        return back()->with('success', 'Autorizacao rejeitada. Notificacao registrada.');
    }

    public function validate(Request $request, Authorization $authorization)
    {
        if ($authorization->status !== 'authorized') {
            return response()->json(['error' => 'Autorizacao nao esta autorizada'], 400);
        }

        if ($authorization->expires_at < now()) {
            return response()->json(['error' => 'Autorizacao expirada'], 400);
        }

        $authorization->update([
            'status' => 'used',
            'validated_at' => now(),
        ]);

        if ($authorization->type === 'entry') {
            $this->notificationService->sendEntryNotification($authorization);
        } else {
            $this->notificationService->sendExitNotification($authorization);
        }

        return response()->json([
            'success' => true,
            'message' => 'Autorizacao validada com sucesso!',
            'student' => $authorization->student->name,
            'type' => $authorization->type,
        ]);
    }

    public function history()
    {
        $authorizations = Authorization::where('status', 'used')
            ->with(['student', 'guardian'])
            ->latest('validated_at')
            ->paginate(20);

        return view('authorizations.history', compact('authorizations'));
    }

    public function getByCode($code)
    {
        $authorization = Authorization::where('validation_code', Str::upper($code))
            ->with(['student', 'guardian'])
            ->first();

        if (!$authorization) {
            return response()->json(['error' => 'Autorizacao nao encontrada'], 404);
        }

        if ($authorization->expires_at < now()) {
            return response()->json(['error' => 'Autorizacao expirada'], 400);
        }

        return response()->json($authorization);
    }
}
