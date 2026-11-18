<?php
require '../includes/conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $dados = [$_POST['nome'], $_POST['documento'], $_POST['telefone'], $_POST['veiculo']];
    if (!empty($_POST['id'])) {
        $sql = $banco->prepare("UPDATE transportadores SET nome = ?, documento = ?, telefone = ?, veiculo = ? WHERE id = ?");
        $sql->execute([...$dados, $_POST['id']]);
    } else {
        $sql = $banco->prepare("INSERT INTO transportadores (nome, documento, telefone, veiculo) VALUES (?, ?, ?, ?)");
        $sql->execute($dados);
    }
    header('Location: transportador.php');
    exit;
}

$editando = null;
if (isset($_GET['editar'])) {
    $sql = $banco->prepare("SELECT * FROM transportadores WHERE id = ?");
    $sql->execute([$_GET['editar']]);
    $editando = $sql->fetch(PDO::FETCH_ASSOC);
}
$transportadores = $banco->query("SELECT * FROM transportadores")->fetchAll(PDO::FETCH_ASSOC);
include '../includes/cabecalho.php';
?>
<h3><?= $editando ? 'Editar Transportador' : 'Cadastro de Transportador' ?></h3>
<form method="post" class="mb-4">
    <input type="hidden" name="id" value="<?= $editando['id'] ?? '' ?>">
    <input name="nome" value="<?= htmlspecialchars($editando['nome'] ?? '') ?>" class="form-control mb-2" placeholder="Nome" required>
    <input name="documento" value="<?= htmlspecialchars($editando['documento'] ?? '') ?>" class="form-control mb-2" placeholder="CPF ou CNPJ">
    <input name="telefone" value="<?= htmlspecialchars($editando['telefone'] ?? '') ?>" class="form-control mb-2" placeholder="Telefone">
    <input name="veiculo" value="<?= htmlspecialchars($editando['veiculo'] ?? '') ?>" class="form-control mb-2" placeholder="Veículo">
    <button class="btn btn-primary">Salvar</button>
    <?php if ($editando): ?>
    <a href="transportador.php" class="btn btn-secondary">Cancelar</a>
    <?php endif; ?>
</form>
<table class="table">
    <tr><th>ID</th><th>Nome</th><th>CPF/CNPJ</th><th>Telefone</th><th>Veículo</th><th>Ações</th></tr>
    <?php foreach ($transportadores as $t): ?>
    <tr>
        <td><?= $t['id'] ?></td>
        <td><?= htmlspecialchars($t['nome']) ?></td>
        <td><?= htmlspecialchars($t['documento']) ?></td>
        <td><?= htmlspecialchars($t['telefone']) ?></td>
        <td><?= htmlspecialchars($t['veiculo']) ?></td>
        <td><a href="?editar=<?= $t['id'] ?>" class="btn btn-sm btn-outline-primary">Editar</a></td>
    </tr>
    <?php endforeach; ?>
</table>
<?php include '../includes/rodape.php'; ?>