@extends('layouts.app')

@section('content')
<div class="page-header">
    <h1><i class="bi bi-info-circle me-2"></i>Detalhes da Autorização</h1>
    <p class="text-muted">ID: {{ $authorization->id }} | Código: {{ $authorization->validation_code }}</p>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Informações da Autorização</h5>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label class="form-label"><strong>Status</strong></label>
                        <p>
                            @switch($authorization->status)
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
                        </p>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label"><strong>Tipo</strong></label>
                        <p>
                            @if($authorization->type === 'entry')
                                <span class="badge bg-success">Entrada</span>
                            @else
                                <span class="badge bg-warning">Saída</span>
                            @endif
                        </p>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label"><strong>{{ $authorization->scheduled_time_label }}</strong></label>
                        <p>{{ $authorization->scheduled_time_formatted }}</p>
                    </div>
                </div>

                <hr>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label"><strong>Aluno</strong></label>
                        <p>
                            {{ $authorization->student->name }}<br>
                            <small class="text-muted">Matrícula: {{ $authorization->student->registration }}</small><br>
                            <small class="text-muted">Classe: {{ $authorization->student->class }}</small>
                        </p>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label"><strong>Professor do dia</strong></label>
                        <p>
                            {{ $authorization->guardian->name }}<br>
                            <small class="text-muted">Email: {{ $authorization->guardian->email }}</small><br>
                            <small class="text-muted">Tel: {{ $authorization->guardian->phone }}</small>
                        </p>
                    </div>
                </div>

                @if($authorization->teacher)
                    <div class="mb-3">
                        <label class="form-label"><strong>Professor</strong></label>
                        <p>{{ $authorization->teacher->name }} ({{ $authorization->teacher->class }})</p>
                    </div>
                @endif

                @if($authorization->reason)
                    <div class="mb-3">
                        <label class="form-label"><strong>Motivo</strong></label>
                        <p>{{ $authorization->reason }}</p>
                    </div>
                @endif

                <hr>

                <div class="row">
                    <div class="col-md-6">
                        <label class="form-label"><strong>Solicitada em</strong></label>
                        <p>{{ $authorization->created_at->format('d/m/Y H:i:s') }}</p>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label"><strong>Expira em</strong></label>
                        <p>
                            {{ $authorization->expires_at->format('d/m/Y H:i:s') }}
                            @if($authorization->expires_at < now())
                                <br><small class="text-danger"><i class="bi bi-exclamation-triangle me-1"></i>Expirada</small>
                            @else
                                <br><small class="text-success"><i class="bi bi-check-circle me-1"></i>{{ $authorization->expires_at->diffForHumans() }}</small>
                            @endif
                        </p>
                    </div>
                </div>

                @if($authorization->status === 'authorized')
                    <hr>
                    <div class="row">
                        <div class="col-md-6">
                            <label class="form-label"><strong>Autorizada em</strong></label>
                            <p>{{ $authorization->authorized_at?->format('d/m/Y H:i:s') ?? 'Não' }}</p>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label"><strong>Validada em</strong></label>
                            <p>{{ $authorization->validated_at?->format('d/m/Y H:i:s') ?? 'Ainda não' }}</p>
                        </div>
                    </div>
                @endif

                @if($authorization->status === 'rejected')
                    <hr>
                    <div class="alert alert-danger">
                        <strong><i class="bi bi-x-circle me-2"></i>Motivo da Rejeição:</strong>
                        <p class="mb-0 mt-2">{{ $authorization->rejection_reason }}</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Notificações -->
        @if($authorization->notifications->count() > 0)
            <div class="card">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0"><i class="bi bi-bell me-2"></i>Histórico de Notificações</h5>
                </div>
                <div class="card-body">
                    @foreach($authorization->notifications as $notification)
                        <div class="notification-item">
                            <div class="row">
                                <div class="col-md-8">
                                    <strong>{{ ucfirst($notification->type) }}</strong> via <strong>{{ strtoupper($notification->channel) }}</strong><br>
                                    <small class="text-muted">{{ $notification->created_at->format('d/m/Y H:i:s') }}</small>
                                </div>
                                <div class="col-md-4 text-end">
                                    @if($notification->status === 'sent')
                                        <span class="badge bg-success">Enviada</span>
                                    @elseif($notification->status === 'failed')
                                        <span class="badge bg-danger">Falha</span>
                                    @else
                                        <span class="badge bg-secondary">Pendente</span>
                                    @endif
                                </div>
                            </div>
                            <small class="text-muted d-block mt-2">{{ $notification->message }}</small>
                            @if($notification->error_message)
                                <small class="text-danger d-block mt-1">Erro: {{ $notification->error_message }}</small>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>

    <div class="col-md-4">
        <!-- Actions -->
        @if($authorization->status === 'pending')
            <div class="card mb-4">
                <div class="card-header bg-warning text-dark">
                    <h5 class="mb-0"><i class="bi bi-question-circle me-2"></i>Ações Disponíveis</h5>
                </div>
                <div class="card-body d-grid gap-2">
                    <form action="{{ route('authorizations.authorize', $authorization) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-success w-100">
                            <i class="bi bi-check-circle me-2"></i>Autorizar
                        </button>
                    </form>
                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#rejectModal">
                        <i class="bi bi-x-circle me-2"></i>Rejeitar
                    </button>
                </div>
            </div>
        @endif

        <!-- Details Card -->
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="bi bi-receipt me-2"></i>Detalhes Técnicos</h5>
            </div>
            <div class="card-body">
                <label class="form-label"><strong>Código de Validação</strong></label>
                <p><code>{{ $authorization->validation_code }}</code></p>

                <label class="form-label"><strong>ID da Autorização</strong></label>
                <p><code>{{ $authorization->id }}</code></p>

                <label class="form-label"><strong>Tempo Restante</strong></label>
                <p>
                    @if($authorization->expires_at > now())
                        <span class="badge bg-success">{{ $authorization->expires_at->diffForHumans() }}</span>
                    @else
                        <span class="badge bg-danger">Expirada</span>
                    @endif
                </p>
            </div>
        </div>
    </div>
</div>

<!-- Reject Modal -->
<div class="modal fade" id="rejectModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">Rejeitar Autorização</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('authorizations.reject', $authorization) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="rejection_reason" class="form-label">Motivo da Rejeição <span class="text-danger">*</span></label>
                        <textarea name="rejection_reason" id="rejection_reason" class="form-control" rows="4" required placeholder="Explique por que a autorização está sendo rejeitada"></textarea>
                    </div>
                    <p class="text-muted"><i class="bi bi-info-circle me-2"></i>O professor do dia sera notificado com este motivo.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-danger">
                        <i class="bi bi-x-circle me-2"></i>Rejeitar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="mt-4">
    <a href="{{ route('authorizations.index') }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left me-2"></i>Voltar
    </a>
</div>
@endsection
