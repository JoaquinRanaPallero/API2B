<?php
/* @autor Joaquín Rana Pallero */

class Productos {
    public $id;
    public $nombre;
    public $descripcion;
    public $precio;
    public $imagen;
    public $categoria_id;

    /**
     * Guarda el producto en la base de datos (INSERT o UPDATE según corresponda)
     */
    public function guardar() {
        $db = new Database();
        
        // Verificar si ya existe para decidir si insertar o actualizar (opcional, aquí asumo insert simple por la consigna)
        // La consigna pide "insert", usaremos un REPLACE o INSERT simple.
        
        $sql = "INSERT INTO productos (id, nombre, descripcion, precio, imagen, categoria_id) 
                VALUES (:id, :nombre, :descripcion, :precio, :imagen, :categoria_id)
                ON DUPLICATE KEY UPDATE 
                nombre=:nombre, descripcion=:descripcion, precio=:precio, imagen=:imagen, categoria_id=:categoria_id";
        
        $params = [
            ':id' => $this->id,
            ':nombre' => $this->nombre,
            ':descripcion' => $this->descripcion,
            ':precio' => $this->precio,
            ':imagen' => $this->imagen,
            ':categoria_id' => $this->categoria_id
        ];
        
        return $db->insert($sql, $params);
    }

    /**
     * Elimina el producto por su ID
     */
    public function eliminar() {
        $db = new Database();
        $sql = "DELETE FROM productos WHERE id = :id";
        return $db->delete($sql, [':id' => $this->id]);
    }
    
    /**
     * Método estático para listar productos (necesario para el listado)
     */
    public static function listar() {
        $db = new Database();
        $sql = "SELECT p.*, c.nombre as categoria_nombre 
                FROM productos p 
                LEFT JOIN categorias c ON p.categoria_id = c.id";
        return $db->select($sql);
    }
}
?>