# 🎉 EventHub - Sistema de Gestão de Eventos

Sistema completo de gestão de eventos desenvolvido em Laravel 11 como projeto da disciplina de Desenvolvimento Web.

## 📋 Sobre o Projeto

O **EventHub** é uma plataforma web que permite:
- 📅 Criação e gestão de eventos
- 👥 Sistema de inscrições para participantes
- 🎫 Controlo de vagas e participantes
- 📁 Organização por categorias
- 🖼️ Upload de imagens para eventos
- 🌐 Zona pública para descobrir eventos

## 🛠️ Tecnologias Utilizadas

- **Laravel 11** - Framework PHP
- **MySQL** - Base de dados
- **Tailwind CSS** - Framework CSS
- **Laravel Breeze** - Autenticação
- **Blade** - Template engine

## 👥 Perfis de Utilizadores

- **Administrador** - Gestão completa do sistema
- **Organizador** - Cria e gere eventos próprios
- **Participante** - Inscreve-se em eventos

## 🚀 Instalação

### Requisitos
- PHP 8.1 ou superior
- Composer
- MySQL
- Node.js e NPM

### Passos

1. **Clonar o repositório**
```bash
git clone https://github.com/FranciscoMonteiro23/event-manager.git
cd event-manager
```

2. **Instalar dependências**
```bash
composer install
npm install
```

3. **Configurar ambiente**
```bash
cp .env.example .env
php artisan key:generate
```

4. **Configurar base de dados**

Edita o ficheiro `.env` com as tuas credenciais MySQL:
```
DB_DATABASE=eventhub
DB_USERNAME=root
DB_PASSWORD=
```

5. **Criar base de dados**
```bash
mysql -u root -p
CREATE DATABASE eventhub;
exit;
```

6. **Executar migrations e seeders**
```bash
php artisan migrate --seed
```

7. **Criar link simbólico para storage**
```bash
php artisan storage:link
```

8. **Compilar assets**
```bash
npm run dev
```

9. **Iniciar servidor**
```bash
php artisan serve
```

10. **Aceder à aplicação**

Abre o browser em: `http://127.0.0.1:8000`

## 👤 Utilizadores de Teste

Após executar os seeders, podes usar estes utilizadores:

**Administrador:**
- Email: `admin@eventhub.com`
- Password: `password`

**Organizador:**
- Email: `organizer@eventhub.com`
- Password: `password`

**Participante:**
- Email: `participant@eventhub.com`
- Password: `password`

## 📁 Estrutura do Projeto

```
event-manager/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── CategoryController.php
│   │   │   ├── EventController.php
│   │   │   ├── RegistrationController.php
│   │   │   └── PublicController.php
│   │   └── Middleware/
│   │       ├── IsAdmin.php
│   │       └── IsOrganizer.php
│   └── Models/
│       ├── User.php
│       ├── Category.php
│       ├── Event.php
│       └── Registration.php
├── database/
│   ├── migrations/
│   └── seeders/
│       ├── UserSeeder.php
│       ├── CategorySeeder.php
│       ├── EventSeeder.php
│       └── RegistrationSeeder.php
├── resources/
│   └── views/
│       ├── categories/
│       ├── events/
│       ├── registrations/
│       ├── public/
│       └── dashboard.blade.php
├── routes/
│   └── web.php
└── public/
```

## ✨ Funcionalidades Principais

- ✅ Sistema de autenticação completo (Laravel Breeze)
- ✅ CRUD de Categorias (Admin)
- ✅ CRUD de Eventos (Organizer/Admin)
- ✅ Sistema de inscrições com gestão de vagas
- ✅ Upload de imagens para eventos
- ✅ Dashboard personalizado por perfil
- ✅ Zona pública sem necessidade de login
- ✅ Filtros e pesquisa de eventos
- ✅ Validação server-side em todos os formulários
- ✅ Middleware de autorização personalizado
- ✅ Relações complexas 1:N e N:N

## 🔐 Segurança

- Autenticação via Laravel Breeze
- Passwords encriptadas com bcrypt
- Proteção CSRF em todos os formulários
- Middleware de autorização por perfil
- Validação de dados no servidor
- Proteção contra SQL Injection via Eloquent ORM

