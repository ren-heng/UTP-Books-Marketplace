<?php
session_start();

if (!isset($_SESSION["rol"]) || $_SESSION["rol"] != "admin") {
    header("Location: ../login.html");
    exit();
}

include "../php/conexion.php";

// Obtener el ID del libro
if (!isset($_GET["id"])) {
    header("Location: libros.php");
    exit();
}

$id = intval($_GET["id"]);

// Actualizar libro
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nombre = trim($_POST["nombre"]);
    $categoria = trim($_POST["categoria"]);
    $precio = $_POST["precio"];
    $autor = trim($_POST["autor"]);
    $imagen = trim($_POST["imagen"]);
    $descripcion = trim($_POST["descripcion"]);

    $sql = $conexion->prepare("
        UPDATE libros
        SET nombre=?,
            categoria=?,
            precio=?,
            autor=?,
            imagen=?,
            descripcion=?
        WHERE id=?
    ");

    // nombre(s), categoria(s), precio(d), autor(s), imagen(s), descripcion(s), id(i)
    $sql->bind_param(
        "ssdsssi",
        $nombre,
        $categoria,
        $precio,
        $autor,
        $imagen,
        $descripcion,
        $id
    );

    if ($sql->execute()) {
        header("Location: libros.php");
        exit();
    } else {
        $mensaje = "Error al actualizar el libro.";
    }

    $sql->close();
}

// Obtener datos del libro
$sql = $conexion->prepare("SELECT * FROM libros WHERE id=?");
$sql->bind_param("i", $id);
$sql->execute();

$resultado = $sql->get_result();

if ($resultado->num_rows == 0) {
    header("Location: libros.php");
    exit();
}

$libro = $resultado->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="es">

<head>
<meta charset="UTF-8">
<title>Editar Libro</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body class="bg-light">

<div class="container mt-5">

<div class="card shadow">

<div class="card-header bg-warning">

<h3>Editar Libro</h3>

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
value="<?= htmlspecialchars($libro["nombre"]) ?>"
required>
</div>

<div class="mb-3">
<label>Autor</label>
<input
type="text"
name="autor"
class="form-control"
value="<?= htmlspecialchars($libro["autor"]) ?>"
required>
</div>

<div class="mb-3">
<label>Categoría</label>
<input
type="text"
name="categoria"
class="form-control"
value="<?= htmlspecialchars($libro["categoria"]) ?>"
required>
</div>

<div class="mb-3">
<label>Precio</label>
<input
type="number"
step="0.01"
name="precio"
class="form-control"
value="<?= $libro["precio"] ?>"
required>
</div>

<div class="mb-3">
<label>Imagen</label>
<input
type="text"
name="imagen"
class="form-control"
value="<?= htmlspecialchars($libro["imagen"]) ?>"
required>
</div>

<div class="mb-3">
<label>Descripción</label>

<textarea
name="descripcion"
class="form-control"
rows="5"
required><?= htmlspecialchars($libro["descripcion"]) ?></textarea>

</div>

<button class="btn btn-warning">
Guardar Cambios
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
