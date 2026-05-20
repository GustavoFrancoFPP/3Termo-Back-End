@extends('layouts.app')

@section('content')
<div class="page-header">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1><i class="bi bi-person-check me-2"></i>Professores Responsaveis</h1>
            <p class="text-muted">Professores que podem ser responsaveis pelo aluno no dia.</p>
        </div>
        <a href="{{ route('guardians.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle me-2"></i>Novo Professor
        </a>
    </div>
</div>

<div class="card">
    <div class="card-body">
        @if($guardians->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>Nome</th>
                            <th>Email</th>
                            <th>Telefone</th>
                            <th>Aluno padrao</th>
                            <th>Notificacoes</th>
                            <th>Acoes</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($guardians as $guardian)
                            <tr>
                                <td>
                                    <strong>{{ $guardian->name }}</strong><br>
                                    <small class="text-muted">Professor do dia</small>
                                </td>
                                <td><a href="mailto:{{ $guardian->email }}">{{ $guardian->email }}</a></td>
                                <td>{{ $guardian->phone }}</td>
                                <td>{{ $guardian->students->count() }} aluno(s)</td>
                                <td>
                                    @if($guardian->receive_notifications)
                                        <span class="badge bg-success"><i class="bi bi-bell me-1"></i>Ativadas</span>
                                    @else
                                        <span class="badge bg-secondary"><i class="bi bi-bell-slash me-1"></i>Desativadas</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('guardians.show', $guardian) }}" class="btn btn-sm btn-info">
                                        <i class="bi bi-eye me-1"></i>Ver
                                    </a>
                                    <a href="{{ route('guardians.edit', $guardian) }}" class="btn btn-sm btn-warning">
                                        <i class="bi bi-pencil me-1"></i>Editar
                                    </a>
                                    <form action="{{ route('guardians.destroy', $guardian) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Tem certeza?')">
                                            <i class="bi bi-trash me-1"></i>Excluir
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            {{ $guardians->links() }}
        @else
            <div class="alert alert-info" role="alert">
                <i class="bi bi-info-circle me-2"></i>
                <strong>Nenhum professor responsavel cadastrado.</strong>
                <a href="{{ route('guardians.create') }}">Cadastre um novo professor</a>
            </div>
        @endif
    </div>
</div>
@endsection
