<?php
require '../includes/conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $sql = $banco->prepare("INSERT INTO fretes (transportador_id, produto_id, origem_id, destino_id, valor, data) VALUES (?, ?, ?, ?, ?, ?)");
    $sql->execute([$_POST['transportador'], $_POST['produto'], $_POST['origem'], $_POST['destino'], $_POST['valor'], $_POST['data']]);
    header('Location: frete.php');
    exit;
}
$transportadores = $banco->query("SELECT id, nome FROM transportadores")->fetchAll(PDO::FETCH_ASSOC);
$produtos = $banco->query("SELECT id, nome FROM produtos")->fetchAll(PDO::FETCH_ASSOC);
$enderecos = $banco->query("SELECT id, rua, numero, cidade FROM enderecos")->fetchAll(PDO::FETCH_ASSOC);
$fretes = $banco->query("SELECT f.id, t.nome AS transportador, p.nome AS produto, o.rua AS origem, d.rua AS destino, f.valor, f.data
    FROM fretes f
    JOIN transportadores t ON t.id = f.transportador_id
    JOIN produtos p ON p.id = f.produto_id
    JOIN enderecos o ON o.id = f.origem_id
    JOIN enderecos d ON d.id = f.destino_id
    ORDER BY f.id DESC")->fetchAll(PDO::FETCH_ASSOC);
include '../includes/cabecalho.php';
?>
<h3>Cadastro de Frete</h3>
<form method="post" class="mb-4">
    <select name="transportador" class="form-select mb-2" required>
        <option value="">Transportador</option>
        <?php foreach ($transportadores as $t): ?>
        <option value="<?= $t['id'] ?>"><?= htmlspecialchars($t['nome']) ?></option>
        <?php endforeach; ?>
    </select>
    <select name="produto" class="form-select mb-2" required>
        <option value="">Produto</option>
        <?php foreach ($produtos as $p): ?>
        <option value="<?= $p['id'] ?>"><?= htmlspecialchars($p['nome']) ?></option>
        <?php endforeach; ?>
    </select>
    <select name="origem" class="form-select mb-2" required>
        <option value="">Endereço de origem</option>
        <?php foreach ($enderecos as $e): ?>
        <option value="<?= $e['id'] ?>"><?= htmlspecialchars($e['rua'] . ', ' . $e['numero'] . ' - ' . $e['cidade']) ?></option>
        <?php endforeach; ?>
    </select>
    <select name="destino" class="form-select mb-2" required>
        <option value="">Endereço de destino</option>
        <?php foreach ($enderecos as $e): ?>
        <option value="<?= $e['id'] ?>"><?= htmlspecialchars($e['rua'] . ', ' . $e['numero'] . ' - ' . $e['cidade']) ?></option>
        <?php endforeach; ?>
    </select>
    <input name="valor" type="number" step="0.01" class="form-control mb-2" placeholder="Valor do frete" required>
    <input name="data" type="date" value="<?= date('Y-m-d') ?>" class="form-control mb-2" required>
    <button class="btn btn-primary">Gerar frete</button>
</form>
<table class="table">
    <tr><th>ID</th><th>Transportador</th><th>Produto</th><th>Origem</th><th>Destino</th><th>Valor</th><th>Data</th></tr>
    <?php foreach ($fretes as $f): ?>
    <tr>
        <td><?= $f['id'] ?></td>
        <td><?= htmlspecialchars($f['transportador']) ?></td>
        <td><?= htmlspecialchars($f['produto']) ?></td>
        <td><?= htmlspecialchars($f['origem']) ?></td>
        <td><?= htmlspecialchars($f['destino']) ?></td>
        <td><?= $f['valor'] ?></td>
        <td><?= $f['data'] ?></td>
    </tr>
    <?php endforeach; ?>
</table>
<?php include '../includes/rodape.php'; ?>