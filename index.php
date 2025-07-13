<?php
$mensajeFinal = "";
$saludo = "¡Hola, ";

if (isset($_POST['name']) && !empty($_POST['name'])) {

    $nombre = htmlspecialchars($_POST['name']);
    $mensajeFinal = $saludo . $nombre . "! Bienvenido a nuestra aplicación.";

    $guardarNombre = $nombre . "\n";
    // Guardar el nombre en un archivo de texto (FILE_APPEND asegura que se añada al final.)
    file_put_contents('visitantes.txt', $guardarNombre, FILE_APPEND);

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

    $archivoVisitantes = 'visitantes.txt';
    // file_exists() verifica si el archivo existe
    if (file_exists($archivoVisitantes)) {

        // la función file() se utiliza para leer el contenido de un archivo y almacenarlo en un array.
        $visitantes = file($archivoVisitantes) ;

        echo "<ul>";
        // foreach es una estructura que permite recorrer todos los elementos de un array o colección.
        // $visitantes es el array principal que contiene datos, por ejemplo, una lista de personas.
        // $visitante es una variable temporal que representa cada elemento del array durante la iteración.
        foreach ($visitantes as $visitante) {
            echo "<li>" . htmlspecialchars($visitante) . "</li>";
        }
        echo "</ul>";
    } else {
        echo "<p>No hay visitantes registrados aún.</p>";
    }

    ?>


</body>
</html>