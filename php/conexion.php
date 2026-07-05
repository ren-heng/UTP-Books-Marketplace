<?php
// Configuración de la conexión a la base de datos
$host = "localhost";
$user = "root";
$password = "123456"; // Si pusiste contraseña al instalar MySQL, escríbela aquí adentro
$database = "utp_books";
$port = 3306;   // El puerto por defecto que usa tu MySQL

// Crear la conexión
$conexion = new mysqli($host, $user, $password, $database, $port);

// Verificar si hay algún error en la conexión
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Configurar los caracteres para que se lean bien las tildes y la ñ
$conexion->set_charset("utf8");
?>