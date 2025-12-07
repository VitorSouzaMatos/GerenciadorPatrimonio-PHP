# 🏢 Sistema de Gerenciamento de Patrimônio

![PHP](https://img.shields.io/badge/PHP-8.0+-777BB4?style=flat&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-8.0+-4479A1?style=flat&logo=mysql&logoColor=white)
![Bootstrap](https://img.shields.io/badge/Bootstrap-5.3-7952B3?style=flat&logo=bootstrap&logoColor=white)
![License](https://img.shields.io/badge/License-MIT-green.svg)

Sistema completo para gerenciamento de patrimônio institucional desenvolvido em PHP procedural com MySQL, incluindo controle de objetos, localização, ocorrências e relatórios gerenciais.

## 📋 Índice

- [Características](#-características)
- [Funcionalidades](#-funcionalidades)
- [Requisitos](#-requisitos)
- [Instalação](#-instalação)
- [Estrutura do Projeto](#-estrutura-do-projeto)
- [Uso do Sistema](#-uso-do-sistema)
- [Segurança](#-segurança)
- [Tecnologias](#-tecnologias)
- [Capturas de Tela](#-capturas-de-tela)
- [Contribuindo](#-contribuindo)
- [Licença](#-licença)

## ✨ Características

- 🔐 **Sistema de Autenticação** com controle de permissões (Admin e Operador)
- 📦 **CRUD Completo** para todas as entidades (Categorias, Andares, Salas, Objetos, Ocorrências)
- 🏷️ **Controle de Patrimônio** com placas de identificação e valores
- 📍 **Localização Hierárquica** (Andares → Salas → Objetos)
- 🔧 **Gestão de Ocorrências** (Manutenção, Danos, Perdas, Encontrados)
- 📊 **Relatórios Gerenciais** com filtros avançados
- 🎨 **Interface Responsiva** com Bootstrap 5
- 🛡️ **Segurança Robusta** contra SQL Injection e XSS

## 🚀 Funcionalidades

### 🔑 Autenticação e Controle de Acesso

- Login/Logout com sessões seguras
- Dois níveis de usuário:
  - **Admin**: Acesso total ao sistema
  - **Operador**: Visualização e criação de ocorrências

### 📂 Módulos Principais

#### 1. Categorias
- Cadastro de categorias de objetos (Móveis, Eletrônicos, Equipamentos, etc.)
- Vinculação de múltiplos objetos por categoria

#### 2. Estrutura Física
- **Andares**: Organização vertical do prédio com ordem definida
- **Salas**: Cadastro de ambientes vinculados aos andares

#### 3. Objetos do Patrimônio
- Cadastro completo com:
  - Nome e descrição
  - Categoria
  - Localização (Andar/Sala)
  - Placa de identificação única
  - Data de aquisição
  - Valor monetário
  - Status (Ativo, Inativo, Em Manutenção, Descartado)
- Busca e filtros avançados
- Visualização detalhada

#### 4. Ocorrências
- Registro de eventos:
  - 🔧 Manutenção
  - ⚠️ Dano
  - 🔍 Perda
  - ✅ Encontrado
- Status de acompanhamento (Aberta, Em Andamento, Resolvida)
- Histórico completo por objeto
- Atribuição ao usuário responsável

#### 5. Relatórios

##### Objetos por Categoria
- Quantidade total e ativos por categoria
- Valor total do patrimônio por categoria
- Totalização geral

##### Objetos por Localização
- Distribuição por andar e sala
- Mapeamento completo do patrimônio

##### Histórico de Ocorrências
- Filtros por data, tipo e status
- Acompanhamento de manutenções e problemas

##### Valor Total do Patrimônio
- Consolidação financeira
- Valores por status e categoria

### 📊 Dashboard

- Visão geral com métricas principais:
  - Total de objetos cadastrados
  - Quantidade de categorias e salas
  - Ocorrências pendentes
  - Valor total do patrimônio ativo
- Distribuição de objetos por status
- Últimas ocorrências registradas

## 🔧 Requisitos

### Servidor Web

- PHP 8.0 ou superior
- Extensões PHP necessárias:
  - `pdo_mysql`
  - `mbstring`
  - `json`
- Apache 2.4+ ou Nginx 1.18+

### Banco de Dados

- MySQL 8.0+ ou MariaDB 10.5+

### Cliente

- Navegador moderno (Chrome, Firefox, Safari, Edge)
- JavaScript habilitado

## 📦 Instalação

### Passo 1: Clone o Repositório

```bash
git clone https://github.com/seu-usuario/sistema-patrimonio.git
cd sistema-patrimonio
```

### Passo 2: Configure o Banco de Dados

```bash
# Entre no MySQL
mysql -u root -p

# Execute o script de criação
mysql -u root -p < database.sql
```

Ou importe manualmente via phpMyAdmin:
1. Acesse phpMyAdmin
2. Crie o banco `db_patrimonio`
3. Importe o arquivo `database.sql`

### Passo 3: Configure a Conexão

Edite o arquivo `config/conexao.php`:

```php
define('DB_HOST', 'localhost');
define('DB_NAME', 'db_patrimonio');
define('DB_USER', 'seu_usuario');
define('DB_PASS', 'sua_senha');
```

### Passo 4: Configure o Servidor Web

#### Apache (.htaccess)

Crie um arquivo `.htaccess` na raiz:

```apache
RewriteEngine On
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^(.*)$ index.php?url=$1 [QSA,L]

# Bloquear acesso a arquivos sensíveis
<FilesMatch "^\.">
    Require all denied
</FilesMatch>

# Prevenir listagem de diretórios
Options -Indexes
```

#### Nginx

Adicione ao seu `server block`:

```nginx
location / {
    try_files $uri $uri/ /index.php?$query_string;
}

location ~ /\. {
    deny all;
}
```

### Passo 5: Defina Permissões

```bash
# Linux/Mac
chmod 755 -R .
chmod 644 config/conexao.php

# Garanta que o servidor web possa ler os arquivos
chown -R www-data:www-data .
```

### Passo 6: Acesse o Sistema

Abra no navegador:

```
http://localhost/sistema-patrimonio/auth/login.php
```

## 👥 Usuários Padrão

O sistema vem com dois usuários pré-cadastrados para testes:

| Tipo | Email | Senha | Permissões |
|------|-------|-------|------------|
| **Admin** | admin@sistema.com | admin123 | Acesso total |
| **Operador** | operador@sistema.com | admin123 | Leitura + Ocorrências |

⚠️ **IMPORTANTE**: Altere essas senhas imediatamente em produção!

## 📁 Estrutura do Projeto

```
sistema-patrimonio/
│
├── 📄 index.php                 # Dashboard principal
├── 📄 database.sql              # Script de criação do banco
├── 📄 README.md                 # Este arquivo
│
├── 📁 config/
│   └── 📄 conexao.php          # Configuração PDO
│
├── 📁 includes/
│   ├── 📄 funcoes.php          # Funções auxiliares
│   ├── 📄 header.php           # Cabeçalho com menu
│   └── 📄 footer.php           # Rodapé
│
├── 📁 auth/
│   ├── 📄 login.php            # Página de login
│   └── 📄 logout.php           # Processo de logout
│
├── 📁 categorias/
│   ├── 📄 lista.php            # Listagem de categorias
│   ├── 📄 form.php             # Formulário add/edit
│   ├── 📄 salvar.php           # Processar salvamento
│   └── 📄 excluir.php          # Excluir categoria
│
├── 📁 andares/
│   ├── 📄 lista.php
│   ├── 📄 form.php
│   ├── 📄 salvar.php
│   └── 📄 excluir.php
│
├── 📁 salas/
│   ├── 📄 lista.php
│   ├── 📄 form.php
│   ├── 📄 salvar.php
│   └── 📄 excluir.php
│
├── 📁 objetos/
│   ├── 📄 lista.php            # Listagem com filtros
│   ├── 📄 form.php             # Formulário completo
│   ├── 📄 salvar.php           # Processar dados
│   ├── 📄 excluir.php          # Excluir objeto
│   └── 📄 visualizar.php       # Detalhes do objeto
│
├── 📁 ocorrencias/
│   ├── 📄 lista.php
│   ├── 📄 form.php
│   ├── 📄 salvar.php
│   ├── 📄 excluir.php
│   └── 📄 resolver.php         # Marcar como resolvida
│
└── 📁 relatorios/
    ├── 📄 objetos_categoria.php    # Relatório por categoria
    ├── 📄 objetos_localizacao.php  # Relatório por local
    ├── 📄 historico_ocorrencias.php # Histórico completo
    └── 📄 valor_total.php          # Relatório financeiro
```

## 💻 Uso do Sistema

### Primeiro Acesso

1. **Login como Admin**
   ```
   Email: admin@sistema.com
   Senha: admin123
   ```

2. **Configure as Categorias**
   - Acesse Menu → Categorias
   - Cadastre categorias como: Móveis, Eletrônicos, Equipamentos, etc.

3. **Configure a Estrutura Física**
   - Cadastre os andares (Térreo, 1º Andar, 2º Andar, etc.)
   - Cadastre as salas vinculando aos andares

4. **Cadastre os Objetos**
   - Acesse Menu → Objetos → Novo Objeto
   - Preencha todos os dados obrigatórios
   - Defina uma placa única de identificação

5. **Registre Ocorrências (quando necessário)**
   - Selecione o objeto
   - Registre manutenções, danos ou perdas
   - Acompanhe o status até a resolução

### Fluxo de Trabalho Recomendado

```
1. Cadastrar Categorias
2. Cadastrar Andares
3. Cadastrar Salas
4. Cadastrar Objetos
5. Monitorar e Registrar Ocorrências
6. Gerar Relatórios Periódicos
```

### Filtros e Buscas

- **Objetos**: Busca por nome, placa, categoria, status e sala
- **Ocorrências**: Filtro por tipo, status e período
- **Relatórios**: Múltiplos critérios de agrupamento

## 🛡️ Segurança

### Medidas Implementadas

#### 1. Autenticação e Autorização
- Senhas criptografadas com `password_hash()` (BCRYPT)
- Verificação de sessão em todas as páginas protegidas
- Controle granular de permissões por role

#### 2. Proteção contra SQL Injection
- **100% das queries** utilizam Prepared Statements (PDO)
- Binding de parâmetros em todas as operações
- Nunca concatenação direta de SQL

```php
// ✅ CORRETO - Prepared Statement
$stmt = $pdo->prepare("SELECT * FROM tb_objetos WHERE id_objeto = ?");
$stmt->execute([$id]);

// ❌ ERRADO - Vulnerável
$query = "SELECT * FROM tb_objetos WHERE id_objeto = $id";
```

#### 3. Proteção contra XSS
- Sanitização de todas as entradas com `htmlspecialchars()`
- Função `limpar()` aplicada em todos os inputs
- Escape de outputs em todas as views

```php
// Função de sanitização
function limpar($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
    return $data;
}
```

#### 4. Controle de Sessão
- Timeout automático de sessão
- Regeneração de ID de sessão após login
- Verificação de role em operações sensíveis

#### 5. Validação de Dados
- Validação no frontend (HTML5 + JavaScript)
- Validação no backend (PHP)
- Verificação de tipos e formatos

### Boas Práticas Aplicadas

- ✅ Princípio do menor privilégio
- ✅ Validação de entrada/saída
- ✅ Tratamento adequado de erros
- ✅ Logs de ações críticas (pode ser expandido)
- ✅ Proteção de arquivos sensíveis

### Recomendações para Produção

1. **Altere as credenciais padrão**
   ```sql
   UPDATE tb_usuarios SET senha = ? WHERE email = 'admin@sistema.com';
   ```

2. **Use HTTPS**
   - Configure SSL/TLS no servidor
   - Force redirecionamento HTTP → HTTPS

3. **Restrinja o acesso ao banco**
   - Usuário específico com permissões mínimas
   - Conexão apenas de localhost ou IPs específicos

4. **Implemente Rate Limiting**
   - Limite tentativas de login
   - Previna ataques de força bruta

5. **Configure Backups Automáticos**
   ```bash
   # Exemplo de backup diário
   mysqldump -u user -p db_patrimonio > backup_$(date +%Y%m%d).sql
   ```

6. **Monitore Logs**
   - Logs de acesso
   - Logs de erro
   - Logs de auditoria

## 🔧 Tecnologias

### Backend
- **PHP 8.0+**: Linguagem principal (procedural)
- **PDO (PHP Data Objects)**: Camada de abstração de banco de dados
- **MySQL 8.0**: Sistema gerenciador de banco de dados

### Frontend
- **HTML5**: Estruturação semântica
- **CSS3**: Estilização customizada
- **Bootstrap 5.3**: Framework CSS responsivo
- **Bootstrap Icons**: Ícones vetoriais
- **JavaScript (Vanilla)**: Interatividade client-side

### Arquitetura
- **MVC Simplificado**: Separação de lógica e apresentação
- **RESTful**: URLs amigáveis e semânticas
- **Mobile-First**: Design responsivo prioritário

## 📊 Modelo de Dados

### Diagrama Entidade-Relacionamento

```
┌─────────────┐       ┌──────────────┐       ┌─────────────┐
│  Usuários   │       │  Categorias  │       │   Andares   │
├─────────────┤       ├──────────────┤       ├─────────────┤
│ id_usuario  │       │ id_categoria │       │ id_andar    │
│ nome        │       │ nome         │       │ nome        │
│ email       │       │ descricao    │       │ ordem       │
│ senha       │       └──────┬───────┘       └──────┬──────┘
│ role        │              │                      │
└──────┬──────┘              │                      │
       │                     │                      │
       │         ┌───────────┴─────────┐            │
       │         │                     │            │
       │   ┌─────▼──────┐        ┌────▼─────┐      │
       │   │  Objetos   │◄───────┤  Salas   │◄─────┘
       │   ├────────────┤        ├──────────┤
       │   │ id_objeto  │        │ id_sala  │
       │   │ nome       │        │ nome     │
       │   │ placa      │        │ id_andar │
       │   │ valor      │        └──────────┘
       │   │ status     │
       │   └─────┬──────┘
       │         │
       └────────►│
                 │
          ┌──────▼────────┐
          │  Ocorrências  │
          ├───────────────┤
          │ id_ocorrencia │
          │ id_objeto     │
          │ id_usuario    │
          │ tipo          │
          │ descricao     │
          │ status        │
          └───────────────┘
```

## 📸 Capturas de Tela

### Tela de Login
Interface moderna e segura com validação de credenciais.

### Dashboard
Visão geral com métricas principais e últimas ocorrências.

### Listagem de Objetos
Tabela interativa com filtros avançados e paginação.

### Formulário de Cadastro
Formulário completo com validação e campos hierárquicos.

### Relatórios
Relatórios gerenciais com totalizações e filtros customizáveis.

## 🤝 Contribuindo

Contribuições são bem-vindas! Para contribuir:

1. **Fork o projeto**
   ```bash
   git clone https://github.com/seu-usuario/sistema-patrimonio.git
   ```

2. **Crie uma branch para sua feature**
   ```bash
   git checkout -b feature/minha-feature
   ```

3. **Commit suas mudanças**
   ```bash
   git commit -m 'Adiciona nova funcionalidade X'
   ```

4. **Push para a branch**
   ```bash
   git push origin feature/minha-feature
   ```

5. **Abra um Pull Request**

### Diretrizes

- Siga o padrão de código existente
- Documente novas funcionalidades
- Teste adequadamente antes de submeter
- Mantenha commits atômicos e descritivos

## 📝 Roadmap

### Versão 2.0 (Planejado)

- [ ] Sistema de notificações em tempo real
- [ ] Upload de fotos dos objetos
- [ ] Exportação de relatórios em PDF
- [ ] Gráficos interativos (Chart.js)
- [ ] Histórico de movimentações (transferências entre salas)
- [ ] API RESTful para integração
- [ ] Aplicativo mobile (React Native)
- [ ] Sistema de QR Code para identificação rápida
- [ ] Agendamento de manutenções preventivas
- [ ] Multi-tenancy (múltiplas instituições)

### Melhorias Futuras

- [ ] Implementar testes automatizados (PHPUnit)
- [ ] Migrar para PSR-4 e Composer
- [ ] Adicionar Docker para desenvolvimento
- [ ] Implementar CI/CD
- [ ] Logs de auditoria completos
- [ ] Sistema de backup automático
- [ ] Recuperação de senha por email
- [ ] Autenticação de dois fatores (2FA)

## 🐛 Problemas Conhecidos

Nenhum problema crítico conhecido no momento.

Para reportar bugs, abra uma issue em: [Issues](https://github.com/seu-usuario/sistema-patrimonio/issues)

## 📞 Suporte

- 📧 Email: suporte@seudominio.com
- 💬 Issues: [GitHub Issues](https://github.com/seu-usuario/sistema-patrimonio/issues)
- 📖 Wiki: [Documentação Completa](https://github.com/seu-usuario/sistema-patrimonio/wiki)

## 📄 Licença

Este projeto está licenciado sob a Licença MIT - veja o arquivo [LICENSE](LICENSE) para detalhes.

```
MIT License

Copyright (c) 2024 Seu Nome

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software...
```

## 👏 Agradecimentos

- [Bootstrap](https://getbootstrap.com/) pela framework CSS
- [Bootstrap Icons](https://icons.getbootstrap.com/) pelos ícones
- Comunidade PHP pela documentação e suporte
- Todos os contribuidores do projeto

---

<div align="center">

**[⬆ Voltar ao Topo](#-sistema-de-gerenciamento-de-patrimônio)**

Desenvolvido com ❤️ por [Seu Nome](https://github.com/seu-usuario)

[![GitHub](https://img.shields.io/badge/GitHub-100000?style=for-the-badge&logo=github&logoColor=white)](https://github.com/seu-usuario)
[![LinkedIn](https://img.shields.io/badge/LinkedIn-0077B5?style=for-the-badge&logo=linkedin&logoColor=white)](https://linkedin.com/in/seu-usuario)

</div>
