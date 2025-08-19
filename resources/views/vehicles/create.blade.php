@extends('layouts.admin-simple')

@section('title', 'Novo Veículo')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">
        <i class="bi bi-truck"></i> Novo Veículo
    </h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('vehicles.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Voltar
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card shadow">
            <div class="card-body">
                <form action="{{ route('vehicles.store') }}" method="POST">
                    @csrf
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="plate" class="form-label">Placa <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('plate') is-invalid @enderror" 
                                   id="plate" name="plate" value="{{ old('plate') }}" 
                                   placeholder="ABC-1234" required>
                            @error('plate')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="brand" class="form-label">Marca <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('brand') is-invalid @enderror" 
                                   id="brand" name="brand" value="{{ old('brand') }}" 
                                   placeholder="Ex: Toyota, Volkswagen..." required>
                            @error('brand')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="model" class="form-label">Modelo <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('model') is-invalid @enderror" 
                                   id="model" name="model" value="{{ old('model') }}" 
                                   placeholder="Ex: Corolla, Gol..." required>
                            @error('model')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="year" class="form-label">Ano <span class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('year') is-invalid @enderror" 
                                   id="year" name="year" value="{{ old('year') }}" 
                                   min="1900" max="{{ date('Y') + 1 }}" required>
                            @error('year')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="capacity" class="form-label">Capacidade (passageiros) <span class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('capacity') is-invalid @enderror" 
                                   id="capacity" name="capacity" value="{{ old('capacity') }}" 
                                   min="1" max="100" required>
                            @error('capacity')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                            <select class="form-select @error('status') is-invalid @enderror" 
                                    id="status" name="status" required>
                                <option value="">Selecione o status</option>
                                <option value="available" {{ old('status') === 'available' ? 'selected' : '' }}>
                                    Disponível
                                </option>
                                <option value="in_use" {{ old('status') === 'in_use' ? 'selected' : '' }}>
                                    Em Uso
                                </option>
                                <option value="maintenance" {{ old('status') === 'maintenance' ? 'selected' : '' }}>
                                    Manutenção
                                </option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Descrição</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" 
                                  id="description" name="description" rows="3" 
                                  placeholder="Informações adicionais sobre o veículo...">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <a href="{{ route('vehicles.index') }}" class="btn btn-secondary">
                            <i class="bi bi-x-circle"></i> Cancelar
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-circle"></i> Salvar Veículo
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card bg-light">
            <div class="card-header">
                <i class="bi bi-info-circle"></i> Informações
            </div>
            <div class="card-body">
                <h6>Dicas para cadastro:</h6>
                <ul class="small">
                    <li>A placa deve ser única no sistema</li>
                    <li>Informe a capacidade real de passageiros</li>
                    <li>Use o status "Disponível" para veículos prontos para uso</li>
                    <li>Use "Manutenção" para veículos que não podem ser utilizados</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
