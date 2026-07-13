<?php
session_start();

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

    <title>Publicar Libro | UTP Books Marketplace</title>

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

    <div class="card shadow">

        <div class="card-header bg-success text-white">

            <h3>

                <i class="bi bi-book"></i>

                Publicar Libro

            </h3>

        </div>

        <div class="card-body">

            <form action="../php/guardar_libro.php" method="POST">

                <div class="mb-3">

                    <label class="form-label">

                        Nombre del libro

                    </label>

                    <input
                        type="text"
                        name="nombre"
                        class="form-control"
                        required>

                </div>

                <div class="mb-3">

                    <label class="form-label">

                        Autor

                    </label>

                    <input
                        type="text"
                        name="autor"
                        class="form-control"
                        required>

                </div>

                <div class="mb-3">

                    <label class="form-label">

                        Categoría

                    </label>

                    <select
                        name="categoria"
                        class="form-select"
                        required>

                        <option value="">Seleccione</option>
                        <option>Programación</option>
                        <option>Base de Datos</option>
                        <option>Sistemas</option>
                        <option>Matemáticas</option>
                        <option>Física</option>
                        <option>Redes</option>
                        <option>Estadísticas</option>

                    </select>

                </div>

                <div class="mb-3">

                    <label class="form-label">

                        Precio

                    </label>

                    <input
                        type="number"
                        step="0.01"
                        name="precio"
                        class="form-control"
                        required>

                </div>

                <div class="mb-3">

                    <label class="form-label">

                        Nombre de la imagen

                    </label>

                    <input
                        type="text"
                        name="imagen"
                        class="form-control"
                        placeholder="ejemplo.jpg"
                        required>

                    <small class="text-muted">

                        La imagen debe existir dentro de la carpeta <strong>img</strong>.

                    </small>

                </div>

                <div class="mb-3">

                    <label class="form-label">

                        Descripción

                    </label>

                    <textarea
                        name="descripcion"
                        rows="5"
                        class="form-control"
                        required></textarea>

                </div>

                <button
                    type="submit"
                    class="btn btn-success">

                    <i class="bi bi-check-circle"></i>

                    Publicar Libro

                </button>

                <a
                    href="dashboard.php"
                    class="btn btn-secondary">

                    Cancelar

                </a>

            </form>

        </div>

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>