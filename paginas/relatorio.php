<?php
require '../includes/conexao.php';

$data = $_GET['data'] ?? date('Y-m-d');
$sql = $banco->prepare("SELECT f.id, t.nome AS transportador, p.nome AS produto, o.rua AS origem, d.rua AS destino, f.valor, f.data
    FROM fretes f
    JOIN transportadores t ON t.id = f.transportador_id
    JOIN produtos p ON p.id = f.produto_id
    JOIN enderecos o ON o.id = f.origem_id
    JOIN enderecos d ON d.id = f.destino_id
    WHERE f.data = ? ORDER BY f.id");
$sql->execute([$data]);
$fretes = $sql->fetchAll(PDO::FETCH_ASSOC);

if (isset($_GET['baixar'])) {
    header('Content-Type: text/csv; charset=UTF-8');
    header('Content-Disposition: attachment; filename="relatorio-fretes-' . $data . '.csv"');
    echo "\xEF\xBB\xBF";
    $saida = fopen('php://output', 'w');
    fputcsv($saida, ['ID', 'Transportador', 'Produto', 'Origem', 'Destino', 'Valor', 'Data'], ';', '"', '');
    foreach ($fretes as $f) {
        fputcsv($saida, $f, ';', '"', '');
    }
    fclose($saida);
    exit;
}
include '../includes/cabecalho.php';
?>
<h3>Relatório de Fretes</h3>
<form method="get" class="mb-4">
    <input name="data" type="date" value="<?= htmlspecialchars($data) ?>" class="form-control mb-2" required>
    <button class="btn btn-secondary">Ver fretes do dia</button>
    <button name="baixar" value="1" class="btn btn-primary">Baixar relatório</button>
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