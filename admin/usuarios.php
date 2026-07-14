<?php
session_start();

if (!isset($_SESSION["rol"]) || $_SESSION["rol"] != "admin") {
    header("Location: ../login.html");
    exit();
}

include "../php/conexion.php";

$resultado = $conexion->query("SELECT id, nombre, correo, rol FROM usuarios ORDER BY id ASC");
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrar Usuarios</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container mt-5">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <h2>👤 Administrar Usuarios</h2>

        <a href="index.php" class="btn btn-secondary">
            ← Volver al Panel
        </a>

    </div>

    <table class="table table-bordered table-hover table-striped shadow bg-white">

        <thead class="table-dark">

            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Correo</th>
                <th>Rol</th>
                <th width="180">Acciones</th>
            </tr>

        </thead>

        <tbody>

       <?php while($usuario = $resultado->fetch_assoc()) { ?> <tr> <td><?= $usuario["id"] ?></td> <td><?= $usuario["nombre"] ?></td> <td><?= $usuario["correo"] ?></td> <td><?= $usuario["rol"] ?></td> <td> <a href="editar_usuario.php?id=<?= $usuario["id"] ?>" class="btn btn-warning btn-sm"> Editar </a> <a href="eliminar_usuario.php?id=<?= $usuario["id"] ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Eliminar usuario?')"> Eliminar </a> </td> </tr> <?php } ?>

        </tbody>

    </table>

</div>

</body>
</html>
