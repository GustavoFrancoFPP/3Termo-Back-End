@extends('layouts.app')

@section('content')
<div class="page-header">
    <h1><i class="bi bi-history me-2"></i>Histórico de Autorizações</h1>
    <p class="text-muted">Registro de todas as autorizações utilizadas</p>
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
                            <th>Código</th>
                            <th>Autorizada em</th>
                            <th>Validada em</th>
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
                                        <span class="badge bg-success">✓ Entrada</span>
                                    @else
                                        <span class="badge bg-info">↓ Saída</span>
                                    @endif
                                </td>
                                <td>
                                    <small class="text-muted">{{ $auth->scheduled_time_label }}</small><br>
                                    <strong>{{ $auth->scheduled_time_formatted }}</strong>
                                </td>
                                <td><code>{{ $auth->validation_code }}</code></td>
                                <td>{{ $auth->authorized_at->format('d/m/Y H:i:s') }}</td>
                                <td>{{ $auth->validated_at->format('d/m/Y H:i:s') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            {{ $authorizations->links() }}
        @else
            <div class="alert alert-info" role="alert">
                <i class="bi bi-info-circle me-2"></i>
                <strong>Nenhum registro encontrado!</strong> Não há autorizações concluídas ainda.
            </div>
        @endif
    </div>
</div>

<div class="mt-4">
    <a href="{{ route('authorizations.index') }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left me-2"></i>Voltar
    </a>
</div>
@endsection
