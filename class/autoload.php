<?php
/* @autor Joaquín Rana Pallero */
spl_autoload_register(function ($clase) {
    if (file_exists(__DIR__ . '/' . $clase . '.php')) {
        include_once __DIR__ . '/' . $clase . '.php';
    }
});
?>