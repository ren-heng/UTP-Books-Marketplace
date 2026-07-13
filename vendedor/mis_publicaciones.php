<?php
session_start();

if (!isset($_SESSION["id"])) {
    header("Location: ../login.html");
    exit();
}

include("../php/conexion.php");

$usuario_id = $_SESSION["id"];

// Obtener solo los libros del vendedor
$sql = $conexion->prepare("
    SELECT * FROM libros
    WHERE usuario_id = ?
    ORDER BY id DESC
");

$sql->bind_param("i", $usuario_id);
$sql->execute();

$resultado = $sql->get_result();
?>

<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Mis Publicaciones</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

</head>

<body class="bg-light">

    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">

        <div class="container">

            <a class="navbar-brand fw-bold" href="dashboard.php">
                Panel del Vendedor
            </a>

        </div>

    </nav>

    <div class="container mt-5">

        <div class="d-flex justify-content-between mb-4">

            <h2>Mis Publicaciones</h2>

            <a href="publicar.php" class="btn btn-success">

                <i class="bi bi-plus-circle"></i>

                Nuevo Libro

            </a>

        </div>

        <div class="card shadow">

            <div class="card-body">

                <table class="table table-hover align-middle">

                    <thead class="table-primary">

                        <tr>

                            <th>ID</th>

                            <th>Imagen</th>

                            <th>Libro</th>

                            <th>Categoría</th>

                            <th>Precio</th>

                            <th>Acciones</th>

                        </tr>

                    </thead>

                    <tbody>

                        <?php

                        if ($resultado->num_rows > 0) {

                            while ($libro = $resultado->fetch_assoc()) {

                        ?>

                                <tr>

                                    <td><?php echo $libro["id"]; ?></td>

                                    <td>

                                        <img
                                            src="../img/<?php echo $libro["imagen"]; ?>"
                                            width="70"
                                            class="rounded">

                                    </td>

                                    <td>

                                        <strong><?php echo $libro["nombre"]; ?></strong>

                                        <br>

                                        <small><?php echo $libro["autor"]; ?></small>

                                    </td>

                                    <td>

                                        <?php echo $libro["categoria"]; ?>

                                    </td>

                                    <td>

                                        S/ <?php echo number_format($libro["precio"], 2); ?>

                                    </td>

                                    <td>

                                        <a
                                            href="editar_publicacion.php?id=<?php echo $libro["id"]; ?>"
                                            class="btn btn-warning btn-sm">

                                            <i class="bi bi-pencil-square"></i>

                                            Editar

                                        </a>

                                        <a
                                            href="../php/eliminar_libro.php?id=<?php echo $libro["id"]; ?>"
                                            class="btn btn-danger btn-sm"
                                            onclick="return confirm('¿Seguro que deseas eliminar este libro?')">

                                            <i class="bi bi-trash"></i>

                                            Eliminar

                                        </a>

                                    </td>

                                </tr>

                        <?php

                            }

                        } else {

                        ?>

                            <tr>

                                <td colspan="6" class="text-center">

                                    No tienes publicaciones registradas.

                                </td>

                            </tr>

                        <?php

                        }

                        ?>

                    </tbody>

                </table>

            </div>

        </div>

        <div class="mt-4">

            <a href="dashboard.php" class="btn btn-secondary">

                Volver

            </a>

        </div>

    </div>

</body>

</html>