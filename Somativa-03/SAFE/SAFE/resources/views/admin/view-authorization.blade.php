@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-md-8">
            <h1 class="h2 text-senai-blue">
                <i class="fas fa-file-alt me-2"></i>Detalhes da Autorização
            </h1>
            <p class="text-muted">Código: <code>{{ $authorization->validation_code }}</code></p>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('admin.list-authorizations') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i>Voltar
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header bg-senai-blue text-white py-3">
                    <h5 class="m-0 font-weight-bold">
                        <i class="fas fa-info-circle me-2"></i>Informações Principais
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label class="form-label">Aluno</label>
                            <p>
                                <strong>{{ $authorization->student?->name ?? 'Aluno removido' }}</strong><br>
                                <small class="text-muted">Matrícula: {{ $authorization->student?->registration ?? '-' }}</small><br>
                                <small class="text-muted">Turma: {{ $authorization->student?->class ?? '-' }}</small>
                            </p>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Professor do dia</label>
                            <p>
                                <strong>{{ $authorization->guardian?->name ?? '-' }}</strong><br>
                                <small class="text-muted">{{ $authorization->guardian?->email ?? '-' }}</small><br>
                                <small class="text-muted">{{ $authorization->guardian?->phone ?? '-' }}</small>
                            </p>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-3">
                            <label class="form-label">Tipo</label>
                            <p>
                                @if($authorization->type === 'entry')
                                    <span class="badge badge-senai-blue">Entrada</span>
                                @else
                                    <span class="badge badge-senai-orange">Saída</span>
                                @endif
                            </p>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">{{ $authorization->scheduled_time_label }}</label>
                            <p>{{ $authorization->scheduled_time_formatted }}</p>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Status</label>
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
                        <div class="col-md-3">
                            <label class="form-label">Expira em</label>
                            <p>{{ $authorization->expires_at->format('d/m/Y H:i') }}</p>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Motivo</label>
                        <p class="mb-0">{{ $authorization->reason ?: 'Não informado.' }}</p>
                    </div>

                    @if($authorization->rejection_reason)
                        <div class="alert alert-danger mb-0">
                            <strong>Motivo da rejeição:</strong>
                            <p class="mb-0 mt-2">{{ $authorization->rejection_reason }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card shadow mb-4">
                <div class="card-header bg-senai-light py-3">
                    <h5 class="m-0 font-weight-bold text-senai-blue">
                        <i class="fas fa-route me-2"></i>Fluxo
                    </h5>
                </div>
                <div class="card-body">
                    <p><strong>Criada por:</strong> {{ $authorization->admin?->name ?? '-' }}</p>
                    <p><strong>Professor:</strong> {{ $authorization->professor?->name ?? '-' }}</p>
                    <p><strong>Criada em:</strong> {{ $authorization->created_at->format('d/m/Y H:i') }}</p>
                    <p><strong>Analisada em:</strong> {{ $authorization->analyzed_by_professor_at?->format('d/m/Y H:i') ?? '-' }}</p>
                    <p><strong>Autorizada em:</strong> {{ $authorization->authorized_at?->format('d/m/Y H:i') ?? '-' }}</p>
                    <p class="mb-0"><strong>Validada na portaria:</strong> {{ $authorization->checked_by_portaria_at?->format('d/m/Y H:i') ?? '-' }}</p>
                </div>
            </div>

            @if($authorization->notifications->count() > 0)
                <div class="card shadow">
                    <div class="card-header bg-senai-blue text-white py-3">
                        <h5 class="m-0 font-weight-bold">
                            <i class="fas fa-bell me-2"></i>Notificações
                        </h5>
                    </div>
                    <div class="card-body">
                        @foreach($authorization->notifications as $notification)
                            <div class="border-bottom pb-2 mb-2">
                                <strong>{{ ucfirst($notification->type) }}</strong>
                                <span class="badge bg-secondary">{{ $notification->status }}</span>
                                <small class="text-muted d-block">{{ $notification->created_at->format('d/m/Y H:i') }}</small>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
