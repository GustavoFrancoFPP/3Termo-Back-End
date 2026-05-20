@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-md-8">
            <h1 class="h2 text-senai-blue">
                <i class="fas fa-users me-2"></i>Meus Alunos
            </h1>
            <p class="text-muted">Alunos vinculados às suas salas.</p>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('professor.dashboard') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i>Voltar
            </a>
        </div>
    </div>

    <div class="row mb-4">
        @forelse($classrooms as $classroom)
            <div class="col-md-4 mb-3">
                <div class="card border-left-senai-blue h-100">
                    <div class="card-body">
                        <h5 class="text-senai-blue">{{ $classroom->code }}</h5>
                        <p class="mb-1"><strong>{{ $classroom->name }}</strong></p>
                        <small class="text-muted">{{ $classroom->location }} | Capacidade: {{ $classroom->capacity }}</small>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-warning mb-0">
                    Você ainda não está vinculado a nenhuma sala.
                </div>
            </div>
        @endforelse
    </div>

    <div class="card shadow">
        <div class="card-header bg-senai-blue text-white py-3">
            <h5 class="m-0 font-weight-bold">
                <i class="fas fa-user-graduate me-2"></i>Lista de Alunos
            </h5>
        </div>
        <div class="card-body">
            @if($students->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Aluno</th>
                                <th>Turma</th>
                                <th>Professor padrão</th>
                                <th>Status</th>
                                <th>Observações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($students as $student)
                                <tr>
                                    <td>
                                        <strong>{{ $student->name }}</strong><br>
                                        <small class="text-muted">{{ $student->registration }}</small>
                                    </td>
                                    <td>{{ $student->class }}</td>
                                    <td>
                                        {{ $student->guardian?->name ?? '-' }}<br>
                                        <small class="text-muted">{{ $student->guardian?->phone ?? '' }}</small>
                                    </td>
                                    <td>
                                        @if($student->is_active)
                                            <span class="badge bg-success">Ativo</span>
                                        @else
                                            <span class="badge bg-secondary">Inativo</span>
                                        @endif
                                    </td>
                                    <td>{{ $student->observations ?: '-' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-muted text-center py-4 mb-0">
                    <i class="fas fa-inbox me-2"></i>Nenhum aluno encontrado para suas salas.
                </p>
            @endif
        </div>
    </div>
</div>
@endsection
