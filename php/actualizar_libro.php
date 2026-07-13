<?php
session_start();

if (!isset($_SESSION["id"])) {
    header("Location: ../login.html");
    exit();
}

include("conexion.php");

$usuario_id = $_SESSION["id"];

// Datos del formulario
$id = intval($_POST["id"]);
$nombre = trim($_POST["nombre"]);
$autor = trim($_POST["autor"]);
$categoria = trim($_POST["categoria"]);
$precio = $_POST["precio"];
$imagen = trim($_POST["imagen"]);
$descripcion = trim($_POST["descripcion"]);

// Actualizar únicamente si el libro pertenece al usuario
$sql = $conexion->prepare("
UPDATE libros
SET
    nombre = ?,
    autor = ?,
    categoria = ?,
    precio = ?,
    imagen = ?,
    descripcion = ?
WHERE
    id = ?
AND
    usuario_id = ?
");

$sql->bind_param(
    "sssdssii",
    $nombre,
    $autor,
    $categoria,
    $precio,
    $imagen,
    $descripcion,
    $id,
    $usuario_id
);

if ($sql->execute()) {

    header("Location: ../vendedor/mis_publicaciones.php");
    exit();

} else {

    echo "Error al actualizar el libro.";

}

$sql->close();
$conexion->close();

?>