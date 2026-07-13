
<?php
session_start();

if (!isset($_SESSION["rol"]) || $_SESSION["rol"] != "admin") {
    http_response_code(403);
    echo json_encode(["error" => "Acceso denegado"]);
    exit();
}

header("Content-Type: application/json");

include "../php/conexion.php";

try {

    // Total de libros
    $libros = $conexion->query("SELECT COUNT(*) AS total FROM libros");
    $totalLibros = $libros->fetch_assoc()["total"];

    // Total de ventas
    $ventas = $conexion->query("SELECT COUNT(*) AS total FROM ventas");
    $totalVentas = $ventas->fetch_assoc()["total"];

    // Total de ingresos
    $ingresos = $conexion->query("SELECT IFNULL(SUM(total),0) AS total FROM ventas");
    $totalIngresos = $ingresos->fetch_assoc()["total"];

    // Total de usuarios
    $usuarios = $conexion->query("SELECT COUNT(*) AS total FROM usuarios");
    $totalUsuarios = $usuarios->fetch_assoc()["total"];

    echo json_encode([
        "libros" => (int)$totalLibros,
        "ventas" => (int)$totalVentas,
        "ingresos" => (float)$totalIngresos,
        "usuarios" => (int)$totalUsuarios
    ]);

} catch (Exception $e) {

    echo json_encode([
        "error" => $e->getMessage()
    ]);

}

$conexion->close();
?>
