<?php
require_once __DIR__ . '/../../src/Equipement.php';

$message = "";
$erreur = "";
$showForm = isset($_GET['ajouter']);

$equipement = new Equipement();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ajouter'])) {
    $nom  = trim($_POST['nom'] ?? '');
    $ip   = trim($_POST['adresse_ip'] ?? '');
    $type = trim($_POST['type'] ?? '');

    if (empty($nom) || empty($ip) || empty($type)) {
        $erreur = "Tous les champs sont obligatoires.";
        $showForm = true;
    } elseif (!filter_var($ip, FILTER_VALIDATE_IP)) {
        $erreur = "L'adresse IP est invalide.";
        $showForm = true;
    } else {
        if ($equipement->ajouter($nom, $ip, $type)) {
            $message = "Équipement ajouté avec succès !";
            $showForm = false;
        } else {
            $erreur = "Erreur lors de l'ajout.";
            $showForm = true;
        }
    }
}

if (isset($_GET['action']) && $_GET['action'] === 'supprimer' && isset($_GET['id'])) {
    $id = (int) $_GET['id'];
    if ($equipement->supprimer($id)) {
        $message = "Équipement supprimé avec succès !";
    }
}

$liste = $equipement->lister();

include __DIR__ . '/../../templates/header.php';
?>

<div class="container">
    <h2>Gestion des équipements</h2>

<?php if ($message): ?>
    <p id="message">✅ <?= htmlspecialchars($message) ?></p>
<?php endif; ?>

    <?php if ($erreur): ?>
        <div class="alert error"><?= htmlspecialchars($erreur) ?></div>
    <?php endif; ?>

    <?php if (empty($liste) && !$showForm): ?>
        <p>Aucun équipement trouvé.</p>
        <form method="GET" action="">
    <button type="submit" name="ajouter" value="1">+ Ajouter un équipement</button>
</form>

    <?php elseif ($showForm): ?>
        <form method="POST" action="">
            <label>Nom</label>
            <input type="text" name="nom" placeholder="Ex: Switch-Salle-A" required>

            <label>Adresse IP</label>
            <input type="text" name="adresse_ip" placeholder="Ex: 192.168.1.1" required>

            <label>Type</label>
            <select name="type" required>
                <option value="">-- Choisir --</option>
                <option value="routeur">Routeur</option>
                <option value="serveur">Serveur</option>
                <option value="commutateur">Commutateur</option>
            </select>

            <button type="submit" name="ajouter">Confirmer</button>
            <button type="button" onclick="window.location.href='Gestion.php'">Annuler</button>
        </form>

    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Adresse IP</th>
                    <th>Type</th>
                    <th>Date d'ajout</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($liste as $item): ?>
                <tr>
                    <td><?= htmlspecialchars($item['nom']) ?></td>
                    <td><?= htmlspecialchars($item['adresse_ip']) ?></td>
                    <td><?= htmlspecialchars($item['type']) ?></td>
                    <td><?= htmlspecialchars($item['date_ajout']) ?></td>
                    <td>
                       <button type="button" onclick="ouvrirPopup(<?= $item['id'] ?>)">🗑️</button>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <form method="GET" action="">
    <button type="submit" name="ajouter" value="1">+ Ajouter un équipement</button>
</form>
<div id="popup-supprimer">    <p>Voulez-vous vraiment supprimer cet équipement ?</p>
    <form method="GET" action="">
        <input type="hidden" name="action" value="supprimer">
        <input type="hidden" name="id" id="popup-id" value="">
        <button type="button" onclick="fermerPopup()">Annuler</button>
        <button type="submit">Supprimer</button>
    </form>
</div>

<div id="overlay-supprimer"></div>
    <?php endif; ?>


<?php include __DIR__ . '/../../templates/footer.php'; ?>
