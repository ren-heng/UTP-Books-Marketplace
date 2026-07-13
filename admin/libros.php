
<?php
session_start();

if (!isset($_SESSION["rol"]) || $_SESSION["rol"] != "admin") {
    header("Location: ../login.html");
    exit();
}

include "../php/conexion.php";

$resultado = $conexion->query("SELECT * FROM libros");
?>

<!DOCTYPE html>
<html lang="es">

<head>

<meta charset="UTF-8">

<title>Administrar Libros</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body class="bg-light">

<div class="container mt-5">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <h2>Administrar Libros</h2>

        <div>

            <a href="agregar.php" class="btn btn-success">
                ➕ Agregar Libro
            </a>

            <a href="index.php" class="btn btn-secondary">
                ← Volver
            </a>

        </div>

    </div>

    <table class="table table-bordered table-hover bg-white shadow">

        <thead class="table-primary">

            <tr>

                <th>ID</th>

                <th>Imagen</th>

                <th>Nombre</th>

                <th>Autor</th>

                <th>Categoría</th>

                <th>Precio</th>

                <th>Acciones</th>

                

            </tr>

        </thead>

        <tbody>

        <?php while($libro = $resultado->fetch_assoc()) { ?>

            <tr>

                <td><?= $libro["id"] ?></td>

                <td>
                    <img
                        src="../img/<?= $libro["imagen"] ?>"
                        width="70"
                        style="height: 90px; object-fit: cover;"
                        class="rounded shadow-sm"
                        onerror="this.src='https://placehold.co'">
                </td>

                <td><?= $libro["nombre"] ?></td>

                <td><?= $libro["autor"] ?></td>

                <td><?= $libro["categoria"] ?></td>

                <td>S/ <?= number_format($libro["precio"],2) ?></td>

                <td>

                    <a
                        href="editar.php?id=<?= $libro["id"] ?>"
                        class="btn btn-warning btn-sm">

                        Editar

                    </a>

                    <a
                        href="eliminar.php?id=<?= $libro["id"] ?>"
                        class="btn btn-danger btn-sm"
                        onclick="return confirm('¿Eliminar este libro?')">

                        Eliminar

                    </a>

                </td>

            </tr>

        <?php } ?>

        </tbody>

    </table>

</div>

</body>
</html>
