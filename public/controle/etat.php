<?php
//formulaire pour la séléction de l'equipement à contrôler

require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../src/Equipement.php';
require_once __DIR__ . '/../../src/SnmpChecker.php';
require_once __DIR__ . '/../../templates/header.php';

//instance de classe equipement
$equipement = new Equipement();
$equipements = $equipement->lister();

//décla variables
$ip = '';
$resultat = null;
$details = [];

//traitement du formulaire 
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ip = trim($_POST['ip'] ?? '');
    if (!empty($ip)) {
        $snmp = new SnmpChecker($ip);
        $resultat = $snmp->getStatus();
        if ($resultat === 'UP') {
            $details = [
                'sysName' => $snmp->getSysName(),
                'sysDescr' => $snmp->getSysDescr()
            ];
        }
    }
}
?>

<h2>Page de contrôle SNMP</h2>

<form method="post">
    <label>Adresse IP : 
        <input type="text" name="ip">
    </label>
    <button type="submit">Scanner</button>
</form>

<?php if ($resultat !== null): ?>
    <h3>Résultat du scan pour <?= htmlspecialchars($_POST['ip']) ?> : <?= $resultat ?></h3>
    <?php if ($resultat === 'UP' && $details): ?>
        <ul>
            <?php if ($details['sysName']): ?>
                <li><strong>Nom du système : </strong> <?= htmlspecialchars($details['sysName']) ?></li>
            <?php endif; ?>
            <?php if ($details['sysDescr']): ?>
                <li><strong>Déscription système : </stong> <?= htmlspecialchars($details['sysDescr']) ?></li>
            <?php endif; ?>
        </ul>
    <?php endif; ?>
<?php endif; ?>

<h3>Liste des Equipements enregistrés</h3>
<ul>
    <?php foreach ($equipements as $e): ?>
        <li>
            <?= htmlspecialchars($e['nom']) ?> (<?= htmlspecialchars($e['adresse_ip']) ?>)
        </li>
    <?php endforeach; ?>
</ul>

<?php
require_once __DIR__ . '/../../templates/footer.php';
?>