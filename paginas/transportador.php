<?php
require '../includes/conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $sql = $banco->prepare("INSERT INTO transportadores (nome, documento, telefone, veiculo) VALUES (?, ?, ?, ?)");
    $sql->execute([$_POST['nome'], $_POST['documento'], $_POST['telefone'], $_POST['veiculo']]);
    header('Location: transportador.php');
    exit;
}
$transportadores = $banco->query("SELECT * FROM transportadores")->fetchAll(PDO::FETCH_ASSOC);
include '../includes/cabecalho.php';
?>
<h3>Cadastro de Transportador</h3>
<form method="post" class="mb-4">
    <input name="nome" class="form-control mb-2" placeholder="Nome" required>
    <input name="documento" class="form-control mb-2" placeholder="CPF ou CNPJ">
    <input name="telefone" class="form-control mb-2" placeholder="Telefone">
    <input name="veiculo" class="form-control mb-2" placeholder="Veículo">
    <button class="btn btn-primary">Salvar</button>
</form>
<table class="table">
    <tr><th>ID</th><th>Nome</th><th>CPF/CNPJ</th><th>Telefone</th><th>Veículo</th></tr>
    <?php foreach ($transportadores as $t): ?>
    <tr>
        <td><?= $t['id'] ?></td>
        <td><?= htmlspecialchars($t['nome']) ?></td>
        <td><?= htmlspecialchars($t['documento']) ?></td>
        <td><?= htmlspecialchars($t['telefone']) ?></td>
        <td><?= htmlspecialchars($t['veiculo']) ?></td>
    </tr>
    <?php endforeach; ?>
</table>
<?php include '../includes/rodape.php'; ?>