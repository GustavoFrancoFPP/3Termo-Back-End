@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-md-8">
            <h1 class="h2 text-senai-blue">
                <i class="fas fa-inbox me-2"></i>Autorizações do Professor
            </h1>
            <p class="text-muted">Acompanhe as solicitações atribuídas a você.</p>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('professor.dashboard') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i>Voltar
            </a>
        </div>
    </div>

    <div class="card shadow">
        <div class="card-header bg-senai-blue text-white py-3">
            <h5 class="m-0 font-weight-bold">
                <i class="fas fa-list me-2"></i>Histórico de Autorizações
            </h5>
        </div>
        <div class="card-body">
            @if($authorizations->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Aluno</th>
                                <th>Professor do dia</th>
                                <th>Tipo</th>
                                <th>Horario</th>
                                <th>Status</th>
                                <th>Solicitada em</th>
                                <th>Análise</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($authorizations as $authorization)
                                <tr>
                                    <td>
                                        <strong>{{ $authorization->student?->name ?? 'Aluno removido' }}</strong>
                                        <br>
                                        <small class="text-muted">{{ $authorization->student?->registration ?? '-' }}</small>
                                    </td>
                                    <td>{{ $authorization->guardian?->name ?? '-' }}</td>
                                    <td>
                                        @if($authorization->type === 'entry')
                                            <span class="badge badge-senai-blue">Entrada</span>
                                        @else
                                            <span class="badge badge-senai-orange">Saída</span>
                                        @endif
                                    </td>
                                    <td>
                                        <small class="text-muted">{{ $authorization->scheduled_time_label }}</small><br>
                                        <strong>{{ $authorization->scheduled_time_formatted }}</strong>
                                    </td>
                                    <td>
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
                                    </td>
                                    <td>{{ $authorization->created_at->format('d/m/Y H:i') }}</td>
                                    <td>{{ $authorization->analyzed_by_professor_at?->format('d/m/Y H:i') ?? 'Aguardando' }}</td>
                                    <td>
                                        <a href="{{ route('professor.view-authorization', $authorization->id) }}" class="btn btn-sm btn-senai-primary">
                                            <i class="fas fa-eye me-1"></i>Ver
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-3">
                    {{ $authorizations->links() }}
                </div>
            @else
                <p class="text-muted text-center py-4 mb-0">
                    <i class="fas fa-check-circle me-2"></i>Nenhuma autorização encontrada.
                </p>
            @endif
        </div>
    </div>
</div>
@endsection
