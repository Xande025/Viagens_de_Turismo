<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Coinpel</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
</head>
<body>
    <div class="container-fluid vh-100">
        <div class="row h-100">
            <!-- Left side: white background with form -->
            <div class="col-md-6 col-lg-5 d-flex align-items-center justify-content-center bg-white position-relative">
                <div class="w-75">
                    <div class="text-center mb-4">
                        <img src="{{ asset('images/logo.png') }}" alt="Coinpel" class="img-fluid" style="max-width: 250px;">
                    </div>
                                        <h6 class="mb-3 text-start">Faça login:</h6>
                    
                    <form method="POST" action="{{ route('login') }}" id="loginForm">
                        @csrf
                        <div class="mb-3">
                            <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" placeholder="E-mail" value="{{ old('email') }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="Senha" required>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn custom-btn text-white">Entrar</button>
                        </div>
                    </form>

                    <!-- Modal de Alteração de Senha (aparece após login se for primeiro acesso) -->
                    <!-- Password change modal (hidden by default) -->
                    @if(session('show_password_modal'))
                    <div id="passwordModal" class="password-modal">
                        <h6 class="modal-title mt-1">Crie uma nova senha:</h6>
                        <p class="small-text mb-3">No seu primeiro acesso é necessário trocar a senha provisória. É obrigatório que a senha tenha no mínimo 8 caracteres.</p>
                        
                        <form method="POST" action="{{ route('change-password-first-access') }}" id="passwordForm">
                            @csrf
                            <input type="hidden" name="temp_user_id" value="{{ session('temp_user_data.id') }}">
                            
                            <div class="mb-3">
                                <input type="password" name="current_password" id="currentPassword" class="form-control" placeholder="Senha atual" required>
                                @error('current_password')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="mb-3">
                                <input type="password" name="password" id="newPassword" class="form-control" placeholder="Nova senha" required minlength="8">
                                @error('password')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="mb-4">
                                <input type="password" name="password_confirmation" id="confirmPassword" class="form-control" placeholder="Repita senha" required>
                            </div>
                            
                            <div class="d-grid">
                                <button type="submit" class="btn custom-btn text-white">Confirmar</button>
                            </div>
                        </form>
                    </div>
                    @endif

                </div>
            </div>
            <!-- Right side: purple background with image -->
            <div class="col-md-6 col-lg-7 d-none d-md-block p-0">
                <div class="h-100 bg-secondary position-relative bg-login"></div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Custom JS to handle modal display -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const loginForm = document.getElementById('loginForm');
            const passwordModal = document.getElementById('passwordModal');

            // Se há uma sessão indicando primeiro acesso, o modal já está visível
            @if(session('show_password_modal'))
                // Modal já está sendo exibido pelo backend
                console.log('Modal de primeiro acesso ativo');
            @endif
        });
    </script>
</body>
</html>
