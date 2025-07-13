<?php

namespace Azcray0p\Aplicacion2;

use PDO;
use PDOException;

class Database
{
    public $pdo;

    // Este es el "constructor". Es un método especial que se ejecuta
    // automáticamente cuando creamos un nuevo objeto Database.
    public function __construct()
    {

        try {
            $this->pdo = new PDO('sqlite:visitantes.db');
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Error al conectar a la base de datos: " . $e->getMessage());
        }

        try {
            $this->pdo->exec("CREATE TABLE IF NOT EXISTS visitantes (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            nombre TEXT NOT NULL,
            fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP 
            );");
        } catch (PDOException $e) {
            die("Error al crear la tabla: " . $e->getMessage());
        }
    }
}
