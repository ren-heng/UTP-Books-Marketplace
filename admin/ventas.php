
<?php
session_start();

if (!isset($_SESSION["rol"]) || $_SESSION["rol"] != "admin") {
    header("Location: ../login.html");
    exit();
}

include "../php/conexion.php";

$resultado = $conexion->query("SELECT * FROM ventas ORDER BY fecha DESC");
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Historial de Ventas</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container mt-5">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <h2>🛒 Historial de Ventas</h2>

        <a href="index.php" class="btn btn-secondary">
            ← Volver
        </a>

    </div>

    <table class="table table-bordered table-hover shadow bg-white">

        <thead class="table-success">

            <tr>

                <th>ID</th>

                <th>Fecha</th>

                <th>Método de Pago</th>

                <th>Total</th>

            </tr>

        </thead>

        <tbody>

        <?php while($venta = $resultado->fetch_assoc()) { ?>

            <tr>

                <td><?= $venta["id"] ?></td>

                <td><?= $venta["fecha"] ?></td>

                <td><?= $venta["metodo_pago"] ?></td>

                <td>S/ <?= number_format($venta["total"],2) ?></td>

            </tr>

        <?php } ?>

        </tbody>

    </table>

</div>

</body>
</html>
