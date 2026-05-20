@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-md-8">
            <h1 class="h2 text-senai-blue">
                <i class="fas fa-list me-2"></i>Autorizações
            </h1>
            <p class="text-muted">Gerencie todas as solicitações criadas no SAFE.</p>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('admin.create-authorization') }}" class="btn btn-senai-primary">
                <i class="fas fa-plus me-2"></i>Nova Autorização
            </a>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.list-authorizations') }}" class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label for="status" class="form-label">Status</label>
                    <select id="status" name="status" class="form-select">
                        <option value="">Todos</option>
                        <option value="pending" @selected(request('status') === 'pending')>Pendentes</option>
                        <option value="authorized" @selected(request('status') === 'authorized')>Autorizadas</option>
                        <option value="rejected" @selected(request('status') === 'rejected')>Rejeitadas</option>
                        <option value="used" @selected(request('status') === 'used')>Usadas</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="type" class="form-label">Tipo</label>
                    <select id="type" name="type" class="form-select">
                        <option value="">Todos</option>
                        <option value="entry" @selected(request('type') === 'entry')>Entrada</option>
                        <option value="exit" @selected(request('type') === 'exit')>Saída</option>
                    </select>
                </div>
                <div class="col-md-4 d-flex gap-2">
                    <button type="submit" class="btn btn-senai-primary">
                        <i class="fas fa-filter me-2"></i>Filtrar
                    </button>
                    <a href="{{ route('admin.list-authorizations') }}" class="btn btn-outline-secondary">Limpar</a>
                </div>
            </form>
        </div>
    </div>

    <div class="card shadow">
        <div class="card-header bg-senai-blue text-white py-3">
            <h5 class="m-0 font-weight-bold">
                <i class="fas fa-clipboard-list me-2"></i>Registros
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
                                <th>Professor</th>
                                <th>Tipo</th>
                                <th>Horario</th>
                                <th>Status</th>
                                <th>Criada em</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($authorizations as $authorization)
                                <tr>
                                    <td>
                                        <strong>{{ $authorization->student?->name ?? 'Aluno removido' }}</strong><br>
                                        <small class="text-muted">{{ $authorization->student?->registration ?? '-' }}</small>
                                    </td>
                                    <td>{{ $authorization->guardian?->name ?? '-' }}</td>
                                    <td>{{ $authorization->professor?->name ?? '-' }}</td>
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
                                    <td>
                                        <a href="{{ route('admin.view-authorization', $authorization->id) }}" class="btn btn-sm btn-senai-primary">
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
                    <i class="fas fa-inbox me-2"></i>Nenhuma autorização encontrada.
                </p>
            @endif
        </div>
    </div>
</div>
@endsection
