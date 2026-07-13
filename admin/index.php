
<?php
session_start();

if (!isset($_SESSION["rol"]) || $_SESSION["rol"] != "admin") {
    header("Location: ../login.html");
    exit();
}
    include "../php/conexion.php";
// Total de libros
$totalLibros = $conexion->query("SELECT COUNT(*) AS total FROM libros")
                        ->fetch_assoc()["total"];

// Total de ventas
$totalVentas = $conexion->query("SELECT COUNT(*) AS total FROM ventas")
                        ->fetch_assoc()["total"];

// Total de ingresos
$ingresos = $conexion->query("SELECT SUM(total) AS total FROM ventas")
                     ->fetch_assoc()["total"];

$ingresos = $ingresos ? $ingresos : 0;

// Total de usuarios
$totalUsuarios = $conexion->query("SELECT COUNT(*) AS total FROM usuarios")
                          ->fetch_assoc()["total"];

   
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administración</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<!-- NAVBAR -->
<nav class="navbar navbar-dark bg-dark shadow">
    <div class="container-fluid">
        <span class="navbar-brand mb-0 h1">
            📚 UTP Books Marketplace | Panel Administrador
        </span>

        <div>
            <span class="text-white me-3">
                Bienvenido, <strong><?php echo $_SESSION["nombre"]; ?></strong>
            </span>

            <a href="../index.html" class="btn btn-outline-light btn-sm">
                Ir a la tienda
            </a>

            <a href="../php/logout.php" class="btn btn-danger btn-sm">
                Cerrar sesión
            </a>
        </div>
    </div>
</nav>

<div class="container py-5">

    <!-- TÍTULO -->
    <div class="text-center mb-5">
        <h2>Dashboard</h2>
        <p class="text-muted">
            Panel de Administración de UTP Books Marketplace
        </p>
    </div>

    <!-- TARJETAS -->
    <div class="row g-4">

        <div class="col-md-3">
            <div class="card shadow border-0 text-center">
                <div class="card-body">
                    <h5>📚 Libros</h5>
                    <h2 id="totalLibros">0</h2>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow border-0 text-center">
                <div class="card-body">
                    <h5>🛒 Ventas</h5>
                    <h2 id="totalVentas">0</h2>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow border-0 text-center">
                <div class="card-body">
                    <h5>💰 Ingresos</h5>
                    <h2 id="totalIngresos">S/ 0.00</h2>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow border-0 text-center">
                <div class="card-body">
                    <h5>👤 Usuarios</h5>
                    <h2 id="totalUsuarios">0</h2>
                </div>
            </div>
        </div>

    </div>

    <!-- ACCIONES -->
    <div class="card shadow mt-5 border-0">
        <div class="card-header bg-primary text-white">
            Acciones rápidas
        </div>

        <div class="card-body text-center">

            <a href="libros.php" class="btn btn-primary btn-lg m-2">
                📚 Gestionar Libros
            </a>

            <a href="ventas.php" class="btn btn-success btn-lg m-2">
                🛒 Ver Ventas
            </a>

            <a href="usuarios.php" class="btn btn-warning btn-lg m-2">
                👤 Gestionar Usuarios
            </a>

        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
