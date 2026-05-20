@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-md-8">
            <h1 class="h2 text-senai-blue">
                <i class="fas fa-receipt me-2"></i>Detalhes da Validação
            </h1>
            <p class="text-muted">Código: <code>{{ $authorization->validation_code }}</code></p>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('portaria.list-validations') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i>Voltar
            </a>
        </div>
    </div>

    <div class="card shadow">
        <div class="card-header bg-senai-blue text-white py-3">
            <h5 class="m-0 font-weight-bold">
                <i class="fas fa-info-circle me-2"></i>Registro
            </h5>
        </div>
        <div class="card-body">
            <div class="row mb-4">
                <div class="col-md-6">
                    <label class="form-label">Aluno</label>
                    <p>
                        <strong>{{ $authorization->student?->name ?? 'Aluno removido' }}</strong><br>
                        <small class="text-muted">{{ $authorization->student?->registration ?? '-' }}</small><br>
                        <small class="text-muted">{{ $authorization->student?->class ?? '-' }}</small>
                    </p>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Professor do dia</label>
                    <p>
                        <strong>{{ $authorization->guardian?->name ?? '-' }}</strong><br>
                        <small class="text-muted">{{ $authorization->guardian?->phone ?? '-' }}</small>
                    </p>
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-md-2">
                    <label class="form-label">Tipo</label>
                    <p>
                        @if($authorization->type === 'entry')
                            <span class="badge badge-senai-blue">Entrada</span>
                        @else
                            <span class="badge badge-senai-orange">Saída</span>
                        @endif
                    </p>
                </div>
                <div class="col-md-2">
                    <label class="form-label">{{ $authorization->scheduled_time_label }}</label>
                    <p>{{ $authorization->scheduled_time_formatted }}</p>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Status</label>
                    <p>
                        @if($authorization->portaria_status === 'checked')
                            <span class="badge bg-success">Validado</span>
                        @else
                            <span class="badge bg-danger">Negado</span>
                        @endif
                    </p>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Professor</label>
                    <p>{{ $authorization->professor?->name ?? '-' }}</p>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Data</label>
                    <p>{{ $authorization->checked_by_portaria_at?->format('d/m/Y H:i') ?? '-' }}</p>
                </div>
            </div>

            <div class="mb-0">
                <label class="form-label">Motivo original</label>
                <p class="mb-0">{{ $authorization->reason ?: 'Não informado.' }}</p>
            </div>
        </div>
    </div>
</div>
@endsection
