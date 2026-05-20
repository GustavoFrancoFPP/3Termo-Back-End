@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-md-8">
            <h1 class="h2 text-senai-blue">
                <i class="fas fa-id-card me-2"></i>Dashboard da Portaria
            </h1>
            <p class="text-muted">Bem-vindo! Faça o check-in/check-out dos alunos</p>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('portaria.validate-form') }}" class="btn btn-senai-primary me-2">
                <i class="fas fa-qrcode me-2"></i>Validar com Código
            </a>
            <a href="{{ route('portaria.list-validations') }}" class="btn btn-outline-senai-blue">
                <i class="fas fa-list me-2"></i>Histórico
            </a>
        </div>
    </div>

    <!-- Estatísticas do Dia -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card border-left-senai-blue h-100">
                <div class="card-body">
                    <div class="text-senai-blue small font-weight-bold text-uppercase mb-1">
                        Entradas Hoje
                    </div>
                    <div class="h3 mb-0 text-gray-800">{{ $entriestoday }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-left-senai-green h-100">
                <div class="card-body">
                    <div class="text-senai-green small font-weight-bold text-uppercase mb-1">
                        Saídas Hoje
                    </div>
                    <div class="h3 mb-0 text-gray-800">{{ $exitsToday }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-left-senai-orange h-100">
                <div class="card-body">
                    <div class="text-senai-orange small font-weight-bold text-uppercase mb-1">
                        Pendentes
                    </div>
                    <div class="h3 mb-0 text-gray-800">{{ $pendingToday }}</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Validações Recentes -->
    <div class="card shadow">
        <div class="card-header bg-senai-blue text-white py-3">
            <h5 class="m-0 font-weight-bold">
                <i class="fas fa-history me-2"></i>Validações Recentes
            </h5>
        </div>
        <div class="card-body">
            @if($recentValidations->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Aluno</th>
                                <th>Tipo</th>
                                <th>Horario previsto</th>
                                <th>Professor do dia</th>
                                <th>Hora</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentValidations as $validation)
                                <tr>
                                    <td>
                                        <strong>{{ $validation->student->name }}</strong>
                                        <br>
                                        <small class="text-muted">{{ $validation->student->registration }}</small>
                                    </td>
                                    <td>
                                        @if($validation->type === 'entry')
                                            <span class="badge badge-senai-blue">
                                                <i class="fas fa-arrow-right me-1"></i>Entrada
                                            </span>
                                        @else
                                            <span class="badge badge-senai-orange">
                                                <i class="fas fa-arrow-left me-1"></i>Saída
                                            </span>
                                        @endif
                                    </td>
                                    <td>{{ $validation->scheduled_time_formatted }}</td>
                                    <td>{{ $validation->guardian->name }}</td>
                                    <td>{{ $validation->checked_by_portaria_at?->format('H:i') ?? '-' }}</td>
                                    <td>
                                        @if($validation->portaria_status === 'checked')
                                            <span class="badge bg-success">
                                                <i class="fas fa-check-circle me-1"></i>Validado
                                            </span>
                                        @else
                                            <span class="badge bg-danger">
                                                <i class="fas fa-times-circle me-1"></i>Negado
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-muted text-center py-4">
                    <i class="fas fa-inbox me-2"></i>Nenhuma validação realizada ainda
                </p>
            @endif
        </div>
    </div>

    <!-- Instruções -->
    <div class="alert alert-info mt-4">
        <i class="fas fa-info-circle me-2"></i>
        <strong>Como usar:</strong>
        <ul class="mb-0 mt-2">
            <li>Peça o código de autorização ao professor do dia</li>
            <li>Clique em "Validar com Código" e insira o código de 8 caracteres</li>
            <li>Confirme a entrada ou saída do aluno</li>
            <li>O registro será salvo automaticamente</li>
        </ul>
    </div>
</div>
@endsection
