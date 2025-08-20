
@extends('layouts.admin-simple')
@section('title', 'Nova Viagem')
@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2"><i class="bi bi-plus-circle"></i> Nova Viagem</h1>
    <a href="{{ route('trips.index') }}" class="btn btn-outline-secondary"><i class="bi bi-arrow-left"></i> Voltar</a>
</div>
<div class="card shadow">
    <div class="card-body">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form action="{{ route('trips.store') }}" method="POST">
            @csrf
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="vehicle_id" class="form-label">Veículo</label>
                    <select name="vehicle_id" id="vehicle_id" class="form-select" required>
                        <option value="">Selecione</option>
                        @foreach($vehicles as $vehicle)
                            <option value="{{ $vehicle->id }}">{{ $vehicle->plate }} - {{ $vehicle->model }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="driver_id" class="form-label">Motorista</label>
                    <select name="driver_id" id="driver_id" class="form-select" required>
                        <option value="">Selecione</option>
                        @foreach($drivers as $driver)
                            <option value="{{ $driver->id }}">{{ $driver->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="origin" class="form-label">Origem</label>
                    <input type="text" name="origin" id="origin" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label for="destination" class="form-label">Destino</label>
                    <input type="text" name="destination" id="destination" class="form-control" required>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="departure_time" class="form-label">Data/Hora de Partida</label>
                    <input type="datetime-local" name="departure_time" id="departure_time" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label for="arrival_time" class="form-label">Data/Hora de Chegada</label>
                    <input type="datetime-local" name="arrival_time" id="arrival_time" class="form-control" required>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="passenger_count" class="form-label">Nº de Passageiros</label>
                    <input type="number" name="passenger_count" id="passenger_count" class="form-control" min="1" required>
                </div>
                <div class="col-md-4">
                    <label for="price" class="form-label">Valor (R$)</label>
                    <input type="number" name="price" id="price" class="form-control" min="0" step="0.01" required>
                </div>
                <div class="col-md-4">
                    <label for="status" class="form-label">Status</label>
                    <select name="status" id="status" class="form-select" required>
                        <option value="scheduled">Agendada</option>
                        <option value="in_progress">Em andamento</option>
                        <option value="completed">Concluída</option>
                        <option value="cancelled">Cancelada</option>
                    </select>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="description" class="form-label">Descrição</label>
                    <textarea name="description" id="description" class="form-control" rows="2"></textarea>
                </div>
                <div class="col-md-6">
                    <label for="observations" class="form-label">Observações</label>
                    <textarea name="observations" id="observations" class="form-control" rows="2"></textarea>
                </div>
            </div>
            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-primary"><i class="bi bi-check-circle"></i> Salvar</button>
            </div>
        </form>
    </div>
</div>
@endsection
