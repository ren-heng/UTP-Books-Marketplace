<?php
session_start();

if (!isset($_SESSION["rol"]) || $_SESSION["rol"] != "admin") {
    header("Location: ../login.html");
    exit();
}

include "../php/conexion.php";

$id = $_GET["id"];

// Evita eliminar al administrador principal
$resultado = $conexion->query("SELECT rol FROM usuarios WHERE id=$id");
$usuario = $resultado->fetch_assoc();

if($usuario && $usuario["rol"] == "admin"){
    echo "<script>
            alert('No se puede eliminar un administrador.');
            window.location='usuarios.php';
          </script>";
    exit();
}

$conexion->query("DELETE FROM usuarios WHERE id=$id");

header("Location: usuarios.php");
exit();
?>
