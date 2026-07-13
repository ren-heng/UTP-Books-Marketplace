<?php
session_start();

if (!isset($_SESSION["id"])) {
    header("Location: ../login.html");
    exit();
}

include("conexion.php");

$usuario_id = $_SESSION["id"];

// Obtener el ID del libro
$id = isset($_GET["id"]) ? intval($_GET["id"]) : 0;

// Eliminar únicamente si pertenece al usuario que inició sesión
$sql = $conexion->prepare("
DELETE FROM libros
WHERE id = ? AND usuario_id = ?
");

$sql->bind_param("ii", $id, $usuario_id);

if ($sql->execute()) {

    header("Location: ../vendedor/mis_publicaciones.php");
    exit();

} else {

    echo "Error al eliminar el libro.";

}

$sql->close();
$conexion->close();
?>