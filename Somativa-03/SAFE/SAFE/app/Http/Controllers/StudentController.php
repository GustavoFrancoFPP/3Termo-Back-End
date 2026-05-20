<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Guardian;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    /**
     * Listar todos os alunos
     */
    public function index()
    {
        $students = Student::with('guardian')->paginate(20);
        return view('students.index', compact('students'));
    }

    /**
     * Formulário para criar novo aluno
     */
    public function create()
    {
        $guardians = Guardian::all();
        $nextRegistration = $this->nextRegistration();

        return view('students.create', compact('guardians', 'nextRegistration'));
    }

    /**
     * Armazenar novo aluno
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'class' => 'required|string|max:50',
            'guardian_id' => 'nullable|exists:guardians,id',
            'observations' => 'nullable|string|max:1000',
        ]);

        $validated['registration'] = $this->nextRegistration();
        Student::create($validated);

        return redirect()->route('students.index')
            ->with('success', 'Aluno cadastrado com sucesso!');
    }

    /**
     * Exibir detalhes do aluno
     */
    public function show(Student $student)
    {
        $student->load(['guardian', 'authorizations']);
        return view('students.show', compact('student'));
    }

    /**
     * Formulário para editar aluno
     */
    public function edit(Student $student)
    {
        $guardians = Guardian::all();
        return view('students.edit', compact('student', 'guardians'));
    }

    /**
     * Atualizar aluno
     */
    public function update(Request $request, Student $student)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'class' => 'required|string|max:50',
            'guardian_id' => 'nullable|exists:guardians,id',
            'observations' => 'nullable|string|max:1000',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active');
        $student->update($validated);

        return redirect()->route('students.show', $student)
            ->with('success', 'Aluno atualizado com sucesso!');
    }

    /**
     * Deletar aluno
     */
    public function destroy(Student $student)
    {
        $student->delete();
        return redirect()->route('students.index')
            ->with('success', 'Aluno removido com sucesso!');
    }

    private function nextRegistration(): string
    {
        $highestNumber = Student::query()
            ->pluck('registration')
            ->map(function ($registration) {
                if (preg_match('/^ALU(\d+)$/i', (string) $registration, $matches)) {
                    return (int) $matches[1];
                }

                return 0;
            })
            ->max() ?? 0;

        $nextNumber = $highestNumber + 1;

        return 'ALU' . str_pad((string) $nextNumber, 3, '0', STR_PAD_LEFT);
    }
}
