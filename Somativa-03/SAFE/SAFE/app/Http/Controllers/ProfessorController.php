<?php

namespace App\Http\Controllers;

use App\Models\Authorization;
use App\Models\Classroom;
use App\Models\Student;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Services\NotificationService;

class ProfessorController extends Controller
{
    public function __construct(
        private NotificationService $notificationService
    ) {}

    /**
     * Dashboard do Professor.
     */
    public function dashboard()
    {
        $professor = auth()->user();
        
        // Pegar as salas do professor
        $classrooms = $professor->classrooms()->get();
        
        // Pegar alunos das salas do professor
        $students = Student::whereIn('class', $classrooms->pluck('name'))->get();
        
        // Autorizações pendentes para análise
        $pendingAuthorizations = Authorization::where('professor_id', $professor->id)
            ->where('status', 'pending')
            ->with(['student', 'guardian', 'admin'])
            ->orderBy('created_at', 'desc')
            ->get();

        // Autorizações analisadas hoje
        $analyzedToday = Authorization::where('professor_id', $professor->id)
            ->whereDate('analyzed_by_professor_at', today())
            ->count();

        return view('professor.dashboard', compact([
            'professor',
            'classrooms',
            'students',
            'pendingAuthorizations',
            'analyzedToday',
        ]));
    }

    /**
     * Ver detalhes de autorização para análise.
     */
    public function viewAuthorization($id)
    {
        $authorization = Authorization::with([
            'student', 'guardian', 'admin'
        ])->findOrFail($id);

        // Verificar se pertence ao professor
        if ($authorization->professor_id !== auth()->id()) {
            abort(403, 'Você não tem permissão para ver esta autorização.');
        }

        return view('professor.view-authorization', compact('authorization'));
    }

    /**
     * Autorizar solicitação.
     */
    public function approveAuthorization(Request $request, $id)
    {
        $authorization = Authorization::findOrFail($id);

        if ($authorization->professor_id !== auth()->id()) {
            abort(403);
        }

        $authorization->update([
            'professor_decision' => 'approved',
            'professor_notes' => $request->input('notes'),
            'analyzed_by_professor_at' => now(),
            'status' => 'authorized',
            'authorized_at' => now(),
        ]);

        return redirect("/professor/authorizations/{$id}")->with('success', 'Autorização aprovada!');
    }

    /**
     * Rejeitar solicitação.
     */
    public function rejectAuthorization(Request $request, $id)
    {
        $validated = $request->validate([
            'rejection_reason' => 'required|string|max:255',
        ]);

        $authorization = Authorization::findOrFail($id);

        if ($authorization->professor_id !== auth()->id()) {
            abort(403);
        }

        $authorization->update([
            'professor_decision' => 'rejected',
            'professor_notes' => $request->input('notes'),
            'analyzed_by_professor_at' => now(),
            'status' => 'rejected',
            'rejection_reason' => $validated['rejection_reason'],
        ]);

        $this->notificationService->sendRejectionNotification($authorization->fresh(['student', 'guardian']));

        return redirect("/professor/authorizations")->with('success', 'Autorizacao rejeitada e notificacao registrada!');
    }

    /**
     * Listar autorizações do professor.
     */
    public function listAuthorizations()
    {
        $professor = auth()->user();
        
        $authorizations = Authorization::where('professor_id', $professor->id)
            ->with(['student', 'guardian', 'admin'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('professor.list-authorizations', compact('authorizations'));
    }

    /**
     * Listar alunos do professor.
     */
    public function students()
    {
        $professor = auth()->user();
        $classrooms = $professor->classrooms()->get();
        $students = Student::whereIn('class', $classrooms->pluck('name'))->with('guardian')->get();

        return view('professor.students', compact(['classrooms', 'students']));
    }
}
