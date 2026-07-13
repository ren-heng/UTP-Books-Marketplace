<?php
session_start();

if (!isset($_SESSION["id"])) {
    header("Location: ../login.html");
    exit();
}

include("../php/conexion.php");

$id = isset($_GET["id"]) ? intval($_GET["id"]) : 0;
$usuario_id = $_SESSION["id"];

// Eliminar únicamente si el libro pertenece al vendedor
$sql = $conexion->prepare("
    DELETE FROM libros
    WHERE id = ? AND usuario_id = ?
");

$sql->bind_param("ii", $id, $usuario_id);

if ($sql->execute()) {

    header("Location: mis_publicaciones.php");

} else {

    echo "Error al eliminar la publicación.";

}

$sql->close();

$conexion->close();
?>