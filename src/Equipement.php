<?php
require_once __DIR__ . '/../config/database.php';

class Equipement {
    private $pdo;

    public function __construct() {
        $this->pdo = getConnection();
    }
        //mi ajouter equipement anakiray
    public function ajouter($nom, $ip, $type) {
        $stmt = $this->pdo->prepare(
            "INSERT INTO equipements (nom, adresse_ip, type) VALUES (?, ?, ?)"
        );
        return $stmt->execute([$nom, $ip, $type]);
    }
        //maka ny Id ana equipement anakiray ao anaty db
    public function getByID($id){
        $stmt = $this->pdo->prepare("SELECT * FROM equipements WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    //mamafa equipement ray anaty db
    public function supprimer($id){
        $stmt = $this->pdo->prepare("DELETE FROM equipements WHERE id =?");
        return $stmt->execute([$id]);

    }

    public function lister() {
        $stmt = $this->pdo->prepare("SELECT * FROM equipements");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>