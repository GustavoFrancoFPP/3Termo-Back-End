@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-md-8">
            <h1 class="h2 text-senai-blue">
                <i class="fas fa-qrcode me-2"></i>Validar Autorização
            </h1>
            <p class="text-muted">Insira o código de validação fornecido pelo professor do dia</p>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('portaria.dashboard') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i>Voltar
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 offset-md-3">
            <div class="card shadow">
                <div class="card-body p-5">
                    <form method="POST" action="{{ route('portaria.validate-code') }}">
                        @csrf

                        <div class="mb-4">
                            <label for="code" class="form-label fw-bold fs-5">
                                Código de Autorização
                            </label>
                            <input type="text" 
                                   class="form-control form-control-lg text-center font-monospace @error('code') is-invalid @enderror" 
                                   id="code" 
                                   name="code" 
                                   placeholder="XXXXXXXX"
                                   maxlength="8"
                                   style="font-size: 2rem; letter-spacing: 0.5rem;"
                                   autofocus
                                   required>
                            <small class="form-text text-muted d-block mt-2">
                                Digite o código de 8 caracteres
                            </small>
                            @error('code')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-senai-primary btn-lg w-100 fw-bold">
                            <i class="fas fa-search me-2"></i>Buscar Autorização
                        </button>
                    </form>
                </div>
            </div>

            <!-- Informações -->
            <div class="alert alert-warning mt-4">
                <i class="fas fa-exclamation-triangle me-2"></i>
                <strong>Importante:</strong>
                <ul class="mb-0 mt-2">
                    <li>O código deve ter exatamente 8 caracteres</li>
                    <li>O código é válido por 4 horas após a aprovação</li>
                    <li>Cada código é único e pode ser usado apenas uma vez</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<style>
    input[type="text"]:focus {
        border-color: #002d81 !important;
        box-shadow: 0 0 0 0.2rem rgba(0, 45, 129, 0.25) !important;
    }
</style>
@endsection
