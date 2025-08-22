@extends('layouts.main')

@php
    // Set active menu item for sidebar
    $active = 'viagens';
    // Define page title and custom styles
    $title = 'Gerenciamento de Viagens - Coinpel';
    // Page-specific CSS will be included via the styles section
@endphp

@section('styles')
    <link href="{{ asset('css/trips.css') }}" rel="stylesheet">
    <style>
        /* Estilo para cabeçalhos da tabela */
        .trips-table thead th {
            color: #212121 !important;
            font-family: Roboto, sans-serif;
            font-size: 16px;
            font-style: normal;
            font-weight: 400;
            line-height: 148.7%;
        }
        
        /* Estilo para conteúdo das células da tabela */
        .trips-table tbody td {
            color: #9E9E9E !important;
            font-family: Roboto, sans-serif;
            font-size: 16px;
            font-style: normal;
            font-weight: 400;
            line-height: 148.7%;
        }

        /* Remove dropdown arrow */
        .dropdown-toggle::after {
            display: none !important;
        }

        /* Hover effect for dropdown button */
        .dropdown-toggle {
            transition: transform 0.2s ease-in-out;
        }

        .dropdown-toggle:hover {
            transform: scale(1.1);
        }
    </style>
@endsection

@section('header')
    {{-- Use the header component with add and filter buttons and search box --}}
    <x-header addLabel="+ Adicionar viagem" addTarget="tripOffcanvas" filterLabel="Filtrar" searchPlaceholder="Pesquisar viagem" />
@endsection

