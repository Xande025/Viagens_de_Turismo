@extends('layouts.main')

@php
    $active = 'motoristas';
    $title = 'Gerenciamento de Motoristas';
    // Page-specific CSS will be included via the styles section
@endphp

@section('styles')
    <link href="{{ asset('css/drivers.css') }}" rel="stylesheet">
    <style>
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
    <x-header addLabel="+ Adicionar motorista" addTarget="driverOffcanvas" filterLabel="Filtrar" searchPlaceholder="Pesquisar motorista" />
@endsection

@section('content')
    <div class="content flex-grow-1 p-4">
        <!-- Mensagens de feedback -->
        @if(session('success'))
            <div class="alert alert-success">{!! session('success') !!}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">{!! session('error') !!}</div>
        @endif

        <div class="row g-3">
            @forelse($drivers as $driver)
                <div class="col-12 col-md-6 mb-3">
                    <x-driver-card 
                        :name="$driver->name" 
                        :email="$driver->email" 
                        :image="'https://i.pravatar.cc/60?u=' . $driver->id" 
                        offcanvasId="driverOffcanvas"
                        :driverId="$driver->id"
                        :cnh="$driver->cnh"
                    />
                </div>
            @empty
                <div class="col-12">
                    <div class="text-center py-5">
                        <h5>Nenhum motorista encontrado</h5>
                        <p class="text-muted">Adicione seu primeiro motorista clicando em "Adicionar motorista"</p>
                    </div>
                </div>
            @endforelse
        </div>

        <!-- Paginação -->
        @if($drivers->hasPages())
            <div class="d-flex justify-content-center mt-4">
                {{ $drivers->links() }}
            </div>
        @endif
    </div>

        <!-- Offcanvas for driver form -->
        <div class="offcanvas offcanvas-end" tabindex="-1" id="driverOffcanvas" aria-labelledby="driverOffcanvasTitle">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title" id="driverOffcanvasTitle">Novo Motorista</h5>
                <div>
                    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Fechar"></button>
                </div>
            </div>
            <div class="offcanvas-body">
                <form method="POST" action="{{ route('drivers.store') }}">
                    @csrf
                    
                    <h6 class="section-heading">Dados pessoais</h6>
                    
                    <x-input 
                        label="Nome completo:" 
                        placeholder="Amanda Siqueira" 
                        name="name" 
                        value="{{ old('name') }}"
                    />
                    
                    <x-input 
                        type="date" 
                        label="Data de nascimento:" 
                        name="birth_date" 
                        value="{{ old('birth_date') }}"
                    />
                    
                    <x-input 
                        label="Matrícula:" 
                        placeholder="123456" 
                        name="registration" 
                        value="{{ old('registration') }}"
                    />
                    
                    <x-input 
                        label="CPF:" 
                        placeholder="048.247.100-06" 
                        name="cpf" 
                        value="{{ old('cpf') }}"
                    />
                    
                    <x-input 
                        label="RG:" 
                        placeholder="2130204437" 
                        name="rg" 
                        value="{{ old('rg') }}"
                    />
                    
                    <h6 class="section-heading mt-4">Endereço</h6>
                    
                    <x-input 
                        label="CEP:" 
                        placeholder="96015100" 
                        name="zip_code" 
                        value="{{ old('zip_code') }}"
                    />
                    
                    <x-input 
                        label="Logradouro:" 
                        placeholder="Rua Major Cícero de Goes Monteiro" 
                        name="address" 
                        value="{{ old('address') }}"
                    />
                    
                    <x-input 
                        label="Número:" 
                        placeholder="1056" 
                        name="number" 
                        value="{{ old('number') }}"
                    />
                    
                    <div class="row">
                        <div class="col-md-8">
                            <x-input 
                                label="Cidade:" 
                                placeholder="Pelotas/RS" 
                                name="city" 
                                value="{{ old('city') }}"
                            />
                        </div>
                        <div class="col-md-4">
                            <x-input 
                                label="Estado:" 
                                placeholder="RS" 
                                name="state" 
                                value="{{ old('state') }}"
                            />
                        </div>
                    </div>

                    <h6 class="section-heading mt-4">Contato</h6>
                    
                    <x-input 
                        type="email"
                        label="Email:" 
                        placeholder="motorista@email.com" 
                        name="email" 
                        value="{{ old('email') }}"
                    />

                    <!-- Exibição de erros -->
                    @if($errors->any())
                        <div class="alert alert-danger mt-3">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    
                    <div class="d-grid gap-2 mt-4">
                        <x-button type="submit" style="primary" label="Salvar Motorista" />
                        <x-button type="button" style="secondary" label="Cancelar" data-bs-dismiss="offcanvas" />
                    </div>
                </form>
            </div>
        </div>

        <!-- Offcanvas for driver edit form -->
        <div class="offcanvas offcanvas-end" tabindex="-1" id="driverEditOffcanvas" aria-labelledby="driverEditOffcanvasTitle">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title" id="driverEditOffcanvasTitle">Motorista</h5>
                <div>
                    <button type="button" class="btn-close text-reset me-2" data-bs-dismiss="offcanvas" aria-label="Fechar"></button>
                    <button type="button" class="btn btn-sm btn-outline-danger" onclick="deleteDriver()">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </div>
            <div class="offcanvas-body">
                <form method="POST" action="{{ route('drivers.update', 0) }}" id="editDriverForm">
                    @csrf
                    @method('PUT')
                    
                    <!-- Foto de perfil -->
                    <div class="profile-section mb-4">
                        <div class="profile-label">Foto de perfil</div>
                        <div class="profile-photo-wrapper">
                            <img id="editDriverPhoto" src="https://i.pravatar.cc/80" alt="Foto do motorista" class="profile-image">
                        </div>
                        <button type="button" class="btn-update-photo" onclick="updatePhoto()">
                            Atualizar foto
                        </button>
                    </div>
                    
                    <!-- Dados pessoais -->
                    <div class="form-section mb-4">
                        <div class="section-title">
                            Dados pessoais 
                            <i class="fas fa-edit section-icon"></i>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Nome:</label>
                            <input type="text" class="form-control" name="name" id="editName" placeholder="Carlos Roberto">
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Data de nascimento:</label>
                            <input type="text" class="form-control" name="birth_date" id="editBirthDate" placeholder="04/10/1965">
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">CPF:</label>
                            <input type="text" class="form-control" name="cpf" id="editCpf" placeholder="048.247.100-06">
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">RG:</label>
                            <input type="text" class="form-control" name="rg" id="editRg" placeholder="2130204437">
                        </div>
                    </div>
                    
                    <!-- Endereço -->
                    <div class="form-section mb-4">
                        <div class="section-title">
                            Endereço 
                            <i class="fas fa-edit section-icon"></i>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">CEP:</label>
                            <input type="text" class="form-control" name="zip_code" id="editZipCode" placeholder="96015100">
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Endereço:</label>
                            <input type="text" class="form-control" name="address" id="editAddress" placeholder="Major Cícero de Goes Monteiro">
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Número:</label>
                            <input type="text" class="form-control" name="number" id="editNumber" placeholder="1056">
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Cidade/Estado:</label>
                            <input type="text" class="form-control" name="city_state" id="editCityState" placeholder="Pelotas/RS">
                        </div>
                    </div>
                    
                    <!-- Contato -->
                    <div class="form-section mb-4">
                        <div class="section-title">
                            Contato 
                            <i class="fas fa-edit section-icon"></i>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Email:</label>
                            <input type="email" class="form-control" name="email" id="editEmail" placeholder="carlos.r@gmail.com">
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Telefone:</label>
                            <input type="text" class="form-control" name="phone" id="editPhone" placeholder="(53) 984432078">
                        </div>
                    </div>
                    
                    <!-- Botões de ação -->
                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary w-100 mb-2">Salvar Alterações</button>
                        <button type="button" class="btn btn-outline-secondary w-100" data-bs-dismiss="offcanvas">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>

        <script>
            function loadDriverData(driverId, name, email) {
                // Atualizar action do form
                document.getElementById('editDriverForm').action = `/drivers/${driverId}`;
                
                // Carregar dados do motorista via AJAX
                fetch(`/drivers/${driverId}/data`)
                    .then(response => response.json())
                    .then(data => {
                        document.getElementById('editName').value = data.name || '';
                        document.getElementById('editBirthDate').value = data.birth_date ? formatDate(data.birth_date) : '';
                        document.getElementById('editCpf').value = data.cpf || '';
                        document.getElementById('editRg').value = data.rg || '';
                        document.getElementById('editZipCode').value = data.zip_code || '';
                        document.getElementById('editAddress').value = data.address || '';
                        document.getElementById('editNumber').value = data.number || '';
                        document.getElementById('editCityState').value = (data.city && data.state) ? `${data.city}/${data.state}` : '';
                        document.getElementById('editEmail').value = data.email || '';
                        document.getElementById('editPhone').value = data.phone || '';
                        
                        // Atualizar foto
                        document.getElementById('editDriverPhoto').src = `https://i.pravatar.cc/80?u=${driverId}`;
                    })
                    .catch(error => {
                        console.error('Erro ao carregar dados do motorista:', error);
                    });
            }

            function formatDate(dateString) {
                if (!dateString) return '';
                const date = new Date(dateString);
                return date.toLocaleDateString('pt-BR');
            }

            function updatePhoto() {
                // Implementar upload de foto
                alert('Funcionalidade de upload de foto será implementada em breve!');
            }

            function deleteDriver() {
                if (confirm('Tem certeza que deseja deletar este motorista?')) {
                    // Implementar delete
                    console.log('Deletar motorista');
                }
            }
        </script>
@endsection