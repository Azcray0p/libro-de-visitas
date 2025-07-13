<?php
try {
    $pdo = new PDO('sqlite:visitantes.db');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    } catch (PDOException $e) {
        die("Error al conectar a la base de datos: " . $e->getMessage());
    }

try {
    $pdo->exec("CREATE TABLE IF NOT EXISTS visitantes (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    nombre TEXT NOT NULL,
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP 
    );");
}   catch (PDOException $e) {
    die("Error al crear la tabla: " . $e->getMessage());
}

$mensajeFinal = "";
$saludo = "¡Hola, ";

if (isset($_POST['name']) && !empty($_POST['name'])) {

    $nombre = htmlspecialchars($_POST['name']);
    $mensajeFinal = $saludo . $nombre . "! Bienvenido a nuestra aplicación.";

    // Preparar la consulta SQL para insertar el nombre en la base de datos
    try {
        $sql_insert = "INSERT INTO visitantes (nombre) VALUES (:nombre)";
        $stmt = $pdo->prepare($sql_insert);
        $stmt->execute(['nombre' => $nombre]);

    } catch (PDOException $e) {
        die("Error al insertar el nombre: " . $e->getMessage());
    }

} else {
    $mensajeFinal = "Por favor, ingresa tu nombre.";
}
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
    
    <hr> <h3>Visitantes Anteriores:</h3>

    <?php

    // Consultar los nombres de los visitantes anteriores
    $sql_query = "SELECT nombre, fecha_registro FROM visitantes ORDER BY fecha_registro DESC";
    $stmt = $pdo->query($sql_query);

    echo "<ul>";
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<li>" . htmlspecialchars($row['nombre']) . " <small> (Registrado el: " . htmlspecialchars($row['fecha_registro']) . ") </small> </li>";
    }
    echo "</ul>";

    ?>


</body>
</html>