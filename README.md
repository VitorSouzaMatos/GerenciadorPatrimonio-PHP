# Sistema de Controle de Patrimônio - PHP

Trabalho desenvolvido para a faculdade com o objetivo de criar um sistema web para gerenciamento de patrimônio escolar (salas, laboratórios e equipamentos).

O projeto foi feito inteiramente em **PHP Procedural** (sem uso de frameworks), focando na lógica de programação, segurança com Prepared Statements e organização de banco de dados.

## 🛠️ Tecnologias Utilizadas
* PHP (Puro/Procedural)
* MySQL (Banco de Dados)
* HTML/CSS (Front-end básico)
* XAMPP (Servidor Local)

## 📋 Funcionalidades
O sistema possui dois níveis de acesso:

1.  **Administrador:**
    * Gerencia o cadastro de locais (Salas e Andares).
    * Acessa todas as áreas do sistema.
2.  **Operador:**
    * Registra novos itens de patrimônio.
    * Associa itens às salas e categorias.
3.  **Geral:**
    * Relatório "Mapa Geral" para visualizar onde está cada item.
    * Sistema de login com hash de senhas.

## 🚀 Como rodar o projeto

1.  Tenha o **XAMPP** instalado.
2.  Coloque a pasta do projeto dentro de `C:\xampp\htdocs`.
3.  Abra o **PHPMyAdmin** (http://localhost/phpmyadmin).
4.  Crie um banco de dados com o nome: `db`.
5.  Clique no banco criado, vá na aba **SQL** e cole o conteúdo do arquivo de script do banco (que está no projeto) para criar as tabelas.
6.  Acesse no navegador: `http://localhost/ProjetoPatrimonio` (ou o nome da sua pasta).

## 🔑 Acesso (Logins de Teste)

Para testar o sistema, use os usuários já cadastrados:

* **Admin:**
    * Usuário: `admin`
    * Senha: `admin`

* **Operador:**
    * Usuário: `operador`
    * Senha: `operador`

Desenvolvido por: 
Gabriel Braga
Gabriel Augusto
Fernando Benati
Vitor Matos
