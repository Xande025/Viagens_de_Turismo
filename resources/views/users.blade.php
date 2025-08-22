@extends('layouts.main')

@php
    $active = 'clientes';
    $title = 'Gerenciamento de Usuários';
    // Page-specific CSS will be included via the styles section
@endphp

@section('styles')
    <link href="{{ asset('css/users.css') }}" rel="stylesheet">
    <style>
        /* Estilo para cabeçalhos da tabela */
        .users-table thead th {
            color: #383838 !important;
            font-family: Roboto, sans-serif;
            font-size: 16px;
            font-style: normal;
            font-weight: 400;
            line-height: 148.7%;
        }
        
        /* Estilo para conteúdo das células da tabela */
        .users-table tbody td {
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
    <x-header addLabel="+ Adicionar usuário" addTarget="userOffcanvas" filterLabel="Filtrar" searchPlaceholder="Pesquisar usuário" />
@endsection

@section('content')
    <div class="content flex-grow-1 p-4">
        @if(session('success'))
            <div class="alert alert-success">{!! session('success') !!}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">{!! session('error') !!}</div>
        @endif
        <table class="table users-table mb-0">
            <thead>
                <tr>
                    <th>Usuário</th>
                    <th>E-mail</th>
                    <th style="width: 50px;"></th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td class="text-end">
                        <div class="dropdown">
                            <button class="btn btn-sm btn-link px-2 dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                @include('partials.icons.ellipsis')
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item d-flex align-items-center" href="#" data-bs-toggle="offcanvas" data-bs-target="#userOffcanvas" data-user-id="{{ $user->id }}"><span class="me-2">@include('partials.icons.edit')</span>Editar usuário</a></li>
                                <li>
                                    <form method="POST" action="{{ route('users.destroy', $user) }}" onsubmit="return confirm('Tem certeza que deseja deletar este usuário?');">
                                        @csrf
                                        @method('DELETE')
                                        <button class="dropdown-item d-flex align-items-center text-danger" type="submit"><span class="me-2">@include('partials.icons.delete')</span>Deletar usuário</button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="mt-3">
            {{ $users->links() }}
        </div>
    </div>

        <!-- Offcanvas for user form -->
        <div class="offcanvas offcanvas-end" tabindex="-1" id="userOffcanvas" aria-labelledby="userOffcanvasTitle">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title" id="userOffcanvasTitle">Usuário</h5>
                <div>
                    <button class="btn btn-link p-0 me-2">@include('partials.icons.delete')</button>
                    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Fechar"></button>
                </div>
            </div>
            <div class="offcanvas-body">
                <form method="POST" action="{{ route('users.store') }}">
                    @csrf
                    <x-input label="Nome completo:" placeholder="Maria Antônia da Silva" name="name" />
                    <x-input type="email" label="E-mail:" placeholder="M.Antonia@gmail.com" name="email" />
                    <x-input type="password" label="Senha provisória:" placeholder="********" name="password" />
                    <x-input type="password" label="Confirmar senha:" placeholder="********" name="password_confirmation" />
                    <div class="d-grid gap-2">
                        <x-button type="submit" style="primary" label="Finalizar cadastro" />
                        <x-button type="button" style="secondary" label="Cancelar" data-bs-dismiss="offcanvas" />
                    </div>
                </form>
            </div>
        </div>
@endsection