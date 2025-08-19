@extends('layouts.admin')

@section('title', 'Editar Usuário')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">
        <i class="bi bi-person-gear"></i> Editar Usuário
    </h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <a href="{{ route('users.show', $user) }}" class="btn btn-info">
                <i class="bi bi-eye"></i> Visualizar
            </a>
            <a href="{{ route('users.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Voltar
            </a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="bi bi-pencil"></i> Formulário de Edição
                </h6>
            </div>
            <div class="card-body">
                <form action="{{ route('users.update', $user) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="name" class="form-label">Nome Completo *</label>
                                <input type="text" 
                                       class="form-control @error('name') is-invalid @enderror" 
                                       id="name" name="name" 
                                       value="{{ old('name', $user->name) }}" 
                                       required maxlength="255">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Nome que será exibido no sistema</div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="email" class="form-label">E-mail *</label>
                                <input type="email" 
                                       class="form-control @error('email') is-invalid @enderror" 
                                       id="email" name="email" 
                                       value="{{ old('email', $user->email) }}" 
                                       required maxlength="255">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">E-mail único para acesso ao sistema</div>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="password" class="form-label">Nova Senha</label>
                                <input type="password" 
                                       class="form-control @error('password') is-invalid @enderror" 
                                       id="password" name="password" 
                                       minlength="8">
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Deixe em branco para manter a senha atual. Mínimo 8 caracteres.</div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="password_confirmation" class="form-label">Confirmar Nova Senha</label>
                                <input type="password" 
                                       class="form-control" 
                                       id="password_confirmation" 
                                       name="password_confirmation">
                                <div class="form-text">Confirme a nova senha</div>
                            </div>
                        </div>
                    </div>

                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" 
                               name="force_password_change" id="force_password_change" value="1"
                               {{ old('force_password_change') ? 'checked' : '' }}>
                        <label class="form-check-label" for="force_password_change">
                            Forçar alteração de senha no próximo login
                        </label>
                        <div class="form-text">O usuário deverá alterar a senha na próxima vez que fizer login</div>
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <a href="{{ route('users.show', $user) }}" class="btn btn-secondary me-md-2">
                            <i class="bi bi-x-circle"></i> Cancelar
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-circle"></i> Salvar Alterações
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <!-- Informações do usuário atual -->
        <div class="card bg-light mb-4">
            <div class="card-header">
                <i class="bi bi-info-circle"></i> Informações Atuais
            </div>
            <div class="card-body">
                <table class="table table-borderless table-sm">
                    <tr>
                        <td class="fw-bold">Criado em:</td>
                        <td>{{ $user->created_at->format('d/m/Y H:i') }}</td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Última atualização:</td>
                        <td>{{ $user->updated_at->format('d/m/Y H:i') }}</td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Status primeiro acesso:</td>
                        <td>
                            @if($user->first_access)
                                <span class="badge bg-warning">Pendente</span>
                            @else
                                <span class="badge bg-success">Concluído</span>
                            @endif
                        </td>
                    </tr>
                </table>
            </div>
        </div>

        <!-- Ações de segurança -->
        <div class="card border-warning">
            <div class="card-header bg-warning bg-opacity-25">
                <i class="bi bi-shield-exclamation"></i> Ações de Segurança
            </div>
            <div class="card-body">
                <p class="card-text small">
                    <strong>Atenção:</strong> Alterações de e-mail ou senha afetarão o acesso do usuário ao sistema.
                </p>
                
                <div class="d-grid">
                    <form action="{{ route('users.reset-password', $user) }}" method="POST" 
                          onsubmit="return confirm('Tem certeza? O usuário receberá uma senha temporária.')">
                        @csrf
                        <button type="submit" class="btn btn-warning btn-sm">
                            <i class="bi bi-arrow-clockwise"></i> Gerar Senha Temporária
                        </button>
                    </form>
                </div>
                
                <hr>
                
                @if($user->id !== auth()->id())
                <div class="d-grid">
                    <form action="{{ route('users.destroy', $user) }}" method="POST" 
                          onsubmit="return confirm('ATENÇÃO: Esta ação é irreversível! Tem certeza que deseja excluir este usuário?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">
                            <i class="bi bi-trash"></i> Excluir Usuário
                        </button>
                    </form>
                </div>
                @else
                <div class="alert alert-info">
                    <i class="bi bi-info-circle"></i>
                    <small>Você não pode excluir sua própria conta.</small>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
