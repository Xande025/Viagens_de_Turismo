@extends('layouts.main')

@php
    $active = 'veiculos';
    $title = 'Gerenciamento de Veículos';
    // Page-specific CSS will be included via the styles section
@endphp

@section('styles')
    <link href="{{ asset('css/vehicles.css') }}" rel="stylesheet">
    <style>
        /* Estilo para cabeçalhos da tabela */
        .vehicles-table thead th {
            color: #383838 !important;
            font-family: Roboto, sans-serif;
            font-size: 16px;
            font-style: normal;
            font-weight: 400;
            line-height: 148.7%;
        }
        
        /* Estilo para conteúdo das células da tabela */
        .vehicles-table tbody td {
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
    <x-header addLabel="+ Adicionar veículo" addTarget="vehicleOffcanvas" filterLabel="Filtrar" searchPlaceholder="Pesquisar veículo" />
@endsection

@section('content')
    <div class="content flex-grow-1 p-4">
        <!-- Breadcrumbs -->
        @if(isset($breadcrumbs) && count($breadcrumbs) > 0)
            <nav aria-label="breadcrumb" class="mb-3">
                <ol class="breadcrumb">
                    @foreach($breadcrumbs as $breadcrumb)
                        @if($loop->last)
                            <li class="breadcrumb-item active" aria-current="page">{{ $breadcrumb['title'] }}</li>
                        @else
                            <li class="breadcrumb-item">
                                @if($breadcrumb['url'])
                                    <a href="{{ $breadcrumb['url'] }}">{{ $breadcrumb['title'] }}</a>
                                @else
                                    {{ $breadcrumb['title'] }}
                                @endif
                            </li>
                        @endif
                    @endforeach
                </ol>
            </nav>
        @endif

        <!-- Messages -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <table class="table vehicles-table mb-0">
            <thead>
                <tr>
                    <th>Prefixo</th>
                    <th>Placa</th>
                    <th>Modelo</th>
                    <th>Chassi</th>
                    <th>Tipo de veículo</th>
                    <th>Capacidade</th>
                    <th>Ano</th>
                    <th style="width: 50px;"></th>
                </tr>
            </thead>
            <tbody>
                @forelse($vehicles as $vehicle)
                <tr>
                    <td>{{ $vehicle->identification_name ?? 'N/A' }}</td>
                    <td><strong>{{ $vehicle->plate }}</strong></td>
                    <td>{{ $vehicle->model }}</td>
                    <td>{{ $vehicle->brand }}</td>
                    <td>{{ $vehicle->bus_type ?? 'N/A' }}</td>
                    <td>{{ $vehicle->capacity }} passageiros</td>
                    <td>{{ $vehicle->year }}</td>
                    <td class="text-end">
                        <div class="dropdown">
                            <button class="btn btn-sm btn-link px-2 dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                @include('partials.icons.ellipsis')
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item d-flex align-items-center" href="#" onclick="editVehicle({{ $vehicle->id }}, '{{ $vehicle->plate }}', '{{ $vehicle->model }}', '{{ $vehicle->brand }}', {{ $vehicle->capacity }}, {{ $vehicle->year }}, '{{ $vehicle->status }}', '{{ $vehicle->description }}')"><span class="me-2">@include('partials.icons.edit')</span>Editar veículo</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item d-flex align-items-center text-danger" href="#" onclick="deleteVehicle({{ $vehicle->id }}, '{{ $vehicle->plate }}')"><span class="me-2">@include('partials.icons.delete')</span>Deletar veículo</a></li>
                            </ul>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center py-4">
                        <div class="text-muted">
                            <i class="fas fa-bus fa-2x mb-3"></i>
                            <p class="mb-0">Nenhum veículo cadastrado</p>
                            <small>Clique em "Adicionar veículo" para começar</small>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Paginação -->
        @if($vehicles->hasPages())
            <div class="d-flex justify-content-center mt-4">
                {{ $vehicles->links() }}
            </div>
        @endif
    </div>

        <!-- Offcanvas for vehicle form -->
        <div class="offcanvas offcanvas-end" tabindex="-1" id="vehicleOffcanvas" aria-labelledby="vehicleOffcanvasTitle">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="vehicleOffcanvasTitle">Novo Veículo</h5>
            <div>
                <button class="btn btn-link p-0 me-2 d-none" id="deleteBtn" onclick="confirmDelete()">@include('partials.icons.delete')</button>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Fechar"></button>
            </div>
        </div>
        <div class="offcanvas-body">
            <form id="vehicleForm" method="POST" action="{{ route('vehicles.store') }}">
                @csrf
                <div id="methodField"></div>
                
                <!-- Nome da identificação -->
                <div class="mb-3">
                    <label class="form-label text-muted small">Nome da identificação:</label>
                    <x-input placeholder="Ônibus Turundo 125" name="identification_name" required />
                </div>

                <!-- Placa -->
                <div class="mb-3">
                    <label class="form-label text-muted small">Placa:</label>
                    <x-input placeholder="IVS-2622" name="plate" required />
                </div>

                <!-- Modelo -->
                <div class="mb-3">
                    <label class="form-label text-muted small">Modelo:</label>
                    <x-input placeholder="Marcopolo" name="model" required />
                </div>

                <!-- Chassi -->
                <div class="mb-3">
                    <label class="form-label text-muted small">Chassi:</label>
                    <x-input placeholder="Scania" name="brand" required />
                </div>

                <!-- Capacidade -->
                <div class="mb-3">
                    <label class="form-label text-muted small">Capacidade:</label>
                    <x-input type="number" placeholder="45" name="capacity" min="1" max="100" required />
                </div>

                <!-- Tipo de ônibus -->
                <div class="mb-3">
                    <label class="form-label text-muted small">Tipo de ônibus:</label>
                    <x-input placeholder="Ônibus Rodoviário" name="bus_type" required />
                </div>

                <!-- Ano -->
                <div class="mb-3">
                    <label class="form-label text-muted small">Ano:</label>
                    <x-input type="number" placeholder="2008" name="year" min="1900" max="{{ date('Y') + 1 }}" required />
                </div>

                <!-- Seção de recursos -->
                <div class="mb-4">
                    <div class="row g-2">
                        <div class="col-6">
                            <button type="button" class="btn btn-outline-secondary w-100 d-flex align-items-center justify-content-center py-2" id="internetBtn">
                                <span class="me-2">@include('partials.icons.internet')</span>
                                Internet
                            </button>
                        </div>
                        <div class="col-6">
                            <button type="button" class="btn btn-outline-secondary w-100 d-flex align-items-center justify-content-center py-2" id="wcBtn">
                                <span class="me-2">@include('partials.icons.wc')</span>
                                WC
                            </button>
                        </div>
                        <div class="col-6">
                            <button type="button" class="btn btn-outline-secondary w-100 d-flex align-items-center justify-content-center py-2" id="geladeiralBtn">
                                <span class="me-2">@include('partials.icons.fridge')</span>
                                Geladeira
                            </button>
                        </div>
                        <div class="col-6">
                            <button type="button" class="btn btn-outline-secondary w-100 d-flex align-items-center justify-content-center py-2" id="aquecedorBtn">
                                <span class="me-2">@include('partials.icons.heater')</span>
                                Ar Condicionado
                            </button>
                        </div>
                        <div class="col-12">
                            <button type="button" class="btn btn-outline-secondary w-100 d-flex align-items-center justify-content-center py-2" id="videoBtn">
                                <span class="me-2">@include('partials.icons.video')</span>
                                Vídeo
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Campos ocultos para recursos -->
                <input type="hidden" name="has_internet" id="hasInternet" value="0">
                <input type="hidden" name="has_wc" id="hasWc" value="0">
                <input type="hidden" name="has_fridge" id="hasFridge" value="0">
                <input type="hidden" name="has_heater" id="hasHeater" value="0">
                <input type="hidden" name="has_video" id="hasVideo" value="0">

                <!-- Botões de ação -->
                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary" style="background-color: #6f42c1; border-color: #6f42c1;">
                        Finalizar cadastro
                    </button>
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="offcanvas">
                        Cancelar
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal de confirmação de exclusão -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Confirmar Exclusão</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Tem certeza que deseja excluir o veículo <strong id="vehicleToDelete"></strong>?
                    <br><small class="text-muted">Esta ação não pode ser desfeita.</small>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <form id="deleteForm" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Excluir</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        let currentVehicleId = null;
        
        // Função para abrir o modal em modo de criação
        function openCreateModal() {
            document.getElementById('vehicleOffcanvasTitle').textContent = 'Novo Veículo';
            document.getElementById('vehicleForm').action = "{{ route('vehicles.store') }}";
            document.getElementById('methodField').innerHTML = '';
            document.getElementById('deleteBtn').classList.add('d-none');
            document.getElementById('vehicleForm').reset();
            currentVehicleId = null;
        }
        
        // Função para abrir o modal em modo de edição
        function editVehicle(id, plate, model, brand, capacity, year, status, description) {
            currentVehicleId = id;
            document.getElementById('vehicleOffcanvasTitle').textContent = 'Editar Veículo';
            document.getElementById('vehicleForm').action = `/vehicles/${id}`;
            document.getElementById('methodField').innerHTML = '<input type="hidden" name="_method" value="PUT">';
            document.getElementById('deleteBtn').classList.remove('d-none');
            
            // Preencher campos
            document.querySelector('input[name="plate"]').value = plate;
            document.querySelector('input[name="model"]').value = model;
            document.querySelector('input[name="brand"]').value = brand;
            document.querySelector('input[name="capacity"]').value = capacity;
            document.querySelector('input[name="year"]').value = year;
            document.querySelector('select[name="status"]').value = status;
            document.querySelector('textarea[name="description"]').value = description || '';
            
            // Abrir o offcanvas
            const offcanvas = new bootstrap.Offcanvas(document.getElementById('vehicleOffcanvas'));
            offcanvas.show();
        }
        
        // Função para confirmar exclusão
        function confirmDelete() {
            if (currentVehicleId) {
                const plate = document.querySelector('input[name="plate"]').value;
                document.getElementById('vehicleToDelete').textContent = plate;
                document.getElementById('deleteForm').action = `/vehicles/${currentVehicleId}`;
                
                const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
                deleteModal.show();
            }
        }
        
        // Função para excluir veículo diretamente da tabela
        function deleteVehicle(id, plate) {
            document.getElementById('vehicleToDelete').textContent = plate;
            document.getElementById('deleteForm').action = `/vehicles/${id}`;
            
            const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
            deleteModal.show();
        }
        
        // Event listener para o botão de adicionar
        document.addEventListener('DOMContentLoaded', function() {
            const addButton = document.querySelector('[data-bs-target="#vehicleOffcanvas"]');
            if (addButton) {
                addButton.addEventListener('click', openCreateModal);
            }

            // Controle dos botões de recursos
            const resourceButtons = [
                { btn: '#internetBtn', input: '#hasInternet' },
                { btn: '#wcBtn', input: '#hasWc' },
                { btn: '#geladeiralBtn', input: '#hasFridge' },
                { btn: '#aquecedorBtn', input: '#hasHeater' },
                { btn: '#videoBtn', input: '#hasVideo' }
            ];

            resourceButtons.forEach(resource => {
                const button = document.querySelector(resource.btn);
                const input = document.querySelector(resource.input);
                
                if (button && input) {
                    button.addEventListener('click', function(e) {
                        e.preventDefault();
                        
                        // Toggle do estado do botão
                        if (button.classList.contains('btn-outline-secondary')) {
                            button.classList.remove('btn-outline-secondary');
                            button.classList.add('btn-primary');
                            input.value = '1';
                        } else {
                            button.classList.remove('btn-primary');
                            button.classList.add('btn-outline-secondary');
                            input.value = '0';
                        }
                    });
                }
            });
        });
    </script>
@endsection