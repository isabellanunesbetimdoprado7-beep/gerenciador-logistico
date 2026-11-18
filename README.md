# Gerenciador Logístico

Aplicação web desenvolvida em PHP para a disciplina de Fundamentos de Programação para Internet (UNIPAR EAD).

**Aluna:** Isabella Nunes Betim do Prado
**RA:** 09066502
**Curso:** Analise e Desenvolvimento de Sistemas
**Polo:** cascavel

## Descrição

O sistema permite cadastrar produtos, endereços (origem e destino) e transportadores, e gerar fretes que relacionam esses dados. Um mesmo transportador pode levar vários produtos (relação 1 para muitos). Também é possível baixar um relatório dos fretes de um dia específico.

## Funcionalidades

- Cadastro e edição de produtos
- Cadastro e edição de endereços
- Cadastro e edição de transportadores
- Geração de fretes ligando transportador, produto, origem e destino
- Relatório de fretes por dia, com download em CSV
- Menu de navegação em todas as telas

## Tecnologias

- PHP (backend)
- SQLite (banco de dados)
- HTML, CSS e JavaScript (frontend)
- Bootstrap 5
- Git e GitHub

## Como executar

1. Instale o PHP com as extensões `pdo_sqlite` e `sqlite3` ativadas.
2. Na pasta do projeto, execute: `php -S localhost:8000`
3. Abra no navegador: `http://localhost:8000/paginas/produto.php`

O banco de dados (`banco/logistica.db`) é criado automaticamente no primeiro acesso.

## Estrutura de pastas

- `paginas/` : telas do sistema (produto, endereço, transportador, frete, relatório)
- `includes/` : cabeçalho com menu, rodapé e conexão com o banco
- `banco/` : arquivo do banco de dados SQLite
- `css/` e `js/` : estilos e scripts