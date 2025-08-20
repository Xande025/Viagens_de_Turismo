
@extends('layouts.admin-simple')
@section('title', 'Detalhes do Motorista')
@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">
        <i class="bi bi-person-badge"></i> {{ $driver->name }}
    </h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <a href="{{ route('drivers.edit', $driver) }}" class="btn btn-warning">
                <i class="bi bi-pencil"></i> Editar
            </a>
            <a href="{{ route('drivers.index') }}" class="btn btn-secondary">
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
                    <i class="bi bi-info-circle"></i> Informações do Motorista
                </h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <td class="fw-bold">Nome:</td>
                                <td>{{ $driver->name }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">CPF:</td>
                                <td>{{ $driver->cpf }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Telefone:</td>
                                <td>{{ $driver->phone }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Email:</td>
                                <td>{{ $driver->email }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <td class="fw-bold">CNH:</td>
                                <td>{{ $driver->cnh }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Categoria:</td>
                                <td>{{ $driver->cnh_category }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Validade CNH:</td>
                                <td>{{ \Carbon\Carbon::parse($driver->cnh_expiry)->format('d/m/Y') }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Status:</td>
                                <td>
                                    @php
                                        $statusConfig = [
                                            'active' => ['class' => 'success', 'icon' => 'check-circle', 'text' => 'Ativo'],
                                            'inactive' => ['class' => 'secondary', 'icon' => 'slash-circle', 'text' => 'Inativo']
                                        ];
                                        $config = $statusConfig[$driver->status] ?? $statusConfig['inactive'];
                                    @endphp
                                    <span class="badge bg-{{ $config['class'] }}">
                                        <i class="bi bi-{{ $config['icon'] }}"></i> {{ $config['text'] }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Cadastrado em:</td>
                                <td>{{ \Carbon\Carbon::parse($driver->created_at)->format('d/m/Y H:i') }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Última atualização:</td>
                                <td>{{ \Carbon\Carbon::parse($driver->updated_at)->format('d/m/Y H:i') }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <!-- Ações -->
        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="bi bi-gear"></i> Ações
                </h6>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('drivers.edit', $driver) }}" class="btn btn-warning">
                        <i class="bi bi-pencil"></i> Editar Motorista
                    </a>
                    <form action="{{ route('drivers.destroy', $driver) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir este motorista?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="bi bi-trash"></i> Excluir Motorista
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
