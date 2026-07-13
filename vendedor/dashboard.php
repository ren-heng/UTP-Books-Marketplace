<?php
session_start();

// Verificar si el usuario inició sesión
if (!isset($_SESSION["id"])) {
    header("Location: ../login.html");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Panel del Vendedor | UTP Books Marketplace</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

</head>

<body class="bg-light">

<!-- NAVBAR -->

<nav class="navbar navbar-expand-lg navbar-dark bg-primary">

    <div class="container">

        <a class="navbar-brand fw-bold" href="../index.html">
            UTP Books Marketplace
        </a>

        <div class="ms-auto">

            <a href="../php/logout.php" class="btn btn-outline-light">

                <i class="bi bi-box-arrow-right"></i>

                Cerrar sesión

            </a>

        </div>

    </div>

</nav>

<!-- CONTENIDO -->

<div class="container mt-5">

    <h2 class="text-center mb-4">

        Panel del Vendedor

    </h2>

    <p class="text-center text-muted">

        Bienvenido. Desde aquí puedes administrar tus publicaciones.

    </p>

    <div class="row mt-5">

        <!-- Publicar Libro -->

        <div class="col-md-6 mb-4">

            <div class="card shadow h-100">

                <div class="card-body text-center">

                    <i class="bi bi-book display-3 text-success"></i>

                    <h4 class="mt-3">

                        Publicar Libro

                    </h4>

                    <p>

                        Registra un nuevo libro para ponerlo a la venta.

                    </p>

                    <a href="publicar.php" class="btn btn-success">

                        Publicar

                    </a>

                </div>

            </div>

        </div>

        <!-- Mis Publicaciones -->

        <div class="col-md-6 mb-4">

            <div class="card shadow h-100">

                <div class="card-body text-center">

                    <i class="bi bi-journal-bookmark-fill display-3 text-primary"></i>

                    <h4 class="mt-3">

                        Mis Publicaciones

                    </h4>

                    <p>

                        Consulta, edita o elimina los libros publicados.

                    </p>

                    <a href="mis_publicaciones.php" class="btn btn-primary">

                        Ver publicaciones

                    </a>

                </div>

            </div>

        </div>

    </div>

</div>

<footer class="text-center mt-5 p-3 bg-white">

    © 2026 UTP Books Marketplace

</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>