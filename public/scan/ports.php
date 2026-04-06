<?php
require_once __DIR__ . '/../../src/PortScanner.php';
require_once __DIR__ . '/../../templates/header.php';

$results = [];
$error = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ip = trim($_POST['ip'] ?? '');
    $mode = $_POST['mode'] ?? 'single';

    if (!filter_var($ip, FILTER_VALIDATE_IP)) {
        $error = "Adresse IP invalide.";
    } else {
        $scanner = new PortScanner(1); // timeout 1 seconde

        if ($mode === 'single' && isset($_POST['port']) && is_numeric($_POST['port'])) {
            $port = (int)$_POST['port'];
            if ($port >= 1 && $port <= 65535) {
                $result = $scanner->scanSingle($ip, $port);
                $results = [$result];
            } else {
                $error = "Port invalide (1-65535).";
            }
        } 
        elseif ($mode === 'range' && isset($_POST['start'], $_POST['end'])) {
            $start = (int)$_POST['start'];
            $end = (int)$_POST['end'];
            if ($start >= 1 && $end <= 65535 && $start <= $end) {
                $results = $scanner->scanRange($ip, $start, $end);
            } else {
                $error = "Plage invalide (1-65535, début ≤ fin).";
            }
        } else {
            $error = "Veuillez remplir tous les champs.";
        }
    }
}
?>

<h2>Scan de ports</h2>

<?php if ($error): ?>
    <p style="color:red"><?= htmlspecialchars($error) ?></p>
<?php endif; ?>

<form method="post">
    <label>Adresse IP : <input type="text" name="ip" required value="<?= htmlspecialchars($_POST['ip'] ?? '') ?>"></label><br><br>

    <fieldset>
        <legend>Type de scan</legend>
        <label>
            <input type="radio" name="mode" value="single" <?= (!isset($_POST['mode']) || $_POST['mode'] === 'single') ? 'checked' : '' ?>>
            Port unique :
            <input type="number" name="port" min="1" max="65535" value="<?= htmlspecialchars($_POST['port'] ?? '') ?>">
        </label><br>

        <label>
            <input type="radio" name="mode" value="range" <?= (isset($_POST['mode']) && $_POST['mode'] === 'range') ? 'checked' : '' ?>>
            Plage de ports :
            de <input type="number" name="start" min="1" max="65535" value="<?= htmlspecialchars($_POST['start'] ?? '') ?>">
            à <input type="number" name="end" min="1" max="65535" value="<?= htmlspecialchars($_POST['end'] ?? '') ?>">
        </label>
    </fieldset><br>

    <button type="submit">Scanner</button>
</form>

<?php if (!empty($results)): ?>
    <h3>Résultats pour <?= htmlspecialchars($ip) ?> :</h3>
    <table border="1" cellpadding="5">
        <thead>
            <tr><th>Port</th><th>Statut</th><th>Service</th></tr>
        </thead>
        <tbody>
            <?php foreach ($results as $r): ?>
                <tr>
                    <td><?= $r['port'] ?></td>
                    <td style="color: <?= $r['statut'] === 'open' ? 'green' : 'red' ?>">
                        <?= $r['statut'] === 'open' ? 'Ouvert' : ($r['statut'] === 'closed' ? 'Fermé' : 'Filtré') ?>
                    </td>
                    <td><?= htmlspecialchars($r['service']) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>

<?php require_once __DIR__ . '/../../templates/footer.php'; ?>