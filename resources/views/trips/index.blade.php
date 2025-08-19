@extends('layouts.admin-simple')
@section('title', 'Viagens')
@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2"><i class="bi bi-map"></i> Gerenciar Viagens</h1>
    <a href="{{ route('trips.create') }}" class="btn btn-primary"><i class="bi bi-plus-circle"></i> Nova Viagem</a>
</div>
<div class="card shadow">
    <div class="card-body">
        @if($trips->count() > 0)
        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="table-dark">
                    <tr><th>Origem → Destino</th><th>Partida</th><th>Chegada</th><th>Veículo</th><th>Status</th><th>Ações</th></tr>
                </thead>
                <tbody>
                    @foreach($trips as $trip)
                    <tr>
                        <td><strong>{{ $trip->origin }}</strong> → {{ $trip->destination }}</td>
                        <td>{{ $trip->departure_time->format('d/m/Y H:i') }}</td>
                        <td>{{ $trip->arrival_time->format('d/m/Y H:i') }}</td>
                        <td>{{ $trip->vehicle->plate }}</td>
                        <td>
                            <span class="badge bg-{{ $trip->status === 'completed' ? 'success' : ($trip->status === 'in_progress' ? 'warning' : 'primary') }}">
                                {{ ucfirst(str_replace('_', ' ', $trip->status)) }}
                            </span>
                        </td>
                        <td>
                            <div class="btn-group">
                                <a href="{{ route('trips.show', $trip) }}" class="btn btn-sm btn-outline-info"><i class="bi bi-eye"></i></a>
                                <a href="{{ route('trips.edit', $trip) }}" class="btn btn-sm btn-outline-warning"><i class="bi bi-pencil"></i></a>
                                <form action="{{ route('trips.destroy', $trip) }}" method="POST" class="d-inline"
                                      onsubmit="return confirm('Tem certeza?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{ $trips->links() }}
        @else
        <div class="text-center py-5">
            <i class="bi bi-map" style="font-size: 4rem; color: #dee2e6;"></i>
            <h4 class="mt-3 text-muted">Nenhuma viagem cadastrada</h4>
            <a href="{{ route('trips.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Cadastrar Primeira Viagem
            </a>
        </div>
        @endif
    </div>
</div>
@endsection
