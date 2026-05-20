@extends('layouts.app')

@section('content')
<div class="page-header">
    <h1><i class="fas fa-chalkboard-user me-2"></i>Cadastrar Professor Responsavel</h1>
    <p class="text-muted">Cadastre o professor que podera ser responsavel pelo aluno no dia.</p>
</div>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Informacoes do Professor Responsavel</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('guardians.store') }}" method="POST">
                    @csrf

                    <input type="hidden" name="relationship" value="Professor do dia">

                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        Este cadastro representa um professor que deu aula para o aluno no dia.
                    </div>

                    <div class="mb-3">
                        <label for="name" class="form-label"><i class="fas fa-user me-2"></i>Nome Completo <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" maxlength="255" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label"><i class="fas fa-envelope me-2"></i>Email <span class="text-danger">*</span></label>
                        <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" maxlength="255" placeholder="professor@email.com" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="phone" class="form-label"><i class="fas fa-phone me-2"></i>Telefone <span class="text-danger">*</span></label>
                        <input type="tel" name="phone" id="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone') }}" maxlength="15" inputmode="numeric" placeholder="(11) 99999-9999" required>
                        @error('phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="document" class="form-label"><i class="fas fa-address-card me-2"></i>CPF <span class="text-danger">*</span></label>
                        <input type="text" name="document" id="document" class="form-control @error('document') is-invalid @enderror" value="{{ old('document') }}" maxlength="14" inputmode="numeric" placeholder="000.000.000-00" required>
                        @error('document')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="form-check">
                                <input type="checkbox" name="can_authorize_exit" id="can_authorize_exit" class="form-check-input" value="1" {{ old('can_authorize_exit', true) ? 'checked' : '' }}>
                                <label class="form-check-label" for="can_authorize_exit">
                                    <i class="fas fa-check-circle me-2"></i>Pode acompanhar autorizacoes do dia
                                </label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-check">
                                <input type="checkbox" name="receive_notifications" id="receive_notifications" class="form-check-input" value="1" {{ old('receive_notifications', true) ? 'checked' : '' }}>
                                <label class="form-check-label" for="receive_notifications">
                                    <i class="fas fa-bell me-2"></i>Receber notificacoes
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-check-circle me-2"></i>Cadastrar Professor
                        </button>
                        <a href="{{ route('guardians.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-times-circle me-2"></i>Cancelar
                        </a>
                    </div>
                </form>
            </div>
        </div>
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
