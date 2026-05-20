@extends('layouts.app')

@section('content')
<div class="page-header">
    <h1><i class="fas fa-user-plus me-2"></i>Cadastrar Aluno</h1>
    <p class="text-muted">Adicione um novo aluno ao sistema</p>
</div>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Informacoes do Aluno</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('students.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="name" class="form-label"><i class="fas fa-user me-2"></i>Nome <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" maxlength="255" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="registration" class="form-label"><i class="fas fa-id-card me-2"></i>Matricula automatica</label>
                        <input type="text" id="registration" class="form-control" value="{{ $nextRegistration }}" readonly>
                        <small class="form-text text-muted">A matricula sera criada automaticamente ao salvar.</small>
                    </div>

                    <div class="mb-3">
                        <label for="class" class="form-label"><i class="fas fa-book me-2"></i>Classe <span class="text-danger">*</span></label>
                        <input type="text" name="class" id="class" class="form-control @error('class') is-invalid @enderror" value="{{ old('class') }}" maxlength="50" placeholder="Ex: SENAI - Sala 101 (Bloco A)" required>
                        @error('class')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="guardian_id" class="form-label"><i class="fas fa-chalkboard-user me-2"></i>Professor responsavel padrao</label>
                        <select name="guardian_id" id="guardian_id" class="form-control @error('guardian_id') is-invalid @enderror">
                            <option value="">-- Sem professor fixo --</option>
                            @foreach($guardians as $guardian)
                                <option value="{{ $guardian->id }}" {{ old('guardian_id') == $guardian->id ? 'selected' : '' }}>
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
                        <label for="observations" class="form-label"><i class="fas fa-comment-dots me-2"></i>Observacoes</label>
                        <textarea name="observations" id="observations" class="form-control @error('observations') is-invalid @enderror" rows="3" maxlength="1000">{{ old('observations') }}</textarea>
                        @error('observations')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-check-circle me-2"></i>Cadastrar Aluno
                        </button>
                        <a href="{{ route('students.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-times-circle me-2"></i>Cancelar
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
