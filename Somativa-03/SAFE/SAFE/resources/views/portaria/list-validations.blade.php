@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-md-8">
            <h1 class="h2 text-senai-blue">
                <i class="fas fa-history me-2"></i>Histórico da Portaria
            </h1>
            <p class="text-muted">Entradas e saídas registradas pela portaria.</p>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('portaria.dashboard') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i>Voltar
            </a>
        </div>
    </div>

    <div class="card shadow">
        <div class="card-header bg-senai-blue text-white py-3">
            <h5 class="m-0 font-weight-bold">
                <i class="fas fa-list me-2"></i>Validações
            </h5>
        </div>
        <div class="card-body">
            @if($validations->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Aluno</th>
                                <th>Professor do dia</th>
                                <th>Professor</th>
                                <th>Tipo</th>
                                <th>Horario</th>
                                <th>Status Portaria</th>
                                <th>Data</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($validations as $validation)
                                <tr>
                                    <td>
                                        <strong>{{ $validation->student?->name ?? 'Aluno removido' }}</strong><br>
                                        <small class="text-muted">{{ $validation->student?->registration ?? '-' }}</small>
                                    </td>
                                    <td>{{ $validation->guardian?->name ?? '-' }}</td>
                                    <td>{{ $validation->professor?->name ?? '-' }}</td>
                                    <td>
                                        @if($validation->type === 'entry')
                                            <span class="badge badge-senai-blue">Entrada</span>
                                        @else
                                            <span class="badge badge-senai-orange">Saída</span>
                                        @endif
                                    </td>
                                    <td>
                                        <small class="text-muted">{{ $validation->scheduled_time_label }}</small><br>
                                        <strong>{{ $validation->scheduled_time_formatted }}</strong>
                                    </td>
                                    <td>
                                        @if($validation->portaria_status === 'checked')
                                            <span class="badge bg-success">Validado</span>
                                        @else
                                            <span class="badge bg-danger">Negado</span>
                                        @endif
                                    </td>
                                    <td>{{ $validation->checked_by_portaria_at?->format('d/m/Y H:i') ?? '-' }}</td>
                                    <td>
                                        <a href="{{ route('portaria.view-validation', $validation->id) }}" class="btn btn-sm btn-senai-primary">
                                            <i class="fas fa-eye me-1"></i>Ver
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-3">
                    {{ $validations->links() }}
                </div>
            @else
                <p class="text-muted text-center py-4 mb-0">
                    <i class="fas fa-inbox me-2"></i>Nenhuma validação registrada.
                </p>
            @endif
        </div>
    </div>
</div>
@endsection
