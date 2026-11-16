<?php
require '../includes/conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $sql = $banco->prepare("INSERT INTO enderecos (rua, numero, bairro, cidade, estado, cep) VALUES (?, ?, ?, ?, ?, ?)");
    $sql->execute([$_POST['rua'], $_POST['numero'], $_POST['bairro'], $_POST['cidade'], $_POST['estado'], $_POST['cep']]);
    header('Location: endereco.php');
    exit;
}
$enderecos = $banco->query("SELECT * FROM enderecos")->fetchAll(PDO::FETCH_ASSOC);
include '../includes/cabecalho.php';
?>
<h3>Cadastro de Endereço</h3>
<form method="post" class="mb-4">
    <input name="rua" class="form-control mb-2" placeholder="Rua" required>
    <input name="numero" class="form-control mb-2" placeholder="Número">
    <input name="bairro" class="form-control mb-2" placeholder="Bairro">
    <input name="cidade" class="form-control mb-2" placeholder="Cidade">
    <input name="estado" class="form-control mb-2" placeholder="Estado">
    <input name="cep" class="form-control mb-2" placeholder="CEP">
    <button class="btn btn-primary">Salvar</button>
</form>
<table class="table">
    <tr><th>ID</th><th>Rua</th><th>Nº</th><th>Bairro</th><th>Cidade</th><th>UF</th><th>CEP</th></tr>
    <?php foreach ($enderecos as $e): ?>
    <tr>
        <td><?= $e['id'] ?></td>
        <td><?= htmlspecialchars($e['rua']) ?></td>
        <td><?= htmlspecialchars($e['numero']) ?></td>
        <td><?= htmlspecialchars($e['bairro']) ?></td>
        <td><?= htmlspecialchars($e['cidade']) ?></td>
        <td><?= htmlspecialchars($e['estado']) ?></td>
        <td><?= htmlspecialchars($e['cep']) ?></td>
    </tr>
    <?php endforeach; ?>
</table>
<?php include '../includes/rodape.php'; ?>