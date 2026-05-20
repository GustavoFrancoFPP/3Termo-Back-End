@extends('layouts.app')

@section('content')
<div class="page-header">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1><i class="bi bi-check-square me-2"></i>Autorizações Pendentes</h1>
            <p class="text-muted">Solicitações aguardando autorização</p>
        </div>
        <a href="{{ route('authorizations.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle me-2"></i>Nova Autorização
        </a>
    </div>
</div>

<div class="card">
    <div class="card-body">
        @if($authorizations->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>Aluno</th>
                            <th>Professor do dia</th>
                            <th>Tipo</th>
                            <th>Horario</th>
                            <th>Motivo</th>
                            <th>Solicita</th>
                            <th>Expira em</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($authorizations as $auth)
                            <tr>
                                <td>
                                    <strong>{{ $auth->student->name }}</strong><br>
                                    <small class="text-muted">{{ $auth->student->registration }}</small>
                                </td>
                                <td>{{ $auth->guardian->name }}</td>
                                <td>
                                    @if($auth->type === 'entry')
                                        <span class="badge bg-success">Entrada</span>
                                    @else
                                        <span class="badge bg-warning">Saída</span>
                                    @endif
                                </td>
                                <td>
                                    <small class="text-muted">{{ $auth->scheduled_time_label }}</small><br>
                                    <strong>{{ $auth->scheduled_time_formatted }}</strong>
                                </td>
                                <td>{{ Str::limit($auth->reason ?? 'Não informado', 30) }}</td>
                                <td><small>{{ $auth->created_at->format('d/m H:i') }}</small></td>
                                <td>
                                    @if($auth->expires_at > now())
                                        <small class="text-success"><i class="bi bi-check-circle me-1"></i>{{ $auth->expires_at->diffForHumans() }}</small>
                                    @else
                                        <small class="text-danger"><i class="bi bi-x-circle me-1"></i>Expirada</small>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('authorizations.show', $auth) }}" class="btn btn-sm btn-info">
                                        <i class="bi bi-eye me-1"></i>Ver
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            {{ $authorizations->links() }}
        @else
            <div class="alert alert-info" role="alert">
                <i class="bi bi-info-circle me-2"></i>
                <strong>Nenhuma autorização pendente!</strong> Todas as solicitações foram processadas.
            </div>
        @endif
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-6">
        <a href="{{ route('authorizations.history') }}" class="btn btn-outline-primary w-100">
            <i class="bi bi-history me-2"></i>Ver Histórico de Autorizações
        </a>
    </div>
    <div class="col-md-6">
        <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary w-100">
            <i class="bi bi-arrow-left me-2"></i>Voltar ao Dashboard
        </a>
    </div>
</div>
@endsection
