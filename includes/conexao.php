<?php
date_default_timezone_set('America/Sao_Paulo');
$banco = new PDO('sqlite:' . __DIR__ . '/../banco/logistica.db');
$banco->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$banco->exec("CREATE TABLE IF NOT EXISTS produtos (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    nome TEXT, descricao TEXT, peso REAL, valor REAL)");

$banco->exec("CREATE TABLE IF NOT EXISTS enderecos (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    rua TEXT, numero TEXT, bairro TEXT, cidade TEXT, estado TEXT, cep TEXT)");

$banco->exec("CREATE TABLE IF NOT EXISTS transportadores (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    nome TEXT, documento TEXT, telefone TEXT, veiculo TEXT)");

$banco->exec("CREATE TABLE IF NOT EXISTS fretes (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    transportador_id INTEGER, produto_id INTEGER,
    origem_id INTEGER, destino_id INTEGER,
    valor REAL, data TEXT)");