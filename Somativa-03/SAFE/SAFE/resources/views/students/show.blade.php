@extends('layouts.app')

@section('content')
<div class="page-header">
    <h1>{{ $student->name }}</h1>
    <p class="text-muted">Detalhes do Aluno</p>
</div>

<div class="card">
    <div class="card-body">
        <p><strong>Matrícula:</strong> {{ $student->registration }}</p>
        <p><strong>Classe:</strong> {{ $student->class }}</p>
        <p><strong>Professor do dia padrão:</strong> {{ $student->guardian->name ?? 'Sem professor fixo' }}</p>
        <p><strong>Status:</strong> {{ $student->is_active ? 'Ativo' : 'Inativo' }}</p>
    </div>
</div>

<div class="mt-3">
    <a href="{{ route('students.edit', $student) }}" class="btn btn-warning">Editar</a>
    <a href="{{ route('students.index') }}" class="btn btn-secondary">Voltar</a>
</div>
@endsection
