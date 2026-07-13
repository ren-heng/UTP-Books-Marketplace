<?php
session_start();

if (!isset($_SESSION["id"])) {
    header("Location: ../login.html");
    exit();
}

include("conexion.php");

// Obtener el usuario que inició sesión
$usuario_id = $_SESSION["id"];

// Recibir datos del formulario
$nombre = trim($_POST["nombre"]);
$autor = trim($_POST["autor"]);
$categoria = trim($_POST["categoria"]);
$precio = $_POST["precio"];
$imagen = trim($_POST["imagen"]);
$descripcion = trim($_POST["descripcion"]);

// Insertar libro
$sql = $conexion->prepare("
INSERT INTO libros
(nombre,autor,categoria,precio,imagen,descripcion,usuario_id)
VALUES (?,?,?,?,?,?,?)
");

$sql->bind_param(
    "sssdssi",
    $nombre,
    $autor,
    $categoria,
    $precio,
    $imagen,
    $descripcion,
    $usuario_id
);

if($sql->execute()){

    header("Location: ../vendedor/mis_publicaciones.php");

}else{

    echo "Error al publicar el libro.";

}

$sql->close();
$conexion->close();
?>