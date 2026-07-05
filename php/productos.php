<?php
// Incluimos el archivo de conexión que creamos antes
include 'conexion.php';

// Hacer la consulta para traer todos los libros
$query = "SELECT * FROM libros";
$resultado = $conexion->query($query);

// Crear un arreglo para guardar los datos
$libros = array();

if ($resultado->num_rows > 0) {
    while($fila = $resultado->fetch_assoc()) {
        // Convertir el precio a número flotante para que JavaScript lo lea bien
        $fila['precio'] = floatval($fila['precio']);
        $libros[] = $fila;
    }
}

// Decirle al navegador que enviaremos datos en formato JSON (como un texto estructurado)
header('Content-Type: application/json');

// Mostrar los libros en pantalla convertidos a JSON
echo json_encode($libros, JSON_UNESCAPED_UNICODE);

// Cerrar la conexión
$conexion->close();
?>
