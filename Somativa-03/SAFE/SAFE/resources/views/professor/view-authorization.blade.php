@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-md-8">
            <h1 class="h2 text-senai-blue">
                <i class="fas fa-clipboard-check me-2"></i>Analisar Autorização
            </h1>
            <p class="text-muted">Código: <code>{{ $authorization->validation_code }}</code></p>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('professor.list-authorizations') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i>Voltar
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header bg-senai-blue text-white py-3">
                    <h5 class="m-0 font-weight-bold">
                        <i class="fas fa-info-circle me-2"></i>Dados da Solicitação
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label class="form-label">Aluno</label>
                            <p class="mb-0">
                                <strong>{{ $authorization->student?->name ?? 'Aluno removido' }}</strong><br>
                                <small class="text-muted">Matrícula: {{ $authorization->student?->registration ?? '-' }}</small><br>
                                <small class="text-muted">Turma: {{ $authorization->student?->class ?? '-' }}</small>
                            </p>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Professor do dia</label>
                            <p class="mb-0">
                                <strong>{{ $authorization->guardian?->name ?? '-' }}</strong><br>
                                <small class="text-muted">{{ $authorization->guardian?->relationship ?? 'Professor do dia' }}</small><br>
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
                            <label class="form-label">Expiração</label>
                            <p>
                                {{ $authorization->expires_at->format('d/m/Y H:i') }}
                                @if($authorization->expires_at->isPast())
                                    <br><small class="text-danger">Expirada</small>
                                @else
                                    <br><small class="text-success">{{ $authorization->expires_at->diffForHumans() }}</small>
                                @endif
                            </p>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Motivo</label>
                        <p class="mb-0">{{ $authorization->reason ?: 'Não informado.' }}</p>
                    </div>

                    @if($authorization->professor_notes)
                        <div class="alert alert-info mb-0">
                            <strong>Observações do professor:</strong>
                            <p class="mb-0 mt-2">{{ $authorization->professor_notes }}</p>
                        </div>
                    @endif

                    @if($authorization->rejection_reason)
                        <div class="alert alert-danger mt-3 mb-0">
                            <strong>Motivo da rejeição:</strong>
                            <p class="mb-0 mt-2">{{ $authorization->rejection_reason }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            @if($authorization->status === 'pending')
                <div class="card shadow mb-4">
                    <div class="card-header bg-senai-green text-white py-3">
                        <h5 class="m-0 font-weight-bold">
                            <i class="fas fa-check me-2"></i>Aprovar
                        </h5>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('professor.approve-authorization', $authorization->id) }}">
                            @csrf
                            <div class="mb-3">
                                <label for="approve_notes" class="form-label">Observações</label>
                                <textarea id="approve_notes" name="notes" class="form-control" rows="3" placeholder="Opcional"></textarea>
                            </div>
                            <button type="submit" class="btn btn-success w-100">
                                <i class="fas fa-check-circle me-2"></i>Aprovar Autorização
                            </button>
                        </form>
                    </div>
                </div>

                <div class="card shadow">
                    <div class="card-header bg-danger text-white py-3">
                        <h5 class="m-0 font-weight-bold">
                            <i class="fas fa-times me-2"></i>Rejeitar
                        </h5>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('professor.reject-authorization', $authorization->id) }}">
                            @csrf
                            <div class="mb-3">
                                <label for="rejection_reason" class="form-label">Motivo da rejeição</label>
                                <textarea id="rejection_reason" name="rejection_reason" class="form-control" rows="3" required></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="reject_notes" class="form-label">Observações internas</label>
                                <textarea id="reject_notes" name="notes" class="form-control" rows="2" placeholder="Opcional"></textarea>
                            </div>
                            <button type="submit" class="btn btn-danger w-100">
                                <i class="fas fa-times-circle me-2"></i>Rejeitar Autorização
                            </button>
                        </form>
                    </div>
                </div>
            @else
                <div class="card shadow">
                    <div class="card-header bg-senai-light py-3">
                        <h5 class="m-0 font-weight-bold text-senai-blue">
                            <i class="fas fa-clock me-2"></i>Análise Registrada
                        </h5>
                    </div>
                    <div class="card-body">
                        <p class="mb-2">
                            <strong>Decisão:</strong> {{ $authorization->professor_decision === 'approved' ? 'Aprovada' : ($authorization->professor_decision === 'rejected' ? 'Rejeitada' : 'Não informada') }}
                        </p>
                        <p class="mb-0">
                            <strong>Data:</strong> {{ $authorization->analyzed_by_professor_at?->format('d/m/Y H:i') ?? '-' }}
                        </p>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
