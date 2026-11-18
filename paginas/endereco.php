<?php
require '../includes/conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $dados = [$_POST['rua'], $_POST['numero'], $_POST['bairro'], $_POST['cidade'], $_POST['estado'], $_POST['cep']];
    if (!empty($_POST['id'])) {
        $sql = $banco->prepare("UPDATE enderecos SET rua = ?, numero = ?, bairro = ?, cidade = ?, estado = ?, cep = ? WHERE id = ?");
        $sql->execute([...$dados, $_POST['id']]);
    } else {
        $sql = $banco->prepare("INSERT INTO enderecos (rua, numero, bairro, cidade, estado, cep) VALUES (?, ?, ?, ?, ?, ?)");
        $sql->execute($dados);
    }
    header('Location: endereco.php');
    exit;
}

$editando = null;
if (isset($_GET['editar'])) {
    $sql = $banco->prepare("SELECT * FROM enderecos WHERE id = ?");
    $sql->execute([$_GET['editar']]);
    $editando = $sql->fetch(PDO::FETCH_ASSOC);
}
$enderecos = $banco->query("SELECT * FROM enderecos")->fetchAll(PDO::FETCH_ASSOC);
include '../includes/cabecalho.php';
?>
<h3><?= $editando ? 'Editar Endereço' : 'Cadastro de Endereço' ?></h3>
<form method="post" class="mb-4">
    <input type="hidden" name="id" value="<?= $editando['id'] ?? '' ?>">
    <input name="rua" value="<?= htmlspecialchars($editando['rua'] ?? '') ?>" class="form-control mb-2" placeholder="Rua" required>
    <input name="numero" value="<?= htmlspecialchars($editando['numero'] ?? '') ?>" class="form-control mb-2" placeholder="Número">
    <input name="bairro" value="<?= htmlspecialchars($editando['bairro'] ?? '') ?>" class="form-control mb-2" placeholder="Bairro">
    <input name="cidade" value="<?= htmlspecialchars($editando['cidade'] ?? '') ?>" class="form-control mb-2" placeholder="Cidade">
    <input name="estado" value="<?= htmlspecialchars($editando['estado'] ?? '') ?>" class="form-control mb-2" placeholder="Estado">
    <input name="cep" value="<?= htmlspecialchars($editando['cep'] ?? '') ?>" class="form-control mb-2" placeholder="CEP">
    <button class="btn btn-primary">Salvar</button>
    <?php if ($editando): ?>
    <a href="endereco.php" class="btn btn-secondary">Cancelar</a>
    <?php endif; ?>
</form>
<table class="table">
    <tr><th>ID</th><th>Rua</th><th>Nº</th><th>Bairro</th><th>Cidade</th><th>UF</th><th>CEP</th><th>Ações</th></tr>
    <?php foreach ($enderecos as $e): ?>
    <tr>
        <td><?= $e['id'] ?></td>
        <td><?= htmlspecialchars($e['rua']) ?></td>
        <td><?= htmlspecialchars($e['numero']) ?></td>
        <td><?= htmlspecialchars($e['bairro']) ?></td>
        <td><?= htmlspecialchars($e['cidade']) ?></td>
        <td><?= htmlspecialchars($e['estado']) ?></td>
        <td><?= htmlspecialchars($e['cep']) ?></td>
        <td><a href="?editar=<?= $e['id'] ?>" class="btn btn-sm btn-outline-primary">Editar</a></td>
    </tr>
    <?php endforeach; ?>
</table>
<?php include '../includes/rodape.php'; ?>