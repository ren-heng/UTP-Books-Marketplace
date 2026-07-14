<?php
session_start();

if (!isset($_SESSION["rol"]) || $_SESSION["rol"] != "admin") {
    header("Location: ../login.html");
    exit();
}

include "../php/conexion.php";

$id = $_GET["id"];

if(isset($_POST["guardar"])){

    $nombre = $_POST["nombre"];
    $correo = $_POST["correo"];
    $rol = $_POST["rol"];

    $sql = "UPDATE usuarios
            SET nombre='$nombre',
                correo='$correo',
                rol='$rol'
            WHERE id=$id";

    $conexion->query($sql);

    header("Location: usuarios.php");
    exit();
}

$resultado = $conexion->query("SELECT * FROM usuarios WHERE id=$id");
$usuario = $resultado->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="es">

<head>

<meta charset="UTF-8">

<title>Editar Usuario</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body class="bg-light">

<div class="container mt-5">

<div class="card shadow">

<div class="card-header bg-warning">

<h3>Editar Usuario</h3>

</div>

<div class="card-body">

<form method="POST">

<div class="mb-3">

<label>Nombre</label>

<input
type="text"
name="nombre"
class="form-control"
value="<?= $usuario["nombre"] ?>"
required>

</div>

<div class="mb-3">

<label>Correo</label>

<input
type="email"
name="correo"
class="form-control"
value="<?= $usuario["correo"] ?>"
required>

</div>

<div class="mb-3">

<label>Rol</label>

<select
name="rol"
class="form-select">

<option value="admin"
<?= $usuario["rol"]=="admin" ? "selected" : "" ?>>
Administrador
</option>

<option value="cliente"
<?= $usuario["rol"]=="cliente" ? "selected" : "" ?>>
Cliente
</option>

<option value="vendedor"
<?= $usuario["rol"]=="vendedor" ? "selected" : "" ?>>
Vendedor
</option>

</select>

</div>

<button
type="submit"
name="guardar"
class="btn btn-success">

Guardar Cambios

</button>

<a
href="usuarios.php"
class="btn btn-secondary">

Cancelar

</a>

</form>

</div>

</div>

</div>

</body>

</html>
