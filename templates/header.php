<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/php_supervision_equipements_L2/public/assets/css/style.css">
    <title>Supervision des Équipements</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: Arial, sans-serif;
        }
        
        header {
            background-color: #333;
            padding: 1rem 0;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        nav {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 1rem;
        }
        
        nav ul {
            list-style: none;
            display: flex;
            gap: 2rem;
            align-items: center;
        }
        
        nav a {
            color: white;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s;
        }
        
        nav a:hover {
            color: #4CAF50;
        }
    </style>
</head>
<body>
    <header>
        <h1>Supervision des Équipements</h1>
        <nav>
            <ul>
                <li><a href="/php_supervision_equipements_L2/public/index.php">Accueil</a></li>
                <li><a href="/php_supervision_equipements_L2/public/equipements/Gestion.php">Gestion</a></li>
                <li><a href="/php_supervision_equipements_L2/public/controle/etat.php">Contrôle SNMP</a></li>
                <li><a href="/php_supervision_equipements_L2/public/scan/ports.php">Scan Ports</a></li>
            </ul>
        </nav>
    </header>