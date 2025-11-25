<?php
/* @autor Joaquín Rana Pallero */

class Database {
    private $pdo;
    
    public function __construct() {
        // Configuración por defecto XAMPP (usuario root, sin clave)
        // Cambia "" por "root" si usas MAMP o tienes clave configurada.
        try {
            $this->pdo = new PDO("mysql:host=localhost;dbname=MIPROYECTO", "root", "");
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Error de conexión: " . $e->getMessage();
            exit;
        }
    }

    public function insert($sql, $params = []) {
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute($params);
    }

    public function select($sql, $params = [], $class = 'stdClass') {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_CLASS, $class);
    }
    
    public function delete($sql, $params = []) {
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute($params);
    }
}
?>