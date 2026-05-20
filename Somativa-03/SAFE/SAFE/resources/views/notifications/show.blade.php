@extends('layouts.app')

@section('content')
<div class="page-header">
    <h1><i class="bi bi-envelope-open me-2"></i>Detalhes da Notificação</h1>
    <p class="text-muted">ID: {{ $notification->id }}</p>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Conteúdo da Notificação</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label"><strong>Mensagem</strong></label>
                    <div class="p-3 bg-light border rounded">
                        <pre style="margin: 0; white-space: pre-wrap;">{{ $notification->message }}</pre>
                    </div>
                </div>

                @if($notification->response)
                    <div class="mb-3">
                        <label class="form-label"><strong>Resposta</strong></label>
                        <div class="p-3 bg-light border rounded">
                            <pre style="margin: 0; white-space: pre-wrap;">{{ $notification->response }}</pre>
                        </div>
                    </div>
                @endif

                @if($notification->error_message)
                    <div class="alert alert-danger">
                        <strong><i class="bi bi-exclamation-triangle me-2"></i>Erro:</strong>
                        <p class="mb-0 mt-2">{{ $notification->error_message }}</p>
                    </div>
                @endif
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Informações da Autorização</h5>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label"><strong>Aluno</strong></label>
                        <p>
                            {{ $notification->authorization->student->name }}<br>
                            <small class="text-muted">{{ $notification->authorization->student->registration }}</small>
                        </p>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label"><strong>Tipo de Autorização</strong></label>
                        <p>
                            @if($notification->authorization->type === 'entry')
                                <span class="badge bg-success">Entrada</span>
                            @else
                                <span class="badge bg-info">Saída</span>
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Status</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label"><strong>Status Atual</strong></label>
                    <p>
                        @if($notification->status === 'sent')
                            <span class="badge bg-success fs-6"><i class="bi bi-check-circle me-2"></i>Enviada com Sucesso</span>
                        @elseif($notification->status === 'failed')
                            <span class="badge bg-danger fs-6"><i class="bi bi-x-circle me-2"></i>Falha no Envio</span>
                        @else
                            <span class="badge bg-secondary fs-6"><i class="bi bi-hourglass-split me-2"></i>Pendente</span>
                        @endif
                    </p>
                </div>

                <label class="form-label"><strong>Tipo de Notificação</strong></label>
                <p>
                    @switch($notification->type)
                        @case('authorization_request')
                            Solicitação de Autorização
                            @break
                        @case('entry_notification')
                            Notificação de Entrada
                            @break
                        @case('exit_notification')
                            Notificação de Saída
                            @break
                        @case('rejection_notification')
                            Notificação de Rejeição
                            @break
                    @endswitch
                </p>

                <label class="form-label"><strong>Canal</strong></label>
                <p>
                    @if($notification->channel === 'email')
                        <i class="bi bi-envelope me-1"></i>Email
                    @elseif($notification->channel === 'log')
                        <i class="bi bi-file-text me-1"></i>Log/Auditoria
                    @else
                        {{ $notification->channel }}
                    @endif
                </p>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Informações do Professor do Dia</h5>
            </div>
            <div class="card-body">
                <label class="form-label"><strong>Nome</strong></label>
                <p>{{ $notification->guardian->name }}</p>

                <label class="form-label"><strong>Email</strong></label>
                <p><a href="mailto:{{ $notification->guardian->email }}">{{ $notification->guardian->email }}</a></p>

                <label class="form-label"><strong>Telefone</strong></label>
                <p>{{ $notification->guardian->phone }}</p>
            </div>
        </div>

        <div class="card mt-4">
            <div class="card-header">
                <h5 class="mb-0">Cronograma</h5>
            </div>
            <div class="card-body">
                <label class="form-label"><strong>Criada em</strong></label>
                <p>{{ $notification->created_at->format('d/m/Y H:i:s') }}</p>

                <label class="form-label"><strong>Enviada em</strong></label>
                <p>{{ $notification->sent_at?->format('d/m/Y H:i:s') ?? 'Ainda não enviada' }}</p>

                @if($notification->sent_at)
                    <label class="form-label"><strong>Tempo até envio</strong></label>
                    <p>{{ $notification->created_at->diffInSeconds($notification->sent_at) }} segundos</p>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="mt-4">
    <a href="{{ route('notifications.index') }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left me-2"></i>Voltar
    </a>
    <a href="{{ route('authorizations.show', $notification->authorization) }}" class="btn btn-outline-primary">
        <i class="bi bi-file-earmark me-2"></i>Ver Autorização Relacionada
    </a>
</div>
@endsection
