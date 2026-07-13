<?php
session_start();

if (!isset($_SESSION["rol"]) || $_SESSION["rol"] != "admin") {
    header("Location: ../login.html");
    exit();
}

include "../php/conexion.php";

if (!isset($_GET["id"])) {
    header("Location: libros.php");
    exit();
}

$id = intval($_GET["id"]);

// Verificar que exista el libro
$sql = $conexion->prepare("SELECT id FROM libros WHERE id = ?");
$sql->bind_param("i", $id);
$sql->execute();
$resultado = $sql->get_result();

if ($resultado->num_rows == 0) {
    header("Location: libros.php");
    exit();
}

$sql->close();

// Eliminar el libro
$sql = $conexion->prepare("DELETE FROM libros WHERE id = ?");
$sql->bind_param("i", $id);

if ($sql->execute()) {
    header("Location: libros.php?mensaje=eliminado");
} else {
    header("Location: libros.php?mensaje=error");
}

$sql->close();
$conexion->close();
exit();
?>
