@extends('layouts.app')

@section('content')
<div class="page-header">
    <h1><i class="bi bi-bell me-2"></i>Notificações</h1>
    <p class="text-muted">Histórico e status de todas as notificações enviadas</p>
</div>

<!-- Filters -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" class="row g-3">
            <div class="col-md-4">
                <label for="status" class="form-label">Status</label>
                <select name="status" id="status" class="form-control">
                    <option value="">-- Todos --</option>
                    <option value="sent" {{ request('status') === 'sent' ? 'selected' : '' }}>Enviadas</option>
                    <option value="failed" {{ request('status') === 'failed' ? 'selected' : '' }}>Falhas</option>
                    <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pendentes</option>
                </select>
            </div>
            <div class="col-md-4">
                <label for="channel" class="form-label">Canal</label>
                <select name="channel" id="channel" class="form-control">
                    <option value="">-- Todos --</option>
                    <option value="email" {{ request('channel') === 'email' ? 'selected' : '' }}>Email</option>
                    <option value="log" {{ request('channel') === 'log' ? 'selected' : '' }}>Log</option>
                </select>
            </div>
            <div class="col-md-4">
                <label for="type" class="form-label">Tipo</label>
                <select name="type" id="type" class="form-control">
                    <option value="">-- Todos --</option>
                    <option value="authorization_request" {{ request('type') === 'authorization_request' ? 'selected' : '' }}>Solicitação</option>
                    <option value="entry_notification" {{ request('type') === 'entry_notification' ? 'selected' : '' }}>Entrada</option>
                    <option value="exit_notification" {{ request('type') === 'exit_notification' ? 'selected' : '' }}>Saída</option>
                    <option value="rejection_notification" {{ request('type') === 'rejection_notification' ? 'selected' : '' }}>Rejeição</option>
                </select>
            </div>
            <div class="col-12">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-search me-2"></i>Filtrar
                </button>
                <a href="{{ route('notifications.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-clockwise me-2"></i>Limpar
                </a>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-body">
        @if($notifications->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>Professor do dia</th>
                            <th>Aluno</th>
                            <th>Tipo</th>
                            <th>Canal</th>
                            <th>Status</th>
                            <th>Enviada em</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($notifications as $notif)
                            <tr>
                                <td>{{ $notif->guardian->name }}</td>
                                <td>
                                    {{ $notif->authorization->student->name }}<br>
                                    <small class="text-muted">{{ $notif->authorization->student->registration }}</small>
                                </td>
                                <td>
                                    @switch($notif->type)
                                        @case('authorization_request')
                                            <span class="badge bg-warning">Solicitação</span>
                                            @break
                                        @case('entry_notification')
                                            <span class="badge bg-success">Entrada</span>
                                            @break
                                        @case('exit_notification')
                                            <span class="badge bg-info">Saída</span>
                                            @break
                                        @case('rejection_notification')
                                            <span class="badge bg-danger">Rejeição</span>
                                            @break
                                    @endswitch
                                </td>
                                <td>
                                    @if($notif->channel === 'email')
                                        <i class="bi bi-envelope me-1"></i>Email
                                    @elseif($notif->channel === 'log')
                                        <i class="bi bi-file-text me-1"></i>Log
                                    @else
                                        {{ $notif->channel }}
                                    @endif
                                </td>
                                <td>
                                    @if($notif->status === 'sent')
                                        <span class="badge bg-success"><i class="bi bi-check-circle me-1"></i>Enviada</span>
                                    @elseif($notif->status === 'failed')
                                        <span class="badge bg-danger"><i class="bi bi-x-circle me-1"></i>Falha</span>
                                    @else
                                        <span class="badge bg-secondary"><i class="bi bi-hourglass-split me-1"></i>Pendente</span>
                                    @endif
                                </td>
                                <td><small>{{ $notif->sent_at?->format('d/m H:i') ?? '--' }}</small></td>
                                <td>
                                    <a href="{{ route('notifications.show', $notif) }}" class="btn btn-sm btn-info">
                                        <i class="bi bi-eye me-1"></i>Ver
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            {{ $notifications->links() }}
        @else
            <div class="alert alert-info" role="alert">
                <i class="bi bi-info-circle me-2"></i>
                <strong>Nenhuma notificação encontrada!</strong>
            </div>
        @endif
    </div>
</div>

<div class="mt-4">
    <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left me-2"></i>Voltar ao Dashboard
    </a>
</div>
@endsection
