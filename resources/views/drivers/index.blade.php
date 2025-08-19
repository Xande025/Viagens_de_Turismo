@extends('layouts.admin-simple')

@section('title', 'Motoristas')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">
        <i class="bi bi-person-badge"></i> Gerenciar Motoristas
    </h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('drivers.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Novo Motorista
        </a>
    </div>
</div>

<div class="card shadow">
    <div class="card-body">
        @if($drivers->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>Nome</th>
                            <th>CNH</th>
                            <th>Categoria</th>
                            <th>Validade CNH</th>
                            <th>Status</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($drivers as $driver)
                        <tr>
                            <td>
                                <strong>{{ $driver->name }}</strong>
                                @if($driver->email)
                                    <br><small class="text-muted">{{ $driver->email }}</small>
                                @endif
                            </td>
                            <td>{{ $driver->cnh }}</td>
                            <td><span class="badge bg-info">{{ $driver->cnh_category }}</span></td>
                            <td>
                                {{ $driver->cnh_expiry->format('d/m/Y') }}
                                @if($driver->cnh_expiry < now()->addMonths(3))
                                    <i class="bi bi-exclamation-triangle text-warning" title="CNH vence em breve"></i>
                                @endif
                            </td>
                            <td>
                                <span class="badge bg-{{ $driver->status === 'active' ? 'success' : 'danger' }}">
                                    {{ $driver->status === 'active' ? 'Ativo' : 'Inativo' }}
                                </span>
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('drivers.show', $driver) }}" 
                                       class="btn btn-sm btn-outline-info" title="Visualizar">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('drivers.edit', $driver) }}" 
                                       class="btn btn-sm btn-outline-warning" title="Editar">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('drivers.destroy', $driver) }}" 
                                          method="POST" class="d-inline"
                                          onsubmit="return confirm('Tem certeza que deseja excluir este motorista?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Excluir">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Paginação -->
            <div class="d-flex justify-content-between align-items-center mt-3">
                <div>
                    <small class="text-muted">
                        Mostrando {{ $drivers->firstItem() }} a {{ $drivers->lastItem() }} 
                        de {{ $drivers->total() }} registros
                    </small>
                </div>
                <div>
                    {{ $drivers->links() }}
                </div>
            </div>
        @else
            <div class="text-center py-5">
                <i class="bi bi-person-badge" style="font-size: 4rem; color: #dee2e6;"></i>
                <h4 class="mt-3 text-muted">Nenhum motorista cadastrado</h4>
                <p class="text-muted mb-4">Comece adicionando seu primeiro motorista ao sistema.</p>
                <a href="{{ route('drivers.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle"></i> Cadastrar Primeiro Motorista
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
