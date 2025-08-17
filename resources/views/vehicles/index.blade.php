@extends('layouts.admin')

@section('title', 'Veículos')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">
        <i class="bi bi-truck"></i> Gerenciar Veículos
    </h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('vehicles.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Novo Veículo
        </a>
    </div>
</div>

<div class="card shadow">
    <div class="card-body">
        @if($vehicles->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>Placa</th>
                            <th>Veículo</th>
                            <th>Ano</th>
                            <th>Capacidade</th>
                            <th>Status</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($vehicles as $vehicle)
                        <tr>
                            <td>
                                <strong>{{ $vehicle->plate }}</strong>
                            </td>
                            <td>
                                {{ $vehicle->brand }} {{ $vehicle->model }}
                            </td>
                            <td>{{ $vehicle->year }}</td>
                            <td>
                                <i class="bi bi-people"></i> {{ $vehicle->capacity }}
                            </td>
                            <td>
                                @php
                                    $statusConfig = [
                                        'available' => ['class' => 'success', 'icon' => 'check-circle', 'text' => 'Disponível'],
                                        'in_use' => ['class' => 'warning', 'icon' => 'clock', 'text' => 'Em Uso'],
                                        'maintenance' => ['class' => 'danger', 'icon' => 'tools', 'text' => 'Manutenção']
                                    ];
                                    $config = $statusConfig[$vehicle->status];
                                @endphp
                                <span class="badge bg-{{ $config['class'] }}">
                                    <i class="bi bi-{{ $config['icon'] }}"></i> {{ $config['text'] }}
                                </span>
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('vehicles.show', $vehicle) }}" 
                                       class="btn btn-sm btn-outline-info" title="Visualizar">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('vehicles.edit', $vehicle) }}" 
                                       class="btn btn-sm btn-outline-warning" title="Editar">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('vehicles.destroy', $vehicle) }}" 
                                          method="POST" class="d-inline"
                                          onsubmit="return confirm('Tem certeza que deseja excluir este veículo?')">
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
                        Mostrando {{ $vehicles->firstItem() }} a {{ $vehicles->lastItem() }} 
                        de {{ $vehicles->total() }} registros
                    </small>
                </div>
                <div>
                    {{ $vehicles->links() }}
                </div>
            </div>
        @else
            <div class="text-center py-5">
                <i class="bi bi-truck" style="font-size: 4rem; color: #dee2e6;"></i>
                <h4 class="mt-3 text-muted">Nenhum veículo cadastrado</h4>
                <p class="text-muted mb-4">Comece adicionando seu primeiro veículo ao sistema.</p>
                <a href="{{ route('vehicles.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle"></i> Cadastrar Primeiro Veículo
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
