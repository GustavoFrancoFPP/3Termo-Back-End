@extends('layouts.app')

@section('content')
<div class="page-header">
    <h1><i class="fas fa-user-edit me-2"></i>Editar Aluno</h1>
</div>

<div class="row justify-content-center">
    <div class="col-md-8">
        <form action="{{ route('students.update', $student) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="name" class="form-label">Nome</label>
                <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $student->name) }}" maxlength="255" required>
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="registration" class="form-label">Matricula</label>
                <input type="text" id="registration" class="form-control" value="{{ $student->registration }}" readonly>
            </div>

            <div class="mb-3">
                <label for="class" class="form-label">Classe</label>
                <input type="text" name="class" id="class" class="form-control @error('class') is-invalid @enderror" value="{{ old('class', $student->class) }}" maxlength="50" required>
                @error('class')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="guardian_id" class="form-label">Professor responsavel padrao</label>
                <select name="guardian_id" id="guardian_id" class="form-control @error('guardian_id') is-invalid @enderror">
                    <option value="">-- Sem professor fixo --</option>
                    @foreach($guardians as $guardian)
                        <option value="{{ $guardian->id }}" {{ old('guardian_id', $student->guardian_id) == $guardian->id ? 'selected' : '' }}>
                            {{ $guardian->name }}
                        </option>
                    @endforeach
                </select>
                <small class="form-text text-muted">Na autorizacao, o professor que deu aula no dia podera ser escolhido livremente.</small>
                @error('guardian_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="observations" class="form-label">Observacoes</label>
                <textarea name="observations" id="observations" class="form-control @error('observations') is-invalid @enderror" rows="3" maxlength="1000">{{ old('observations', $student->observations) }}</textarea>
                @error('observations')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3 form-check">
                <input type="checkbox" name="is_active" id="is_active" class="form-check-input" value="1" {{ old('is_active', $student->is_active) ? 'checked' : '' }}>
                <label for="is_active" class="form-check-label">Ativo</label>
            </div>

            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save me-2"></i>Atualizar Aluno
            </button>
            <a href="{{ route('students.show', $student) }}" class="btn btn-secondary">
                <i class="fas fa-times-circle me-2"></i>Cancelar
            </a>
        </form>
    </div>
</div>
@endsection
