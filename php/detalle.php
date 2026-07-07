<?php
include("conexion.php");

// Obtener el ID enviado desde la URL
$id = isset($_GET["id"]) ? intval($_GET["id"]) : 0;

// Buscar el libro por su ID
$sql = "SELECT * FROM libros WHERE id = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();

$resultado = $stmt->get_result();

// Devolver el resultado en formato JSON
header("Content-Type: application/json; charset=utf-8");

if ($resultado->num_rows > 0) {
    echo json_encode($resultado->fetch_assoc());
} else {
    echo json_encode(null);
}

$stmt->close();
$conexion->close();
?>
