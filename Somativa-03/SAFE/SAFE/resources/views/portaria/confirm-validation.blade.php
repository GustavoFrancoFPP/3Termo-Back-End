@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-md-8">
            <h1 class="h2 text-senai-blue">
                <i class="fas fa-check-circle me-2"></i>Confirmar Validação
            </h1>
            <p class="text-muted">Revise os dados antes de registrar a entrada ou saída.</p>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('portaria.validate-form') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i>Voltar
            </a>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow">
                <div class="card-header bg-senai-blue text-white py-3">
                    <h5 class="m-0 font-weight-bold">
                        <i class="fas fa-id-card me-2"></i>Autorização Encontrada
                    </h5>
                </div>
                <div class="card-body p-4">
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
                            <label class="form-label">Professor</label>
                            <p>{{ $authorization->professor?->name ?? '-' }}</p>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Expiração</label>
                            <p>{{ $authorization->expires_at->format('d/m/Y H:i') }}</p>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('portaria.confirm-validation', $authorization->id) }}">
                        @csrf
                        <div class="mb-3">
                            <label for="notes" class="form-label">Observações</label>
                            <textarea id="notes" name="notes" class="form-control" rows="3" placeholder="Opcional"></textarea>
                        </div>

                        <div class="d-grid gap-2 d-md-flex">
                            <button type="submit" name="action" value="approve" class="btn btn-success flex-fill">
                                <i class="fas fa-check-circle me-2"></i>Confirmar Validação
                            </button>
                            <button type="submit" name="action" value="deny" class="btn btn-danger flex-fill">
                                <i class="fas fa-times-circle me-2"></i>Negar Validação
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
