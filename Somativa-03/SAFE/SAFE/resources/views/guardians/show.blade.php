@extends('layouts.app')

@section('content')
<div class="page-header">
    <h1>{{ $guardian->name }}</h1>
    <p class="text-muted">Detalhes do professor responsavel do dia</p>
</div>

<div class="card">
    <div class="card-body">
        <p><strong>Email:</strong> <a href="mailto:{{ $guardian->email }}">{{ $guardian->email }}</a></p>
        <p><strong>Telefone:</strong> {{ $guardian->phone }}</p>
        <p><strong>Funcao:</strong> Professor do dia</p>
        <p><strong>CPF:</strong> {{ $guardian->document }}</p>
        <p><strong>Notificacoes:</strong> {{ $guardian->receive_notifications ? 'Ativadas' : 'Desativadas' }}</p>
        <p><strong>Pode acompanhar autorizacoes:</strong> {{ $guardian->can_authorize_exit ? 'Sim' : 'Nao' }}</p>
    </div>
</div>

<div class="mt-3">
    <a href="{{ route('guardians.edit', $guardian) }}" class="btn btn-warning">
        <i class="fas fa-pencil-alt me-2"></i>Editar
    </a>
    <a href="{{ route('guardians.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left me-2"></i>Voltar
    </a>
</div>
@endsection
