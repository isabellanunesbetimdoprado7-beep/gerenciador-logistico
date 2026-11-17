<?php
require '../includes/conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!empty($_POST['id'])) {
        $sql = $banco->prepare("UPDATE produtos SET nome = ?, descricao = ?, peso = ?, valor = ? WHERE id = ?");
        $sql->execute([$_POST['nome'], $_POST['descricao'], $_POST['peso'], $_POST['valor'], $_POST['id']]);
    } else {
        $sql = $banco->prepare("INSERT INTO produtos (nome, descricao, peso, valor) VALUES (?, ?, ?, ?)");
        $sql->execute([$_POST['nome'], $_POST['descricao'], $_POST['peso'], $_POST['valor']]);
    }
    header('Location: produto.php');
    exit;
}

$editando = null;
if (isset($_GET['editar'])) {
    $sql = $banco->prepare("SELECT * FROM produtos WHERE id = ?");
    $sql->execute([$_GET['editar']]);
    $editando = $sql->fetch(PDO::FETCH_ASSOC);
}
$produtos = $banco->query("SELECT * FROM produtos")->fetchAll(PDO::FETCH_ASSOC);
include '../includes/cabecalho.php';
?>
<h3><?= $editando ? 'Editar Produto' : 'Cadastro de Produto' ?></h3>
<form method="post" class="mb-4">
    <input type="hidden" name="id" value="<?= $editando['id'] ?? '' ?>">
    <input name="nome" value="<?= htmlspecialchars($editando['nome'] ?? '') ?>" class="form-control mb-2" placeholder="Nome" required>
    <input name="descricao" value="<?= htmlspecialchars($editando['descricao'] ?? '') ?>" class="form-control mb-2" placeholder="Descrição">
    <input name="peso" value="<?= $editando['peso'] ?? '' ?>" type="number" step="0.01" class="form-control mb-2" placeholder="Peso (kg)">
    <input name="valor" value="<?= $editando['valor'] ?? '' ?>" type="number" step="0.01" class="form-control mb-2" placeholder="Valor">
    <button class="btn btn-primary">Salvar</button>
    <?php if ($editando): ?>
    <a href="produto.php" class="btn btn-secondary">Cancelar</a>
    <?php endif; ?>
</form>
<table class="table">
    <tr><th>ID</th><th>Nome</th><th>Descrição</th><th>Peso</th><th>Valor</th><th>Ações</th></tr>
    <?php foreach ($produtos as $p): ?>
    <tr>
        <td><?= $p['id'] ?></td>
        <td><?= htmlspecialchars($p['nome']) ?></td>
        <td><?= htmlspecialchars($p['descricao']) ?></td>
        <td><?= $p['peso'] ?></td>
        <td><?= $p['valor'] ?></td>
        <td><a href="?editar=<?= $p['id'] ?>" class="btn btn-sm btn-outline-primary">Editar</a></td>
    </tr>
    <?php endforeach; ?>
</table>
<?php include '../includes/rodape.php'; ?>