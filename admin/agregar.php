
<?php
session_start();

if (!isset($_SESSION["rol"]) || $_SESSION["rol"] != "admin") {
    header("Location: ../login.html");
    exit();
}

include "../php/conexion.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nombre = trim($_POST["nombre"]);
    $autor = trim($_POST["autor"]);
    $categoria = trim($_POST["categoria"]);
    $precio = $_POST["precio"];
    $imagen = trim($_POST["imagen"]);

    $sql = $conexion->prepare("
        INSERT INTO libros
        (nombre, autor, categoria, precio, imagen)
        VALUES (?, ?, ?, ?, ?)
    ");

    $sql->bind_param(
        "sssds",
        $nombre,
        $autor,
        $categoria,
        $precio,
        $imagen
    );

    if ($sql->execute()) {

        header("Location: libros.php");
        exit();

    } else {

        $mensaje = "Error al guardar el libro.";

    }

    $sql->close();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>

<meta charset="UTF-8">

<title>Agregar Libro</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body class="bg-light">

<div class="container mt-5">

<div class="card shadow">

<div class="card-header bg-success text-white">

<h3>Agregar Libro</h3>

</div>

<div class="card-body">

<?php
if(isset($mensaje)){
    echo "<div class='alert alert-danger'>$mensaje</div>";
}
?>

<form method="POST">

<div class="mb-3">

<label>Nombre</label>

<input
type="text"
name="nombre"
class="form-control"
required>

</div>

<div class="mb-3">

<label>Autor</label>

<input
type="text"
name="autor"
class="form-control"
required>

</div>

<div class="mb-3">

<label>Categoría</label>

<input
type="text"
name="categoria"
class="form-control"
required>

</div>

<div class="mb-3">

<label>Precio</label>

<input
type="number"
step="0.01"
name="precio"
class="form-control"
required>

</div>

<div class="mb-3">

<label>Nombre de la imagen</label>

<input
type="text"
name="imagen"
class="form-control"
placeholder="clean code.jpg"
required>

<small class="text-muted">
La imagen debe existir en la carpeta <strong>img</strong>.
</small>

</div>

<button class="btn btn-success">

Guardar Libro

</button>

<a href="libros.php" class="btn btn-secondary">

Cancelar

</a>

</form>

</div>

</div>

</div>

</body>

</html>
