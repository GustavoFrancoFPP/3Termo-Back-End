@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-md-8">
            <h1 class="h2 text-senai-blue">
                <i class="fas fa-chalkboard-user me-2"></i>Dashboard do Professor
            </h1>
            <p class="text-muted">Bem-vindo, {{ $professor->name }}!</p>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('professor.students') }}" class="btn btn-senai-primary me-2">
                <i class="fas fa-users me-2"></i>Meus Alunos
            </a>
        </div>
    </div>

    <!-- Estatísticas -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card border-left-senai-blue h-100">
                <div class="card-body">
                    <div class="text-senai-blue small font-weight-bold text-uppercase mb-1">
                        Pendentes de Análise
                    </div>
                    <div class="h3 mb-0 text-gray-800">{{ $pendingAuthorizations->count() }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-left-senai-green h-100">
                <div class="card-body">
                    <div class="text-senai-green small font-weight-bold text-uppercase mb-1">
                        Analisadas Hoje
                    </div>
                    <div class="h3 mb-0 text-gray-800">{{ $analyzedToday }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-left-senai-orange h-100">
                <div class="card-body">
                    <div class="text-senai-orange small font-weight-bold text-uppercase mb-1">
                        Total de Alunos
                    </div>
                    <div class="h3 mb-0 text-gray-800">{{ $students->count() }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-left-senai-purple h-100">
                <div class="card-body">
                    <div class="text-senai-purple small font-weight-bold text-uppercase mb-1">
                        Salas
                    </div>
                    <div class="h5 mb-0 text-gray-800 font-weight-bold">{{ $classrooms->count() }}</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Autorizações Pendentes de Análise -->
    <div class="card shadow mb-4">
        <div class="card-header bg-senai-blue text-white py-3">
            <h5 class="m-0 font-weight-bold">
                <i class="fas fa-inbox me-2"></i>Autorizações Aguardando Análise
            </h5>
        </div>
        <div class="card-body">
            @if($pendingAuthorizations->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Aluno</th>
                                <th>Tipo</th>
                                <th>Horario</th>
                                <th>Motivo</th>
                                <th>Professor do dia</th>
                                <th>Criada em</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pendingAuthorizations as $auth)
                                <tr>
                                    <td>
                                        <strong>{{ $auth->student->name }}</strong>
                                        <br>
                                        <small class="text-muted">{{ $auth->student->registration }}</small>
                                    </td>
                                    <td>
                                        @if($auth->type === 'entry')
                                            <span class="badge badge-senai-blue">Entrada</span>
                                        @else
                                            <span class="badge badge-senai-orange">Saída</span>
                                        @endif
                                    </td>
                                    <td>
                                        <small class="text-muted">{{ $auth->scheduled_time_label }}</small><br>
                                        <strong>{{ $auth->scheduled_time_formatted }}</strong>
                                    </td>
                                    <td>{{ $auth->reason ?? '-' }}</td>
                                    <td>{{ $auth->guardian->name }}</td>
                                    <td>{{ $auth->created_at->format('d/m H:i') }}</td>
                                    <td>
                                        <a href="{{ route('professor.view-authorization', $auth->id) }}" class="btn btn-sm btn-senai-primary">
                                            Analisar
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-muted text-center py-4">
                    <i class="fas fa-check-circle me-2"></i>Nenhuma autorização pendente!
                </p>
            @endif
        </div>
    </div>

    <!-- Minhas Salas -->
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-header bg-senai-green text-white py-3">
                    <h5 class="m-0 font-weight-bold">
                        <i class="fas fa-door-open me-2"></i>Minhas Salas
                    </h5>
                </div>
                <div class="card-body">
                    @if($classrooms->count() > 0)
                        <div class="list-group">
                            @foreach($classrooms as $classroom)
                                <div class="list-group-item">
                                    <div class="d-flex w-100 justify-content-between">
                                        <strong>{{ $classroom->name }}</strong>
                                        <small class="text-muted">{{ $classroom->code }}</small>
                                    </div>
                                    <small class="text-muted d-block">
                                        <i class="fas fa-map-marker-alt me-1"></i>{{ $classroom->location }}
                                    </small>
                                    <small class="text-muted d-block">
                                        <i class="fas fa-users me-1"></i>Capacidade: {{ $classroom->capacity }}
                                    </small>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-muted">Você não está vinculado a nenhuma sala.</p>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-header bg-senai-purple text-white py-3">
                    <h5 class="m-0 font-weight-bold">
                        <i class="fas fa-user-graduate me-2"></i>Ações Rápidas
                    </h5>
                </div>
                <div class="card-body">
                    <a href="{{ route('professor.list-authorizations') }}" class="btn btn-outline-senai-purple w-100 mb-2">
                        <i class="fas fa-list me-2"></i>Ver Todas as Autorizações
                    </a>
                    <a href="{{ route('professor.students') }}" class="btn btn-outline-senai-purple w-100 mb-2">
                        <i class="fas fa-users me-2"></i>Ver Todos os Alunos
                    </a>
                    <a href="{{ route('dashboard') }}" class="btn btn-outline-senai-purple w-100">
                        <i class="fas fa-chart-bar me-2"></i>Ver Relatórios
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
