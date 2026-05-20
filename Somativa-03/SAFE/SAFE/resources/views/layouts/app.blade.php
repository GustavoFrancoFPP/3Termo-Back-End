<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'SAFE - Sistema de Autorização e Fluxo Escolar')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/senai.css') }}?v={{ filemtime(public_path('css/senai.css')) }}">
    @stack('styles')
</head>
<body>
    <!-- Navbar SENAI -->
    <nav class="navbar navbar-expand-lg navbar-dark navbar-senai sticky-top">
        <div class="container-fluid">
            <a class="navbar-brand-senai" href="{{ url('/') }}">
                <i class="fas fa-shield-alt me-2"></i>
                <span>SAFE</span>
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    @auth
                        <li class="nav-item">
                            <span class="nav-link">
                                <i class="fas fa-clock me-1"></i><span id="time">{{ date('H:i:s') }}</span>
                            </span>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown">
                                <i class="fas fa-user-circle me-2"></i>{{ auth()->user()->name }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                                <li>
                                    <a class="dropdown-item" href="#">
                                        <i class="fas fa-user me-2"></i>Meu Perfil
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}" class="d-inline-block w-100">
                                        @csrf
                                        <button type="submit" class="dropdown-item">
                                            <i class="fas fa-sign-out-alt me-2"></i>Sair
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">
                                <i class="fas fa-sign-in-alt me-2"></i>Entrar
                            </a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <!-- Mostrar Sidebar apenas se autenticado -->
    @auth
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <nav class="col-lg-2 sidebar-senai d-lg-block collapse" id="sidebar">
                <div class="sidebar-sticky px-3 py-4">
                    <!-- Papel do usuário -->
                    <div class="mb-4 pb-3 border-bottom">
                        <p class="text-muted small fw-bold text-uppercase mb-0">
                            <i class="fas fa-badge me-1"></i>
                            @if(auth()->user()->role === 'admin')
                                Administrador
                            @elseif(auth()->user()->role === 'professor')
                                Professor
                            @elseif(auth()->user()->role === 'portaria')
                                Portaria
                            @endif
                        </p>
                    </div>

                    <!-- Menu de Navegação -->
                    <ul class="nav flex-column">
                        @if(auth()->user()->role === 'admin')
                            <li class="nav-item">
                                <a class="sidebar-item @if(request()->routeIs('admin.dashboard')) active @endif" href="{{ route('admin.dashboard') }}">
                                    <i class="fas fa-cog me-2"></i>Dashboard
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="sidebar-item @if(request()->routeIs('admin.create*')) active @endif" href="{{ route('admin.create-authorization') }}">
                                    <i class="fas fa-plus-circle me-2"></i>Nova Autorização
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="sidebar-item @if(request()->routeIs('admin.list*')) active @endif" href="{{ route('admin.list-authorizations') }}">
                                    <i class="fas fa-list me-2"></i>Autorizações
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="sidebar-item" href="{{ route('students.index') }}">
                                    <i class="fas fa-user-graduate me-2"></i>Alunos
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="sidebar-item" href="{{ route('guardians.index') }}">
                                    <i class="fas fa-users me-2"></i>Professores do Dia
                                </a>
                            </li>
                        @elseif(auth()->user()->role === 'professor')
                            <li class="nav-item">
                                <a class="sidebar-item @if(request()->routeIs('professor.dashboard')) active @endif" href="{{ route('professor.dashboard') }}">
                                    <i class="fas fa-chalkboard-user me-2"></i>Dashboard
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="sidebar-item @if(request()->routeIs('professor.list*')) active @endif" href="{{ route('professor.list-authorizations') }}">
                                    <i class="fas fa-inbox me-2"></i>Autorizações
                                    @php
                                        $pending = auth()->user()->authorizationsToAnalyze()->where('status', 'pending')->count();
                                    @endphp
                                    @if($pending > 0)
                                        <span class="badge bg-danger ms-2">{{ $pending }}</span>
                                    @endif
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="sidebar-item @if(request()->routeIs('professor.students')) active @endif" href="{{ route('professor.students') }}">
                                    <i class="fas fa-users me-2"></i>Meus Alunos
                                </a>
                            </li>
                        @elseif(auth()->user()->role === 'portaria')
                            <li class="nav-item">
                                <a class="sidebar-item @if(request()->routeIs('portaria.dashboard')) active @endif" href="{{ route('portaria.dashboard') }}">
                                    <i class="fas fa-id-card me-2"></i>Dashboard
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="sidebar-item @if(request()->routeIs('portaria.validate*')) active @endif" href="{{ route('portaria.validate-form') }}">
                                    <i class="fas fa-qrcode me-2"></i>Validar
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="sidebar-item @if(request()->routeIs('portaria.list*')) active @endif" href="{{ route('portaria.list-validations') }}">
                                    <i class="fas fa-list me-2"></i>Histórico
                                </a>
                            </li>
                        @endif
                    </ul>

                    <hr class="my-3">

                    <!-- Menu Secundário -->
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="sidebar-item @if(request()->routeIs('notifications.index')) active @endif" href="{{ route('notifications.index') }}">
                                <i class="fas fa-bell me-2"></i>Notificações
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>

            <!-- Conteúdo Principal -->
            <main class="col-lg-10 main-content">
            @else
            <!-- Conteúdo Principal (Login) -->
            <main class="container mt-5">
            @endauth

                <!-- Alertas -->
                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <strong>Erros encontrados:</strong>
                        <ul class="mb-0 mt-2">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-times-circle me-2"></i>{{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <!-- Conteúdo da Página -->
                @yield('content')
            </main>

            @auth
        </div>
    </div>
    @endauth

    <!-- Footer -->
    <footer class="footer-senai">
        <div class="container-fluid">
            <div class="row py-5">
                <!-- Coluna 1: Logo e Descrição -->
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="footer-logo">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <h5>SAFE</h5>
                    <p>Sistema de Autorização e Fluxo Escolar - Desenvolvido para gerenciar acessos de alunos nas dependências SENAI com segurança e eficiência.</p>
                </div>

                <!-- Coluna 2: Menu Rápido -->
                <div class="col-lg-3 col-md-6 mb-4">
                    <h5><i class="fas fa-list me-2"></i>Menu Rápido</h5>
                    <ul>
                        @auth
                            @if(auth()->user()->role === 'admin')
                                <li><a href="{{ route('admin.dashboard') }}"><i class="fas fa-cog me-2"></i>Dashboard Admin</a></li>
                                <li><a href="{{ route('admin.create-authorization') }}"><i class="fas fa-plus me-2"></i>Nova Autorização</a></li>
                                <li><a href="{{ route('students.index') }}"><i class="fas fa-user-graduate me-2"></i>Alunos</a></li>
                            @elseif(auth()->user()->role === 'professor')
                                <li><a href="{{ route('professor.dashboard') }}"><i class="fas fa-chalkboard-user me-2"></i>Dashboard</a></li>
                                <li><a href="{{ route('professor.students') }}"><i class="fas fa-users me-2"></i>Meus Alunos</a></li>
                            @elseif(auth()->user()->role === 'portaria')
                                <li><a href="{{ route('portaria.dashboard') }}"><i class="fas fa-id-card me-2"></i>Dashboard</a></li>
                                <li><a href="{{ route('portaria.validate-form') }}"><i class="fas fa-qrcode me-2"></i>Validar</a></li>
                            @endif
                        @else
                            <li><a href="{{ route('login') }}"><i class="fas fa-sign-in-alt me-2"></i>Entrar</a></li>
                        @endauth
                    </ul>
                </div>

                <!-- Coluna 3: Suporte -->
                <div class="col-lg-3 col-md-6 mb-4">
                    <h5><i class="fas fa-headset me-2"></i>Suporte</h5>
                    <ul>
                        <li><a href="#"><i class="fas fa-question-circle me-2"></i>Central de Ajuda</a></li>
                        <li><a href="#"><i class="fas fa-envelope me-2"></i>Contato</a></li>
                        <li><a href="#"><i class="fas fa-file-alt me-2"></i>Documentação</a></li>
                        <li><a href="#"><i class="fas fa-bug me-2"></i>Reportar Problema</a></li>
                    </ul>
                </div>

                <!-- Coluna 4: Informações -->
                <div class="col-lg-3 col-md-6 mb-4">
                    <h5><i class="fas fa-info-circle me-2"></i>Informações</h5>
                    <ul>
                        <li><a href="#"><i class="fas fa-shield-alt me-2"></i>Privacidade</a></li>
                        <li><a href="#"><i class="fas fa-file-contract me-2"></i>Termos de Uso</a></li>
                        <li><a href="#"><i class="fas fa-cog me-2"></i>Configurações</a></li>
                    </ul>
                </div>
            </div>

            <hr>

            <!-- Footer Bottom -->
            <div class="footer-bottom">
                <div class="row">
                    <div class="col-md-6 text-start">
                        <p>&copy; 2026 SENAI - Sistema de Autorização e Fluxo Escolar. Todos os direitos reservados.</p>
                    </div>
                    <div class="col-md-6 text-end">
                        <p>Versão <strong>2.0.0</strong> | Desenvolvido com <i class="fas fa-heart" style="color: var(--senai-orange);"></i> para SENAI</p>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Atualizar hora a cada segundo
        function updateTime() {
            const now = new Date();
            const element = document.getElementById('time');
            if (element) {
                element.textContent = now.toLocaleTimeString('pt-BR');
            }
        }
        setInterval(updateTime, 1000);
    </script>
    @stack('scripts')
</body>
</html>
