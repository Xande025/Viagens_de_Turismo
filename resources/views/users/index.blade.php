@extends('layouts.admin')
@section('title', 'Usuários')
@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2"><i class="bi bi-people"></i> Gerenciar Usuários</h1>
    <a href="{{ route('users.create') }}" class="btn btn-primary"><i class="bi bi-plus-circle"></i> Novo Usuário</a>
</div>
<div class="card shadow">
    <div class="card-body">
        @if($users->count() > 0)
        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="table-dark">
                    <tr><th>Nome</th><th>Email</th><th>Primeiro Acesso</th><th>Cadastrado</th><th>Ações</th></tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                    <tr>
                        <td><strong>{{ $user->name }}</strong></td>
                        <td>{{ $user->email }}</td>
                        <td>
                            @if($user->first_access)
                                <span class="badge bg-warning">Pendente</span>
                            @else
                                <span class="badge bg-success">Concluído</span>
                            @endif
                        </td>
                        <td>{{ $user->created_at->format('d/m/Y') }}</td>
                        <td>
                            <div class="btn-group">
                                <a href="{{ route('users.show', $user) }}" class="btn btn-sm btn-outline-info"><i class="bi bi-eye"></i></a>
                                <a href="{{ route('users.edit', $user) }}" class="btn btn-sm btn-outline-warning"><i class="bi bi-pencil"></i></a>
                                @if($user->id !== auth()->id())
                                <form action="{{ route('users.destroy', $user) }}" method="POST" class="d-inline"
                                      onsubmit="return confirm('Tem certeza?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{ $users->links() }}
        @else
        <div class="text-center py-5">
            <i class="bi bi-people" style="font-size: 4rem; color: #dee2e6;"></i>
            <h4 class="mt-3 text-muted">Nenhum usuário cadastrado</h4>
            <a href="{{ route('users.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Cadastrar Primeiro Usuário
            </a>
        </div>
        @endif
    </div>
</div>
@endsection