## 📊 Base de Dados

### Entidades Principais

- **Users** - Utilizadores do sistema
- **Categories** - Categorias de eventos
- **Events** - Eventos criados por organizadores
- **Registrations** - Inscrições de participantes em eventos

### Relações

- User → Events (1:N) - Um utilizador cria múltiplos eventos
- Category → Events (1:N) - Uma categoria contém múltiplos eventos
- User ↔ Events (N:N) - Utilizadores inscrevem-se em múltiplos eventos através da tabela registrations

## 🎨 Interface

- Design moderno com Tailwind CSS
- Dashboard com gradientes vibrantes
- Cards animados com efeitos hover
- Layout responsivo
- Zona pública com filtros de pesquisa
- Feedback visual em todas as interações

## 🤖 Utilização de Inteligência Artificial

Durante o desenvolvimento, utilizámos IA (Claude, da Anthropic) como ferramenta de apoio para esclarecimento de dúvidas técnicas e resolução de problemas específicos, nomeadamente:

- Compreensão de relações complexas no Eloquent (N:N com tabela pivot enriquecida)
- Implementação do sistema de middleware personalizado para controlo de acessos
- Configuração de upload de ficheiros e sistema de storage com link simbólico
- Optimização de queries do Eloquent para evitar problemas de N+1
- Resolução de erros e debugging de mensagens complexas
- Geração de dados de teste realistas para seeders
- Sugestões para melhorias de CSS e estruturação de gradientes no dashboard

A IA foi utilizada como ferramenta de consulta e apoio, semelhante a consultar documentação oficial ou fóruns como Stack Overflow. Toda a lógica de negócio, arquitetura do sistema e decisões de design foram tomadas pela equipa. Todo o código foi revisto, testado e compreendido antes de ser integrado no projeto.

## 🧪 Como Testar

### Testar como Administrador
1. Login com `admin@eventhub.com`
2. Aceder a "Categorias" → Criar/Editar/Apagar categorias
3. Aceder a "Eventos" → Ver todos os eventos do sistema
4. Aceder a "Gestão de Inscrições" → Ver todas as inscrições

### Testar como Organizador
1. Login com `organizer@eventhub.com`
2. Criar novo evento com imagem
3. Ver inscrições nos próprios eventos
4. Editar/Apagar eventos próprios

### Testar como Participante
1. Login com `participant@eventhub.com`
2. Navegar por eventos disponíveis
3. Inscrever-se em eventos
4. Ver "As Minhas Inscrições"
5. Cancelar inscrições

### Testar Zona Pública
1. Fazer logout ou abrir em janela anónima
2. Aceder à homepage (/)
3. Usar filtros de pesquisa
4. Ver detalhes de eventos
5. Tentar inscrever-se (redireciona para login)

## 📝 Funcionalidades Extra Implementadas

Além dos requisitos obrigatórios, implementámos:
- Dashboard com estatísticas dinâmicas por perfil
- Zona pública com sistema de filtros e pesquisa
- Preview de imagens no formulário de edição
- Contagem de vagas disponíveis em tempo real
- Sistema de badges coloridos para status
- Animações e transições suaves
- Feedback visual extensivo


## 📄 Estrutura de Ficheiros Importante

```
.env.example           # Template de configuração
routes/web.php         # Definição de todas as rotas
database/migrations/   # Estrutura da base de dados
database/seeders/      # Dados de teste
storage/app/public/    # Ficheiros uploaded (imagens)
public/storage/        # Link simbólico para storage
```

## 🐛 Resolução de Problemas

### Erro "View [dashboard] not found"
```bash
php artisan view:clear
```

### Imagens não aparecem
```bash
php artisan storage:link
```

### Erro de permissões
```bash
chmod -R 775 storage bootstrap/cache
```

### Base de dados não conecta
Verifica as credenciais no ficheiro `.env`

## 📚 Documentação Adicional

Para mais informação sobre o projeto, consultar:
- Relatório técnico (incluído no projeto)
- Diagramas ER da base de dados
- Slides de apresentação

---

**Desenvolvido em Janeiro 2026 - Projeto Académico**

Laravel 11 | MySQL | Tailwind CSS | PHP 8.4