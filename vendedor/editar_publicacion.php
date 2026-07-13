<?php
session_start();

if (!isset($_SESSION["id"])) {
    header("Location: ../login.html");
    exit();
}

include("../php/conexion.php");

$id = isset($_GET["id"]) ? intval($_GET["id"]) : 0;
$usuario_id = $_SESSION["id"];

// Buscar el libro del usuario
$sql = $conexion->prepare("
    SELECT * FROM libros
    WHERE id = ? AND usuario_id = ?
");

$sql->bind_param("ii", $id, $usuario_id);
$sql->execute();

$resultado = $sql->get_result();

if ($resultado->num_rows == 0) {
    die("Libro no encontrado.");
}

$libro = $resultado->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Editar Publicación</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

</head>

<body class="bg-light">

    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">

        <div class="container">

            <a class="navbar-brand" href="dashboard.php">

                Panel del Vendedor

            </a>

        </div>

    </nav>

    <div class="container mt-5">

        <div class="card shadow">

            <div class="card-header bg-warning">

                <h3>

                    <i class="bi bi-pencil-square"></i>

                    Editar Publicación

                </h3>

            </div>

            <div class="card-body">

                <form action="../php/actualizar_libro.php" method="POST">

                    <input
                        type="hidden"
                        name="id"
                        value="<?php echo $libro["id"]; ?>">

                    <div class="mb-3">

                        <label>Nombre</label>

                        <input
                            type="text"
                            name="nombre"
                            class="form-control"
                            value="<?php echo $libro["nombre"]; ?>"
                            required>

                    </div>

                    <div class="mb-3">

                        <label>Autor</label>

                        <input
                            type="text"
                            name="autor"
                            class="form-control"
                            value="<?php echo $libro["autor"]; ?>"
                            required>

                    </div>

                    <div class="mb-3">

                        <label>Categoría</label>

                        <input
                            type="text"
                            name="categoria"
                            class="form-control"
                            value="<?php echo $libro["categoria"]; ?>"
                            required>

                    </div>

                    <div class="mb-3">

                        <label>Precio</label>

                        <input
                            type="number"
                            step="0.01"
                            name="precio"
                            class="form-control"
                            value="<?php echo $libro["precio"]; ?>"
                            required>

                    </div>

                    <div class="mb-3">

                        <label>Imagen</label>

                        <input
                            type="text"
                            name="imagen"
                            class="form-control"
                            value="<?php echo $libro["imagen"]; ?>"
                            required>

                    </div>

                    <div class="mb-3">

                        <label>Descripción</label>

                        <textarea
                            name="descripcion"
                            rows="5"
                            class="form-control"
                            required><?php echo $libro["descripcion"]; ?></textarea>

                    </div>

                    <button
                        type="submit"
                        class="btn btn-warning">

                        <i class="bi bi-save"></i>

                        Guardar Cambios

                    </button>

                    <a
                        href="mis_publicaciones.php"
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