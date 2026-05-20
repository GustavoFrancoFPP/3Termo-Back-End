<?php

namespace App\Http\Controllers;

use App\Models\Authorization;
use App\Models\Guardian;
use App\Models\Student;
use App\Models\User;
use App\Services\NotificationService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class AdminController extends Controller
{
    public function __construct(
        private NotificationService $notificationService
    ) {}

    public function dashboard()
    {
        $pendingCount = Authorization::where('status', 'pending')->count();
        $authorizedToday = Authorization::whereDate('authorized_at', today())
            ->where('status', '!=', 'pending')
            ->count();
        $totalAuthorizations = Authorization::count();

        $recentAuthorizations = Authorization::with(['student', 'guardian', 'professor'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        return view('admin.dashboard', compact([
            'pendingCount',
            'authorizedToday',
            'totalAuthorizations',
            'recentAuthorizations',
        ]));
    }

    public function createAuthorization()
    {
        $students = Student::all();
        $guardians = Guardian::orderBy('name')->get();
        $professors = User::where('role', 'professor')->orderBy('name')->get();

        return view('admin.create-authorization', compact('students', 'guardians', 'professors'));
    }

    public function storeAuthorization(Request $request)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'guardian_id' => 'required|exists:guardians,id',
            'professor_id' => [
                'required',
                Rule::exists('users', 'id')->where('role', 'professor'),
            ],
            'type' => 'required|in:entry,exit',
            'scheduled_time' => 'required|date_format:H:i',
            'reason' => 'nullable|string|max:500',
        ]);

        $validated['admin_id'] = auth()->id();
        $validated['status'] = 'pending';
        $validated['validation_code'] = Str::upper(Str::random(8));
        $validated['expires_at'] = Carbon::now()->addHours(4);

        $authorization = Authorization::create($validated);

        $this->notificationService->sendAuthorizationRequest($authorization);

        return redirect("/admin/authorizations/{$authorization->id}")
            ->with('success', 'Autorizacao criada e notificacao registrada com sucesso!');
    }

    public function listAuthorizations(Request $request)
    {
        $query = Authorization::with(['student', 'guardian', 'professor', 'admin']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        $authorizations = $query->orderBy('created_at', 'desc')->paginate(15);

        return view('admin.list-authorizations', compact('authorizations'));
    }

    public function viewAuthorization($id)
    {
        $authorization = Authorization::with([
            'student', 'guardian', 'professor', 'admin', 'notifications',
        ])->findOrFail($id);

        return view('admin.view-authorization', compact('authorization'));
    }
}
