<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();


include "conexion.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $correo = trim($_POST["correo"]);
    $password = trim($_POST["password"]);

    $sql = $conexion->prepare("SELECT * FROM usuarios WHERE correo = ?");
    $sql->bind_param("s", $correo);
    $sql->execute();

    $resultado = $sql->get_result();

    if ($resultado->num_rows == 1) {

        $usuario = $resultado->fetch_assoc();

        // Por ahora usamos contraseña en texto plano
        if ($password == $usuario["password"]) {

            $_SESSION["id"] = $usuario["id"];
            $_SESSION["nombre"] = $usuario["nombre"];
            $_SESSION["rol"] = $usuario["rol"];

            if ($usuario["rol"] == "admin") {

                header("Location: ../admin/index.php");

            } else {

                header("Location: ../index.html");

            }

            exit();

        } else {

            echo "<script>
                    alert('Contraseña incorrecta');
                    window.location='../login.html';
                  </script>";

        }

    } else {

        echo "<script>
                alert('El usuario no existe');
                window.location='../login.html';
              </script>";

    }

    $sql->close();
}

$conexion->close();
?>
