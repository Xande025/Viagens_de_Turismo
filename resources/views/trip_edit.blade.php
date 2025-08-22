@extends('layouts.main')

@php
    $active = 'viagens';
    $title = 'Editar Viagem - Coinpel';
    // Page-specific CSS will be included via the styles section
@endphp

@section('styles')
    <link href="{{ asset('css/trips.css') }}" rel="stylesheet">
    <style>
        /* Additional styles specific to the edit page */
        .status-dropdown .btn {
            width: 177px;
            height: 35px;
            border-radius: 5px;
            font-size: 0.85rem;
            font-weight: 600;
        }
        .status-dropdown .dropdown-menu {
            min-width: 177px;
        }
        .form-section-title {
            font-weight: 600;
            margin-bottom: 0.5rem;
        }
        .form-control[disabled], .form-select[disabled] {
            background-color: #f6f6f6;
            opacity: 1;
        }
    </style>
@endsection

@section('header')
    {{-- Custom topbar for edit page with back button and breadcrumbs --}}
    <header class="topbar d-flex align-items-center py-3 px-4 border-bottom">
        <a href="{{ route('trips.index') }}" class="btn btn-outline-secondary me-3">Voltar</a>
        <nav aria-label="breadcrumb" class="flex-grow-1">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('trips.index') }}" class="text-decoration-none">Viagens</a></li>
                <li class="breadcrumb-item active" aria-current="page">Editar: {{ $trip->origin }} → {{ $trip->destination }}</li>
            </ol>
        </nav>
        <div class="d-flex align-items-center gap-3">
            <div class="position-relative me-3">
                <span class="notification-icon">@include('partials.icons.bell')</span>
            </div>
            <div class="dropdown">
                <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle" id="userMenuEdit" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="https://i.pravatar.cc/40" alt="Avatar" class="rounded-circle me-2" width="36" height="36">
                    <div class="user-info text-start">
                        <span class="d-block fw-bold" style="font-size: 0.9rem;">{{ auth()->user()->name }}</span>
                        <span class="d-block" style="font-size: 0.75rem; color: #7D7D7D;">Administrador</span>
                    </div>
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userMenuEdit">
                    <li><a class="dropdown-item d-flex align-items-center" href="{{ route('users.index') }}"><span class="me-2">@include('partials.icons.user')</span>Usuários</a></li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button class="dropdown-item d-flex align-items-center" type="submit"><span class="me-2">@include('partials.icons.logout')</span>Sair</button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </header>
@endsection

