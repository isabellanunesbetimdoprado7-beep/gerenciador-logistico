<?php
require '../includes/conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $sql = $banco->prepare("INSERT INTO produtos (nome, descricao, peso, valor) VALUES (?, ?, ?, ?)");
    $sql->execute([$_POST['nome'], $_POST['descricao'], $_POST['peso'], $_POST['valor']]);
    header('Location: produto.php');
    exit;
}
$produtos = $banco->query("SELECT * FROM produtos")->fetchAll(PDO::FETCH_ASSOC);
include '../includes/cabecalho.php';
?>
<h3>Cadastro de Produto</h3>
<form method="post" class="mb-4">
    <input name="nome" class="form-control mb-2" placeholder="Nome" required>
    <input name="descricao" class="form-control mb-2" placeholder="Descrição">
    <input name="peso" type="number" step="0.01" class="form-control mb-2" placeholder="Peso (kg)">
    <input name="valor" type="number" step="0.01" class="form-control mb-2" placeholder="Valor">
    <button class="btn btn-primary">Salvar</button>
</form>
<table class="table">
    <tr><th>ID</th><th>Nome</th><th>Descrição</th><th>Peso</th><th>Valor</th></tr>
    <?php foreach ($produtos as $p): ?>
    <tr>
        <td><?= $p['id'] ?></td>
        <td><?= htmlspecialchars($p['nome']) ?></td>
        <td><?= htmlspecialchars($p['descricao']) ?></td>
        <td><?= $p['peso'] ?></td>
        <td><?= $p['valor'] ?></td>
    </tr>
    <?php endforeach; ?>
</table>
<?php include '../includes/rodape.php'; ?>