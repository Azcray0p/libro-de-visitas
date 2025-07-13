<?php

namespace Azcray0p\Aplicacion2;

use PDO;

class Guestbook
{

    private $pdo;
    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    // Metodos

    public function GetAllVisitors()
    {
        $stmt = $this->pdo->query("SELECT nombre, fecha_registro FROM visitantes ORDER BY fecha_registro DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function AddVisitor($name)
    {
        $sql = "INSERT INTO visitantes (nombre) VALUES (:nombre)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute(['nombre' => $name]);
    }
}