@section('content')
    <div class="container-fluid py-4">
        @if(session('success'))
            <div class="alert alert-success">{!! session('success') !!}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">{!! session('error') !!}</div>
        @endif
        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form method="POST" action="{{ route('trips.update', $trip) }}">
            @csrf
            @method('PUT')
            <div class="status-dropdown mb-4">
                <div class="dropdown">
                    <input type="hidden" name="status" id="status" value="{{ old('status', $trip->status) }}">
                    <button class="btn status-{{ $trip->status == 'in_progress' ? 'ongoing' : ($trip->status == 'completed' ? 'completed' : 'cancelled') }} dropdown-toggle" type="button" id="statusDropdownButton" data-bs-toggle="dropdown" aria-expanded="false">
                        {{ $trip->status == 'in_progress' ? 'Em andamento' : ($trip->status == 'completed' ? 'Completa' : ($trip->status == 'scheduled' ? 'Agendada' : 'Cancelada')) }}
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="statusDropdownButton">
                        <li><a class="dropdown-item" href="#" data-value="scheduled">Agendada</a></li>
                        <li><a class="dropdown-item" href="#" data-value="in_progress">Em andamento</a></li>
                        <li><a class="dropdown-item" href="#" data-value="completed">Completa</a></li>
                        <li><a class="dropdown-item" href="#" data-value="cancelled">Cancelada</a></li>
                    </ul>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-section-title">Informações da viagem:</label>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Nome da viagem:</label>
                        <input type="text" class="form-control" id="description" name="description" value="{{ old('description', $trip->description) }}" placeholder="Nome da viagem">
                    </div>
                    <div class="mb-3">
                        <label for="observations" class="form-label">Regra:</label>
                        <input type="text" class="form-control" id="observations" name="observations" value="{{ old('observations', $trip->observations) }}" placeholder="Ex: Turismo, Faculdade">
                    </div>
                    <div class="mb-3">
                        <label for="departure_time" class="form-label">Horário de Saída:</label>
                        <input type="datetime-local" class="form-control" id="departure_time" name="departure_time" value="{{ old('departure_time', $trip->departure_time->format('Y-m-d\TH:i')) }}">
                    </div>
                    <div class="mb-3">
                        <label for="destination" class="form-label">Destino:</label>
                        <input type="text" class="form-control" id="destination" name="destination" value="{{ old('destination', $trip->destination) }}" placeholder="Destino" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-section-title">Dados do veículo:</label>
                    </div>
                    <div class="mb-3">
                        <label for="vehicle_id" class="form-label">Veículo:</label>
                        <select class="form-select" id="vehicle_id" name="vehicle_id" required>
                            @foreach($vehicles as $vehicle)
                                <option value="{{ $vehicle->id }}" {{ old('vehicle_id', $trip->vehicle_id) == $vehicle->id ? 'selected' : '' }}>
                                    {{ $vehicle->license_plate }} - {{ $vehicle->type }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="driver_id" class="form-label">Motorista:</label>
                        <select class="form-select" id="driver_id" name="driver_id" required>
                            @foreach($drivers as $driver)
                                <option value="{{ $driver->id }}" {{ old('driver_id', $trip->driver_id) == $driver->id ? 'selected' : '' }}>
                                    {{ $driver->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-4"></div>
                    <div class="mb-3">
                        <label for="arrival_time" class="form-label">Data/Hora de Chegada:</label>
                        <input type="datetime-local" class="form-control" id="arrival_time" name="arrival_time" value="{{ old('arrival_time', $trip->arrival_time->format('Y-m-d\TH:i')) }}">
                    </div>
                    <div class="mb-3">
                        <label for="origin" class="form-label">Origem:</label>
                        <input type="text" class="form-control" id="origin" name="origin" value="{{ old('origin', $trip->origin) }}" placeholder="Origem" required>
                    </div>
                    <div class="mb-3">
                        <label for="price" class="form-label">Valor da passagem avulsa:</label>
                        <input type="number" step="0.01" class="form-control" id="price" name="price" value="{{ old('price', $trip->price) }}" placeholder="0.00">
                    </div>
                    <div class="mb-3">
                        <label for="passenger_count" class="form-label">Número de passageiros:</label>
                        <input type="number" class="form-control" id="passenger_count" name="passenger_count" value="{{ old('passenger_count', $trip->passenger_count) }}" min="1">
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-start mt-4 gap-3">
                <button type="submit" class="btn btn-primary">Salvar alterações</button>
                <a href="{{ route('trips.index') }}" class="btn btn-outline-secondary">Cancelar</a>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
<script>
    // Script to update status button based on dropdown selection
    document.addEventListener('DOMContentLoaded', function () {
        var statusButton = document.getElementById('statusDropdownButton');
        var statusItems = document.querySelectorAll('.status-dropdown .dropdown-item');
        var statusInput = document.getElementById('status');
        
        statusItems.forEach(function(item){
            item.addEventListener('click', function(e){
                e.preventDefault();
                var value = item.getAttribute('data-value');
                var text = item.textContent.trim();
                
                // Update button text
                statusButton.textContent = text;
                
                // Update hidden input
                statusInput.value = value;
                
                // Remove existing status classes
                statusButton.classList.remove('status-ongoing','status-completed','status-cancelled');
                
                // Add new class based on selection
                if(value === 'in_progress') statusButton.classList.add('status-ongoing');
                else if(value === 'completed') statusButton.classList.add('status-completed');
                else if(value === 'cancelled') statusButton.classList.add('status-cancelled');
                else if(value === 'scheduled') statusButton.classList.add('status-ongoing');
            });
        });
    });
</script>
@endpush