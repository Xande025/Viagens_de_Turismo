@extends('layouts.admin')
@section('title', 'Novo Motorista')
@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2"><i class="bi bi-person-badge"></i> Novo Motorista</h1>
    <a href="{{ route('drivers.index') }}" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Voltar</a>
</div>
<div class="card shadow">
    <div class="card-body">
        <form action="{{ route('drivers.store') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="name" class="form-label">Nome *</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                           id="name" name="name" value="{{ old('name') }}" required>
                    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label for="cpf" class="form-label">CPF *</label>
                    <input type="text" class="form-control @error('cpf') is-invalid @enderror" 
                           id="cpf" name="cpf" value="{{ old('cpf') }}" maxlength="11" required>
                    @error('cpf')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="cnh" class="form-label">CNH *</label>
                    <input type="text" class="form-control @error('cnh') is-invalid @enderror" 
                           id="cnh" name="cnh" value="{{ old('cnh') }}" required>
                    @error('cnh')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-3 mb-3">
                    <label for="cnh_category" class="form-label">Categoria *</label>
                    <select class="form-select @error('cnh_category') is-invalid @enderror" 
                            id="cnh_category" name="cnh_category" required>
                        <option value="">Selecione</option>
                        <option value="A" {{ old('cnh_category') === 'A' ? 'selected' : '' }}>A</option>
                        <option value="B" {{ old('cnh_category') === 'B' ? 'selected' : '' }}>B</option>
                        <option value="C" {{ old('cnh_category') === 'C' ? 'selected' : '' }}>C</option>
                        <option value="D" {{ old('cnh_category') === 'D' ? 'selected' : '' }}>D</option>
                        <option value="E" {{ old('cnh_category') === 'E' ? 'selected' : '' }}>E</option>
                    </select>
                    @error('cnh_category')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-3 mb-3">
                    <label for="cnh_expiry" class="form-label">Validade CNH *</label>
                    <input type="date" class="form-control @error('cnh_expiry') is-invalid @enderror" 
                           id="cnh_expiry" name="cnh_expiry" value="{{ old('cnh_expiry') }}" required>
                    @error('cnh_expiry')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="phone" class="form-label">Telefone</label>
                    <input type="text" class="form-control @error('phone') is-invalid @enderror" 
                           id="phone" name="phone" value="{{ old('phone') }}">
                    @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" 
                           id="email" name="email" value="{{ old('email') }}">
                    @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>
            <div class="mb-3">
                <label for="status" class="form-label">Status *</label>
                <select class="form-select @error('status') is-invalid @enderror" 
                        id="status" name="status" required>
                    <option value="">Selecione o status</option>
                    <option value="active" {{ old('status') === 'active' ? 'selected' : '' }}>Ativo</option>
                    <option value="inactive" {{ old('status') === 'inactive' ? 'selected' : '' }}>Inativo</option>
                </select>
                @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                <a href="{{ route('drivers.index') }}" class="btn btn-secondary">
                    <i class="bi bi-x-circle"></i> Cancelar
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-circle"></i> Salvar Motorista
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
