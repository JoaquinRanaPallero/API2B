<?php
/* @autor Joaquín Rana Pallero */
class Categorias {
    public $id;
    public $nombre;

    public function guardar() {
        $db = new Database();
        // Usamos REPLACE o ON DUPLICATE para cubrir Insertar y Actualizar
        $sql = "INSERT INTO categorias (id, nombre) VALUES (:id, :nombre)
                ON DUPLICATE KEY UPDATE nombre=:nombre";
        $params = [':id' => $this->id, ':nombre' => $this->nombre];
        return $db->insert($sql, $params);
    }
    
    public function eliminar() {
        $db = new Database();
        $sql = "DELETE FROM categorias WHERE id = :id";
        return $db->delete($sql, [':id' => $this->id]);
    }

    public static function listar() {
        $db = new Database();
        return $db->select("SELECT * FROM categorias", [], 'Categorias');
    }
}
?>