@extends('layouts.app')

@section('content')
<div class="page-header">
    <h1><i class="fas fa-user-edit me-2"></i>Editar Professor Responsavel</h1>
    <p class="text-muted">Atualize os dados do professor responsavel pelo aluno no dia.</p>
</div>

<div class="row justify-content-center">
    <div class="col-md-8">
        <form action="{{ route('guardians.update', $guardian) }}" method="POST">
            @csrf
            @method('PUT')

            <input type="hidden" name="relationship" value="Professor do dia">

            <div class="alert alert-info">
                <i class="fas fa-info-circle me-2"></i>
                Este registro e tratado como professor do dia.
            </div>

            <div class="mb-3">
                <label for="name" class="form-label">Nome</label>
                <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $guardian->name) }}" maxlength="255" required>
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $guardian->email) }}" maxlength="255" required>
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="phone" class="form-label">Telefone</label>
                <input type="tel" name="phone" id="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone', $guardian->phone) }}" maxlength="15" inputmode="numeric" required>
                @error('phone')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="document" class="form-label">CPF</label>
                <input type="text" name="document" id="document" class="form-control @error('document') is-invalid @enderror" value="{{ old('document', $guardian->document) }}" maxlength="14" inputmode="numeric" required>
                @error('document')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3 form-check">
                <input type="checkbox" name="can_authorize_exit" id="can_authorize_exit" class="form-check-input" value="1" {{ old('can_authorize_exit', $guardian->can_authorize_exit) ? 'checked' : '' }}>
                <label for="can_authorize_exit" class="form-check-label">Pode acompanhar autorizacoes do dia</label>
            </div>

            <div class="mb-3 form-check">
                <input type="checkbox" name="receive_notifications" id="receive_notifications" class="form-check-input" value="1" {{ old('receive_notifications', $guardian->receive_notifications) ? 'checked' : '' }}>
                <label for="receive_notifications" class="form-check-label">Receber notificacoes</label>
            </div>

            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save me-2"></i>Atualizar Professor
            </button>
            <a href="{{ route('guardians.show', $guardian) }}" class="btn btn-secondary">
                <i class="fas fa-times-circle me-2"></i>Cancelar
            </a>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function onlyDigits(value) {
        return value.replace(/\D/g, '');
    }

    function applyCpfMask(input) {
        const digits = onlyDigits(input.value).slice(0, 11);
        input.value = digits
            .replace(/(\d{3})(\d)/, '$1.$2')
            .replace(/(\d{3})(\d)/, '$1.$2')
            .replace(/(\d{3})(\d{1,2})$/, '$1-$2');
    }

    function applyPhoneMask(input) {
        const digits = onlyDigits(input.value).slice(0, 11);
        input.value = digits.length <= 10
            ? digits.replace(/(\d{2})(\d{4})(\d{0,4})/, '($1) $2-$3').replace(/-$/, '')
            : digits.replace(/(\d{2})(\d{5})(\d{0,4})/, '($1) $2-$3').replace(/-$/, '');
    }

    document.getElementById('document')?.addEventListener('input', (event) => applyCpfMask(event.target));
    document.getElementById('phone')?.addEventListener('input', (event) => applyPhoneMask(event.target));
</script>
@endpush
