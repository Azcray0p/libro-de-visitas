<?php
require_once __DIR__ . '/vendor/autoload.php';

use Azcray0p\Aplicacion2\Database;
use Azcray0p\Aplicacion2\Guestbook;

$db = new Database();
$pdo = $db->pdo;
$guestbook = new Guestbook($db->pdo);

$mensajeFinal = "";
$saludo = "¡Hola, ";

if (isset($_POST['name']) && !empty($_POST['name'])) {

    $nombre = htmlspecialchars($_POST['name']);
    $mensajeFinal = $saludo . $nombre . "! Bienvenido a nuestra aplicación.";

    $guestbook->addVisitor($nombre);
} else {
    $mensajeFinal = "Por favor, ingresa tu nombre.";
}
$visitantes = $guestbook->getAllVisitors();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Saludo Personal</title>
</head>

<body>

    <h3><?php echo $mensajeFinal; ?></h3>

    <form action="index.php" method="post">
        <label for="name">Escribe tu nombre:</label>
        <input type="text" id="name" name="name">
        <button type="submit">Saludar</button>
    </form>

    <hr>
    <h3>Visitantes Anteriores:</h3>

    <ul>
        <?php
        // Recorre la variable $visitantes y muestra cada uno
        foreach ($visitantes as $visitante):
        ?>
            <li>
                <?php echo htmlspecialchars($visitante['nombre']); ?>
                <small>(Registrado el: <?php echo $visitante['fecha_registro']; ?>)</small>
            </li>
        <?php endforeach; ?>
    </ul>

</body>

</html>