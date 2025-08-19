@extends('layouts.admin-simple')

@section('title', 'Detalhes do Usuário')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">
        <i class="bi bi-person-circle"></i> {{ $user->name }}
    </h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <a href="{{ route('users.edit', $user) }}" class="btn btn-warning">
                <i class="bi bi-pencil"></i> Editar
            </a>
            <a href="{{ route('users.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Voltar
            </a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="bi bi-info-circle"></i> Informações do Usuário
                </h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <td class="fw-bold">Nome:</td>
                                <td>{{ $user->name }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Email:</td>
                                <td>{{ $user->email }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Status do primeiro acesso:</td>
                                <td>
                                    @if($user->first_access)
                                        <span class="badge bg-warning">
                                            <i class="bi bi-exclamation-circle"></i> Pendente
                                        </span>
                                        <br><small class="text-muted">Usuário deve alterar senha no primeiro login</small>
                                    @else
                                        <span class="badge bg-success">
                                            <i class="bi bi-check-circle"></i> Concluído
                                        </span>
                                        <br><small class="text-muted">Senha alterada em {{ $user->password_changed_at?->format('d/m/Y H:i') }}</small>
                                    @endif
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <td class="fw-bold">Cadastrado em:</td>
                                <td>{{ $user->created_at->format('d/m/Y H:i') }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Última atualização:</td>
                                <td>{{ $user->updated_at->format('d/m/Y H:i') }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Último login:</td>
                                <td>
                                    @if($user->last_login_at ?? false)
                                        {{ $user->last_login_at->format('d/m/Y H:i') }}
                                    @else
                                        <span class="text-muted">Nunca logou</span>
                                    @endif
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <!-- Ações Administrativas -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="bi bi-gear"></i> Ações Administrativas
                </h6>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('users.edit', $user) }}" class="btn btn-warning">
                        <i class="bi bi-pencil"></i> Editar Usuário
                    </a>
                    
                    <form action="{{ route('users.reset-password', $user) }}" method="POST" 
                          onsubmit="return confirm('Tem certeza que deseja resetar a senha deste usuário? Uma nova senha temporária será gerada.')">
                        @csrf
                        <button type="submit" class="btn btn-info">
                            <i class="bi bi-arrow-clockwise"></i> Resetar Senha
                        </button>
                    </form>
                    
                    @if($user->id !== auth()->id())
                    <form action="{{ route('users.destroy', $user) }}" method="POST" 
                          onsubmit="return confirm('Tem certeza que deseja excluir este usuário? Esta ação não pode ser desfeita.')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="bi bi-trash"></i> Excluir Usuário
                        </button>
                    </form>
                    @else
                    <button type="button" class="btn btn-danger" disabled 
                            title="Você não pode excluir sua própria conta">
                        <i class="bi bi-trash"></i> Excluir Usuário
                    </button>
                    @endif
                </div>
            </div>
        </div>

        <!-- Informações de Segurança -->
        <div class="card bg-light">
            <div class="card-header">
                <i class="bi bi-shield-check"></i> Segurança
            </div>
            <div class="card-body">
                <h6>Permissões:</h6>
                <ul class="small">
                    <li>Acesso completo ao sistema</li>
                    <li>Gerenciar veículos</li>
                    <li>Gerenciar motoristas</li>
                    <li>Gerenciar viagens</li>
                    <li>Gerenciar outros usuários</li>
                </ul>
                
                @if($user->first_access)
                <div class="alert alert-warning mt-3">
                    <i class="bi bi-exclamation-triangle"></i>
                    <strong>Pendente:</strong> Este usuário ainda não fez o primeiro acesso.
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
