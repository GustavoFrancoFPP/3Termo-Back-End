@extends('layouts.app')

@section('content')
<div class="container d-flex align-items-center justify-content-center min-vh-100">
    <div class="col-md-6 col-lg-4">
        <div class="card shadow-lg">
            <div class="card-body p-5">
                <!-- Logo SENAI -->
                <div class="text-center mb-4">
                    <div style="font-size: 2.5rem; color: #002d81; margin-bottom: 10px;">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <h3 class="text-dark">SAFE</h3>
                    <p class="text-muted small">Sistema de Autorização e Fluxo Escolar</p>
                </div>

                <!-- Formulário Login -->
                <form method="POST" action="{{ route('login.post') }}">
                    @csrf

                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" 
                               class="form-control @error('email') is-invalid @enderror" 
                               id="email" 
                               name="email" 
                               value="{{ old('email') }}"
                               placeholder="seu@email.com"
                               required>
                        @error('email')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Senha</label>
                        <input type="password" 
                               class="form-control @error('password') is-invalid @enderror" 
                               id="password" 
                               name="password"
                               placeholder="••••••••"
                               required>
                        @error('password')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary w-100 py-2 fw-bold">
                        <i class="fas fa-sign-in-alt me-2"></i>Entrar
                    </button>
                </form>

                <!-- Informações de teste -->
                <hr class="my-4">
                <div class="alert alert-info small mb-0">
                    <strong>Contas de teste:</strong>
                    <ul class="mb-0 mt-2 ps-3">
                        <li><strong>Admin:</strong> admin@senai.com.br | admin123</li>
                        <li><strong>Professor:</strong> carlos.silva@senai.com.br | prof123</li>
                        <li><strong>Portaria:</strong> portaria@senai.com.br | portaria123</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <p class="text-center text-muted mt-4 small">
            &copy; 2026 SENAI - Sistema de Autorização e Fluxo Escolar
        </p>
    </div>
</div>
@endsection
