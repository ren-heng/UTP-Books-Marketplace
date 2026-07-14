<?php
// Reporte de errores por seguridad en desarrollo
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Importamos la conexión a la base de datos
include "conexion.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = trim($_POST["nombre"]);
    $correo = trim($_POST["correo"]);
    $password = trim($_POST["password"]);

    // 1. Verificamos si el correo ya existe en MySQL para no duplicarlo
    $buscar = $conexion->prepare("SELECT id FROM usuarios WHERE correo = ?");
    $buscar->bind_param("s", $correo);
    $buscar->execute();
    $resultado = $buscar->get_result();

    if ($resultado->num_rows > 0) {
        // Alerta si el correo ya está registrado
        echo "<script>
                alert('Error: Este correo ya se encuentra registrado.');
                window.location='../login.html';
              </script>";
    } else {
        // 2. Insertamos el nuevo usuario como 'cliente' por defecto
        $insertar = $conexion->prepare("INSERT INTO usuarios (nombre, correo, password, rol) VALUES (?, ?, ?, 'cliente')");
        $insertar->bind_param("sss", $nombre, $correo, $password);

        if ($insertar->execute()) {
            // Alerta de éxito total
            echo "<script>
                    alert('¡Cuenta creada con éxito! Ya puedes iniciar sesión.');
                    window.location='../login.html';
                  </script>";
        } else {
            // Alerta si ocurre un fallo en el servidor
            echo "<script>
                    alert('Hubo un error al registrar la cuenta.');
                    window.location='../login.html';
                  </script>";
        }
        $insertar->close();
    }
    $buscar->close();
}

$conexion->close();
?>
