<?php
/* @autor Joaquín Rana Pallero */
require_once '../class/autoload.php';

$lista_categorias = Categorias::listar();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Listado de Categorías</title>
    <link rel="stylesheet" href="../assets/css/estilos.css">
    <style>
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 12px; border-bottom: 1px solid #ddd; text-align: left; }
        th { background-color: var(--accent); color: white; }
        .center-link { text-align: center; margin-top: 20px; }
    </style>
</head>
<body>
    <div class="form-card">
        <div class="header">
            <h1>BitNova Computación</h1>
            <p>Listado de Categorías</p>
        </div>
        <table>
            <thead>
                <tr><th>ID</th><th>Nombre</th></tr>
            </thead>
            <tbody>
                <?php foreach ($lista_categorias as $cat): ?>
                <tr>
                    <td><?php echo $cat->id; ?></td>
                    <td><?php echo $cat->nombre; ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <div class="center-link">
            <a href="categorias.php" class="btn btn-save">Agregar</a>
            <div class="alumno">Alumno: Joaquin Rana Pallero</div>
        </div>
    </div>
</body>
</html>