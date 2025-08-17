@extends('layouts.admin')

@section('title', 'Alterar Senha')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card shadow">
            <div class="card-header bg-warning text-dark">
                <h5 class="mb-0">
                    <i class="bi bi-key"></i> Alterar Senha - Primeiro Acesso
                </h5>
            </div>
            <div class="card-body">
                @if(auth()->user()->isFirstAccess())
                    <div class="alert alert-warning">
                        <i class="bi bi-exclamation-triangle"></i>
                        <strong>Atenção!</strong> Este é seu primeiro acesso ao sistema. 
                        Por motivos de segurança, você deve alterar sua senha antes de continuar.
                    </div>
                @endif

                <form method="POST" action="{{ route('password.update') }}">
                    @csrf

                    <div class="mb-3">
                        <label for="current_password" class="form-label">{{ __('Senha Atual') }}</label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="bi bi-lock"></i>
                            </span>
                            <input id="current_password" type="password" 
                                   class="form-control @error('current_password') is-invalid @enderror" 
                                   name="current_password" required autocomplete="current-password">
                        </div>
                        @error('current_password')
                            <div class="invalid-feedback">
                                <strong>{{ $message }}</strong>
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">{{ __('Nova Senha') }}</label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="bi bi-key"></i>
                            </span>
                            <input id="password" type="password" 
                                   class="form-control @error('password') is-invalid @enderror" 
                                   name="password" required autocomplete="new-password">
                        </div>
                        @error('password')
                            <div class="invalid-feedback">
                                <strong>{{ $message }}</strong>
                            </div>
                        @enderror
                        <small class="form-text text-muted">
                            A senha deve ter pelo menos 8 caracteres.
                        </small>
                    </div>

                    <div class="mb-3">
                        <label for="password-confirm" class="form-label">{{ __('Confirmar Nova Senha') }}</label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="bi bi-key-fill"></i>
                            </span>
                            <input id="password-confirm" type="password" 
                                   class="form-control" name="password_confirmation" 
                                   required autocomplete="new-password">
                        </div>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-warning">
                            <i class="bi bi-check-circle"></i> {{ __('Alterar Senha') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
