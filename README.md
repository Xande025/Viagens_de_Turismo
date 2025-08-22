# 🚐 COINPEL - Sistema de Gestão de Viagens e Turismo

<div align="center">
  <img src="public/images/logo.png" alt="COINPEL Logo" width="200">
  
  <p><em>Sistema completo para gerenciamento de viagens, motoristas, veículos e clientes</em></p>

  ![Laravel](https://img.shields.io/badge/Laravel-12.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
  ![PHP](https://img.shields.io/badge/PHP-8.2+-777BB4?style=for-the-badge&logo=php&logoColor=white)
  ![Bootstrap](https://img.shields.io/badge/Bootstrap-5.3-7952B3?style=for-the-badge&logo=bootstrap&logoColor=white)
  ![PostgreSQL](https://img.shields.io/badge/PostgreSQL-316192?style=for-the-badge&logo=postgresql&logoColor=white)
</div>

---

## 📋 Índice

- [🎯 Sobre o Projeto](#-sobre-o-projeto)
- [✨ Funcionalidades](#-funcionalidades)
- [🛠️ Tecnologias](#️-tecnologias)
- [📋 Pré-requisitos](#-pré-requisitos)
- [🚀 Instalação](#-instalação)
- [⚙️ Configuração](#️-configuração)
- [💾 Banco de Dados](#-banco-de-dados)
- [🎨 Interface](#-interface)
-- [🔐 Autenticação](#-autenticação)
- [📂 Estrutura do Projeto](#-estrutura-do-projeto)
- [🧪 Testes](#-testes)
- [📖 Documentação da API](#-documentação-da-api)
- [🤝 Contribuição](#-contribuição)
- [📄 Licença](#-licença)

---

## 🎯 Sobre o Projeto

O **Gestão de Viagens e Turismo** é um sistema web moderno e intuitivo desenvolvido em Laravel para o gerenciamento completo de empresas de turismo e transporte. O sistema oferece controle total sobre viagens, motoristas, veículos, clientes e usuários, com interface responsiva e funcionalidades avançadas.

### 🎪 Principais Características

- **Interface Moderna**: Design clean com Bootstrap 5.3 e componentes personalizados
- **Gestão Completa**: Controle de motoristas, veículos, viagens e clientes
- **Sistema de Usuários**: Autenticação robusta com diferentes níveis de acesso
- **Responsivo**: Totalmente adaptável para desktop, tablet e mobile
- **Banco Flexível**: Schema otimizado com campos opcionais para máxima flexibilidade

---

## ✨ Funcionalidades

### 👥 Gestão de Usuários
- ✅ Sistema de login/logout seguro
- ✅ Primeiro acesso com alteração de senha obrigatória
- ✅ Perfis de usuário com avatar
- ✅ Controle de sessões

### 🚗 Gestão de Motoristas
- ✅ Cadastro completo de motoristas
- ✅ Formulários dual (criação simples + edição detalhada)
- ✅ Upload de foto de perfil
- ✅ Campos flexíveis (todos opcionais)
- ✅ Status de atividade
- ✅ Histórico de viagens

### 🚐 Gestão de Veículos
- ✅ Cadastro de veículos
- ✅ Controle de manutenção
- ✅ Status operacional
- ✅ Associação com motoristas

### 🗺️ Gestão de Viagens
- ✅ Planejamento de rotas
- ✅ Associação motorista-veículo
- ✅ Controle de status da viagem
- ✅ Relatórios detalhados

### 👤 Gestão de Clientes
- ✅ Base de dados de clientes
- ✅ Histórico de viagens
- ✅ Informações de contato

---

## 🛠️ Tecnologias

### Backend
- **Laravel 12.x** - Framework PHP moderno
- **PHP 8.2+** - Linguagem de programação
- **PostgreSQL** - Banco de dados relacional
- **Eloquent ORM** - Mapeamento objeto-relacional

### Frontend
- **Bootstrap 5.3.1** - Framework CSS
- **Sass** - Pré-processador CSS
- **JavaScript Vanilla** - Interatividade
- **Font Awesome** - Ícones
- **Blade Templates** - Engine de templates

### Ferramentas de Desenvolvimento
- **Vite** - Build tool e bundler
- **Laravel Pint** - Code styling
- **Composer** - Gerenciador de dependências PHP
- **NPM** - Gerenciador de dependências JavaScript

---

## 📋 Pré-requisitos

Antes de começar, certifique-se de ter as seguintes ferramentas instaladas:

- **PHP 8.2+**
- **Composer**
- **Node.js 18+**
- **PostgreSQL 13+**
- **Git**

### Verificação dos Requisitos

```bash
# Verificar PHP
php -v

# Verificar Composer
composer --version

# Verificar Node.js
node --version

# Verificar PostgreSQL
psql --version
```

---

## 🚀 Instalação

### 1. Clone o Repositório

```bash
git clone https://github.com/Xande025/Viagens_de_Turismo-.git
cd Viagens_de_Turismo-
```

### 2. Instale as Dependências PHP

```bash
composer install
```

### 3. Instale as Dependências JavaScript

```bash
npm install
```

### 4. Configure o Ambiente

```bash
# Copie o arquivo de configuração
cp .env.example .env

# Gere a chave da aplicação
php artisan key:generate
```

---

## ⚙️ Configuração

### 1. Configuração do Banco de Dados

Edite o arquivo `.env` com suas configurações de banco:

```env
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=viagens_turismo
DB_USERNAME=seu_usuario
DB_PASSWORD=sua_senha
```

### 2. Configurações Adicionais

```env
APP_NAME="COINPEL"
APP_ENV=local
APP_KEY=base64:sua_chave_aqui
APP_DEBUG=true
APP_TIMEZONE=America/Sao_Paulo
APP_URL=http://localhost:8000

SESSION_DRIVER=file
SESSION_LIFETIME=120

CACHE_STORE=file
FILESYSTEM_DISK=local
LOG_CHANNEL=stack
LOG_STACK=single
```

---

## 💾 Banco de Dados

### 1. Criar o Banco

```sql
-- No PostgreSQL
CREATE DATABASE viagens_turismo;
```

### 2. Executar Migrações

```bash
# Executar todas as migrações
php artisan migrate

# Executar migrações com seeders
php artisan migrate --seed
```

### 3. Estrutura do Banco

#### Tabela Users
- `id` - Chave primária
- `name` - Nome do usuário
- `email` - Email único
- `password` - Senha criptografada
- `first_access` - Flag de primeiro acesso
- `created_at/updated_at` - Timestamps

#### Tabela Drivers
- `id` - Chave primária
- `name` - Nome (opcional)
- `birth_date` - Data de nascimento (opcional)
- `cpf` - CPF (opcional, único)
- `rg` - RG (opcional)
- `email` - Email (opcional, único)
- `phone` - Telefone (opcional)
- `address` - Endereço completo (opcional)
- `status` - Status ativo/inativo
- `created_at/updated_at` - Timestamps

#### Tabela Vehicles
- `id` - Chave primária
- `model` - Modelo do veículo
- `plate` - Placa única
- `capacity` - Capacidade de passageiros
- `status` - Status operacional
- `created_at/updated_at` - Timestamps

#### Tabela Trips
- `id` - Chave primária
- `driver_id` - FK para motorista
- `vehicle_id` - FK para veículo
- `destination` - Destino
- `departure_date` - Data de partida
- `return_date` - Data de retorno
- `status` - Status da viagem
- `created_at/updated_at` - Timestamps

---

## 🎨 Interface

### Design System

O projeto utiliza um design system consistente baseado em:

- **Cores Primárias**: `#593E75` (roxo COINPEL)
- **Tipografia**: Arial, sans-serif
- **Componentes**: Bootstrap 5.3 customizado
- **Ícones**: Font Awesome + SVGs customizados

### Páginas Principais

1. **Splash Screen** (`/tumb`) - Tela de boas-vindas
2. **Login** (`/login`) - Autenticação de usuários
3. **Dashboard** - Visão geral do sistema
4. **Motoristas** (`/drivers`) - Gestão de motoristas
5. **Veículos** (`/vehicles`) - Gestão de veículos
6. **Viagens** (`/trips`) - Gestão de viagens
7. **Usuários** (`/users`) - Gestão de usuários

### Componentes Personalizados

- **Sidebar Navigation** - Menu lateral responsivo
- **Header Component** - Cabeçalho com perfil do usuário
- **Card Components** - Cards para listagens
- **Form Components** - Formulários padronizados
- **Modal/Offcanvas** - Modais e painéis laterais

---


## 🔐 Autenticação

### Sistema de Login

O sistema implementa autenticação robusta com:

- **Hash de Senhas**: Bcrypt para segurança
- **Sessões**: Gerenciamento seguro de sessões
- **CSRF Protection**: Proteção contra ataques CSRF
- **Primeiro Acesso**: Obriga alteração de senha no primeiro login

### Middleware de Proteção

```php
// Rotas protegidas
Route::middleware(['auth'])->group(function () {
    Route::resource('drivers', DriverController::class);
    Route::resource('vehicles', VehicleController::class);
    Route::resource('trips', TripController::class);
    Route::resource('users', UserController::class);
});
```

---

## 📂 Estrutura do Projeto

```
viagens-turismo/
├── 📁 app/
│   ├── 📁 Http/
│   │   ├── 📁 Controllers/
│   │   │   ├── Auth/LoginController.php
│   │   │   ├── DriverController.php
│   │   │   ├── VehicleController.php
│   │   │   ├── TripController.php
│   │   │   └── UserController.php
│   │   └── 📁 Middleware/
│   └── 📁 Models/
│       ├── User.php
│       ├── Driver.php
│       ├── Vehicle.php
│       └── Trip.php
├── 📁 database/
│   ├── 📁 migrations/
│   └── 📁 seeders/
├── 📁 public/
│   ├── 📁 css/
│   │   ├── drivers.css
│   │   ├── vehicles.css
│   │   ├── trips.css
│   │   └── style.css
│   └── 📁 images/
│       ├── logo.png
│       ├── logo-white.png
│       └── Tumb.png
├── 📁 resources/
│   ├── 📁 views/
│   │   ├── 📁 components/
│   │   │   ├── header.blade.php
│   │   │   ├── sidebar.blade.php
│   │   │   └── layout.blade.php
│   │   ├── 📁 partials/
│   │   │   └── 📁 icons/
│   │   ├── drivers.blade.php
│   │   ├── vehicles.blade.php
│   │   ├── trips.blade.php
│   │   ├── users.blade.php
│   │   ├── login.blade.php
│   │   └── tumb.blade.php
│   ├── 📁 js/
│   └── 📁 sass/
├── 📁 routes/
│   ├── web.php
│   └── api.php
├── .env.example
├── composer.json
├── package.json
├── vite.config.js
└── README.md
```

---

## 🧪 Testes

### Executar Testes

```bash
# Executar todos os testes
php artisan test

# Executar testes específicos
php artisan test --filter=DriverTest

# Executar com coverage
php artisan test --coverage
```

### Tipos de Teste

- **Feature Tests**: Testes de funcionalidades completas
- **Unit Tests**: Testes unitários de componentes
- **Browser Tests**: Testes de interface (Laravel Dusk)

---

## 📖 Documentação da API

### Endpoints Principais

#### Motoristas
```http
GET    /drivers           # Listar motoristas
POST   /drivers           # Criar motorista
GET    /drivers/{id}      # Ver motorista
PUT    /drivers/{id}      # Atualizar motorista
DELETE /drivers/{id}      # Deletar motorista
GET    /drivers/{id}/data # Dados para edição
```

#### Veículos
```http
GET    /vehicles          # Listar veículos
POST   /vehicles          # Criar veículo
GET    /vehicles/{id}     # Ver veículo
PUT    /vehicles/{id}     # Atualizar veículo
DELETE /vehicles/{id}     # Deletar veículo
```

#### Viagens
```http
GET    /trips             # Listar viagens
POST   /trips             # Criar viagem
GET    /trips/{id}        # Ver viagem
PUT    /trips/{id}        # Atualizar viagem
DELETE /trips/{id}        # Deletar viagem
```

---

## 🚀 Deploy

### Ambiente de Produção

```bash
# 1. Otimizar autoload
composer install --optimize-autoloader --no-dev

# 2. Compilar assets
npm run build

# 3. Otimizar configurações
php artisan config:cache
php artisan route:cache
php artisan view:cache

# 4. Definir permissões
sudo chown -R www-data:www-data storage bootstrap/cache
sudo chmod -R 775 storage bootstrap/cache
```

### Configurações de Produção

```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://seudominio.com

# Cache
CACHE_STORE=redis
SESSION_DRIVER=redis

# Banco de dados
DB_CONNECTION=pgsql
DB_HOST=seu-servidor-db
DB_DATABASE=viagens_turismo_prod
```




