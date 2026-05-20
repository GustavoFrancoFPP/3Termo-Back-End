@extends('layouts.app')

@section('content')
<div class="page-header">
    <h1><i class="bi bi-house-fill me-2"></i>Dashboard</h1>
    <p class="text-muted">Bem-vindo ao Sistema SAFE - Autorização e Fluxo Escolar</p>
</div>

<!-- Statistics -->
<div class="row mb-4">
    <div class="col-md-3 mb-3">
        <div class="stat-card">
            <div class="stat-number text-warning">{{ $stats['pending_authorizations'] }}</div>
            <div class="stat-label">Autorizações Pendentes</div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="stat-card">
            <div class="stat-number text-success">{{ $stats['authorized_today'] }}</div>
            <div class="stat-label">Autorizadas Hoje</div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="stat-card">
            <div class="stat-number text-info">{{ $stats['total_entries_today'] }}</div>
            <div class="stat-label">Entradas Hoje</div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="stat-card">
            <div class="stat-number text-primary">{{ $stats['total_exits_today'] }}</div>
            <div class="stat-label">Saídas Hoje</div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Recent Authorizations -->
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="bi bi-clock-history me-2"></i>Autorizações Recentes</h5>
            </div>
            <div class="card-body">
                @if($recent_authorizations->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Aluno</th>
                                    <th>Professor do dia</th>
                                    <th>Tipo</th>
                                    <th>Horario</th>
                                    <th>Status</th>
                                    <th>Data</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recent_authorizations as $auth)
                                    <tr>
                                        <td>{{ $auth->student->name }}</td>
                                        <td>{{ $auth->guardian->name }}</td>
                                        <td>
                                            @if($auth->type === 'entry')
                                                <span class="badge bg-info">Entrada</span>
                                            @else
                                                <span class="badge bg-warning">Saída</span>
                                            @endif
                                        </td>
                                        <td>{{ $auth->scheduled_time_formatted }}</td>
                                        <td>
                                            @switch($auth->status)
                                                @case('pending')
                                                    <span class="status-badge status-pending">Pendente</span>
                                                    @break
                                                @case('authorized')
                                                    <span class="status-badge status-authorized">Autorizada</span>
                                                    @break
                                                @case('rejected')
                                                    <span class="status-badge status-rejected">Rejeitada</span>
                                                    @break
                                                @case('used')
                                                    <span class="status-badge status-used">Usada</span>
                                                    @break
                                            @endswitch
                                        </td>
                                        <td>{{ $auth->validated_at?->format('d/m/Y H:i') ?? $auth->created_at->format('d/m/Y H:i') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="alert alert-info">
                        <i class="bi bi-info-circle me-2"></i>Nenhuma autorização encontrada
                    </div>
                @endif
            </div>
            <div class="card-footer text-end">
                <a href="{{ route('authorizations.index') }}" class="btn btn-sm btn-primary">
                    Ver todas <i class="bi bi-arrow-right ms-1"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Notification Stats -->
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="bi bi-bell me-2"></i>Status de Notificações</h5>
            </div>
            <div class="card-body">
                <div class="notification-item">
                    <div class="d-flex justify-content-between align-items-center">
                        <span><i class="bi bi-check-circle text-success me-2"></i>Enviadas</span>
                        <strong class="text-success">{{ $notifications_status['sent'] }}</strong>
                    </div>
                </div>
                <div class="notification-item">
                    <div class="d-flex justify-content-between align-items-center">
                        <span><i class="bi bi-hourglass-split text-warning me-2"></i>Pendentes</span>
                        <strong class="text-warning">{{ $notifications_status['pending'] }}</strong>
                    </div>
                </div>
                <div class="notification-item">
                    <div class="d-flex justify-content-between align-items-center">
                        <span><i class="bi bi-exclamation-circle text-danger me-2"></i>Falhas</span>
                        <strong class="text-danger">{{ $notifications_status['failed'] }}</strong>
                    </div>
                </div>
            </div>
            <div class="card-footer text-end">
                <a href="{{ route('notifications.index') }}" class="btn btn-sm btn-primary">
                    Detalhes <i class="bi bi-arrow-right ms-1"></i>
                </a>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="bi bi-lightning-fill me-2"></i>Ações Rápidas</h5>
            </div>
            <div class="card-body d-grid gap-2">
                <a href="{{ route('authorizations.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle me-2"></i>Nova Autorização
                </a>
                <a href="{{ route('students.create') }}" class="btn btn-outline-primary">
                    <i class="bi bi-person-plus me-2"></i>Cadastrar Aluno
                </a>
                <a href="{{ route('guardians.create') }}" class="btn btn-outline-primary">
                    <i class="bi bi-person-fill-add me-2"></i>Cadastrar Professor
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
