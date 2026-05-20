@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-md-8">
            <h1 class="h2 text-senai-blue">
                <i class="fas fa-cog me-2"></i>Dashboard do Administrador
            </h1>
            <p class="text-muted">Bem-vindo, {{ auth()->user()->name }}!</p>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('admin.create-authorization') }}" class="btn btn-senai-primary">
                <i class="fas fa-plus me-2"></i>Nova Autorização
            </a>
        </div>
    </div>

    <!-- Estatísticas -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card border-left-senai-blue h-100">
                <div class="card-body">
                    <div class="text-senai-blue small font-weight-bold text-uppercase mb-1">
                        Pendentes
                    </div>
                    <div class="h3 mb-0 text-gray-800">{{ $pendingCount }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-left-senai-green h-100">
                <div class="card-body">
                    <div class="text-senai-green small font-weight-bold text-uppercase mb-1">
                        Autorizadas Hoje
                    </div>
                    <div class="h3 mb-0 text-gray-800">{{ $authorizedToday }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-left-senai-orange h-100">
                <div class="card-body">
                    <div class="text-senai-orange small font-weight-bold text-uppercase mb-1">
                        Total de Autorizações
                    </div>
                    <div class="h3 mb-0 text-gray-800">{{ $totalAuthorizations }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-left-senai-red h-100">
                <div class="card-body">
                    <div class="text-senai-red small font-weight-bold text-uppercase mb-1">
                        Função
                    </div>
                    <div class="h5 mb-0 text-gray-800 font-weight-bold">ADMINISTRADOR</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Autorizações Recentes -->
    <div class="card shadow mb-4">
        <div class="card-header bg-senai-blue text-white py-3">
            <h5 class="m-0 font-weight-bold">
                <i class="fas fa-history me-2"></i>Autorizações Recentes
            </h5>
        </div>
        <div class="card-body">
            @if($recentAuthorizations->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Aluno</th>
                                <th>Tipo</th>
                                <th>Horario</th>
                                <th>Professor</th>
                                <th>Status</th>
                                <th>Data</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentAuthorizations as $auth)
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
                                    <td>{{ $auth->professor?->name ?? '-' }}</td>
                                    <td>
                                        @if($auth->status === 'pending')
                                            <span class="badge bg-warning">Pendente</span>
                                        @elseif($auth->status === 'authorized')
                                            <span class="badge bg-info">Autorizada</span>
                                        @elseif($auth->status === 'used')
                                            <span class="badge bg-success">Utilizada</span>
                                        @else
                                            <span class="badge bg-danger">{{ $auth->status }}</span>
                                        @endif
                                    </td>
                                    <td>{{ $auth->created_at->format('d/m H:i') }}</td>
                                    <td>
                                        <a href="{{ route('admin.view-authorization', $auth->id) }}" class="btn btn-sm btn-outline-senai-blue">
                                            Ver
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-muted text-center py-4">
                    <i class="fas fa-inbox me-2"></i>Nenhuma autorização recente
                </p>
            @endif
        </div>
    </div>

    <!-- Ações Rápidas -->
    <div class="row">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-header bg-senai-green text-white py-3">
                    <h5 class="m-0 font-weight-bold">
                        <i class="fas fa-list me-2"></i>Gerenciamento
                    </h5>
                </div>
                <div class="card-body">
                    <a href="{{ route('admin.list-authorizations') }}" class="btn btn-outline-senai-green w-100 mb-2">
                        <i class="fas fa-list me-2"></i>Ver Todas as Autorizações
                    </a>
                    <a href="{{ route('students.index') }}" class="btn btn-outline-senai-green w-100 mb-2">
                        <i class="fas fa-user-graduate me-2"></i>Gerenciar Alunos
                    </a>
                    <a href="{{ route('guardians.index') }}" class="btn btn-outline-senai-green w-100">
                        <i class="fas fa-users me-2"></i>Gerenciar Professores do Dia
                    </a>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-header bg-senai-purple text-white py-3">
                    <h5 class="m-0 font-weight-bold">
                        <i class="fas fa-chart-bar me-2"></i>Relatórios
                    </h5>
                </div>
                <div class="card-body">
                    <a href="{{ route('notifications.index') }}" class="btn btn-outline-senai-purple w-100 mb-2">
                        <i class="fas fa-bell me-2"></i>Ver Notificações
                    </a>
                    <a href="{{ route('admin.list-authorizations') }}?status=authorized" class="btn btn-outline-senai-purple w-100 mb-2">
                        <i class="fas fa-check-circle me-2"></i>Autorizações Aprovadas
                    </a>
                    <a href="{{ route('admin.list-authorizations') }}?status=rejected" class="btn btn-outline-senai-purple w-100">
                        <i class="fas fa-times-circle me-2"></i>Autorizações Rejeitadas
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