@section('content')
    <div class="content flex-grow-1 p-4">
        @if(session('success'))
            <div class="alert alert-success">{!! session('success') !!}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">{!! session('error') !!}</div>
        @endif
        <table class="table trips-table mb-0">
            <thead>
                <tr>
                    <th>Status</th>
                    <th>Nome</th>
                    <th>Data</th>
                    <th>Horário</th>
                    <th>Rota</th>
                    <th>Veículo</th>
                    <th>Regra</th>
                    <th>Motorista</th>
                    <th style="width: 50px;"></th>
                </tr>
            </thead>
            <tbody>
                @forelse($trips as $trip)
                <tr>
                    <td>
                        @if($trip->status == 'scheduled')
                            Agendada
                        @elseif($trip->status == 'in_progress')
                            Em andamento
                        @elseif($trip->status == 'completed')
                            Completa
                        @elseif($trip->status == 'cancelled')
                            Cancelada
                        @endif
                    </td>
                    <td>{{ $trip->description ?? $trip->origin . ' → ' . $trip->destination }}</td>
                    <td>{{ $trip->departure_time->format('d/m/Y') }}</td>
                    <td>{{ $trip->departure_time->format('H:i') }}</td>
                    <td>{{ $trip->origin }} ➜ {{ $trip->destination }}</td>
                    <td>{{ $trip->vehicle->plate ?? 'N/A' }} - {{ $trip->vehicle->model ?? 'N/A' }}</td>
                    <td>{{ $trip->observations ?? 'N/A' }}</td>
                    <td>{{ $trip->driver->name ?? 'N/A' }}</td>
                    <td class="text-end">
                        <div class="dropdown">
                            <button class="btn btn-sm btn-link px-2 dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                @include('partials.icons.ellipsis')
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item d-flex align-items-center" href="{{ route('trips.edit', $trip) }}"><span class="me-2">@include('partials.icons.edit')</span>Editar viagem</a></li>
                                <li>
                                    <form method="POST" action="{{ route('trips.destroy', $trip) }}" onsubmit="return confirm('Tem certeza que deseja deletar esta viagem?');">
                                        @csrf
                                        @method('DELETE')
                                        <button class="dropdown-item d-flex align-items-center text-danger" type="submit"><span class="me-2">@include('partials.icons.delete')</span>Deletar viagem</button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" class="text-center py-4">
                        <p class="mb-0 text-muted">Nenhuma viagem cadastrada.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
        <div class="mt-3">
            {{ $trips->links() }}
        </div>
    </div>

    <!-- Offcanvas for trip form -->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="tripOffcanvas" aria-labelledby="tripOffcanvasTitle">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="tripOffcanvasTitle">Nova Viagem</h5>
            <div>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Fechar"></button>
            </div>
        </div>
        <div class="offcanvas-body">
            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            
            <form id="tripForm" method="POST" action="{{ route('trips.store') }}">
                @csrf
                
                <div class="mb-3">
                    <label class="form-label fw-bold">Informações da viagem:</label>
                </div>
                
                <div class="mb-3">
                    <label for="description" class="form-label">Nome da viagem:</label>
                    <input type="text" class="form-control" id="description" name="description" value="{{ old('description') }}" placeholder="Nome da viagem">
                </div>
                
                <div class="mb-3">
                    <label for="observations" class="form-label">Regra:</label>
                    <input type="text" class="form-control" id="observations" name="observations" value="{{ old('observations') }}" placeholder="Ex: Turismo, Faculdade">
                </div>
                
                <div class="mb-3">
                    <label for="departure_time" class="form-label">Horário de Saída:</label>
                    <input type="datetime-local" class="form-control" id="departure_time" name="departure_time" value="{{ old('departure_time') }}" required>
                </div>
                
                <div class="mb-3">
                    <label for="origin" class="form-label">Origem:</label>
                    <input type="text" class="form-control" id="origin" name="origin" value="{{ old('origin') }}" placeholder="Origem" required>
                </div>
                
                <div class="mb-3">
                    <label for="destination" class="form-label">Destino:</label>
                    <input type="text" class="form-control" id="destination" name="destination" value="{{ old('destination') }}" placeholder="Destino" required>
                </div>
                
                <div class="mb-3">
                    <label class="form-label fw-bold">Dados do veículo:</label>
                </div>
                
                <div class="mb-3">
                    <label for="vehicle_id" class="form-label">Veículo:</label>
                    <select class="form-select" id="vehicle_id" name="vehicle_id" required>
                        <option value="">Selecione um veículo</option>
                        @if(isset($vehicles))
                            @foreach($vehicles as $vehicle)
                                <option value="{{ $vehicle->id }}" {{ old('vehicle_id') == $vehicle->id ? 'selected' : '' }}>
                                    {{ $vehicle->license_plate }} - {{ $vehicle->type }}
                                </option>
                            @endforeach
                        @endif
                    </select>
                </div>
                
                <div class="mb-3">
                    <label for="driver_id" class="form-label">Motorista:</label>
                    <select class="form-select" id="driver_id" name="driver_id" required>
                        <option value="">Selecione um motorista</option>
                        @if(isset($drivers))
                            @foreach($drivers as $driver)
                                <option value="{{ $driver->id }}" {{ old('driver_id') == $driver->id ? 'selected' : '' }}>
                                    {{ $driver->name }}
                                </option>
                            @endforeach
                        @endif
                    </select>
                </div>
                
                <div class="mb-3">
                    <label for="status" class="form-label">Status:</label>
                    <select class="form-select" id="status" name="status" required>
                        <option value="">Selecione o status</option>
                        <option value="scheduled" {{ old('status') == 'scheduled' ? 'selected' : '' }}>Agendada</option>
                        <option value="in_progress" {{ old('status') == 'in_progress' ? 'selected' : '' }}>Em andamento</option>
                        <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>Completa</option>
                        <option value="cancelled" {{ old('status') == 'cancelled' ? 'selected' : '' }}>Cancelada</option>
                    </select>
                </div>
                
                <div class="d-grid gap-2">
                    <x-button type="submit" style="primary" label="Salvar viagem" />
                    <x-button type="button" style="secondary" label="Cancelar" data-bs-dismiss="offcanvas" />
                </div>
            </form>
        </div>
    </div>
@endsection