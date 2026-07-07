
<?php
header("Content-Type: application/json");

include "conexion.php";

// Leer los datos enviados desde JavaScript
$datos = json_decode(file_get_contents("php://input"), true);

if (!$datos || !isset($datos["productos"])) {
    echo json_encode([
        "ok" => false,
        "mensaje" => "No se recibieron productos."
    ]);
    exit;
}

$productos = $datos["productos"];
$metodoPago = $datos["metodo_pago"];

// Calcular el total
$total = 0;

foreach ($productos as $item) {

    $id = intval($item["id"]);
    $cantidad = intval($item["cantidad"]);

    $consulta = $conexion->prepare("SELECT precio FROM libros WHERE id=?");
    $consulta->bind_param("i", $id);
    $consulta->execute();

    $resultado = $consulta->get_result();

    if ($fila = $resultado->fetch_assoc()) {

        $total += $fila["precio"] * $cantidad;

    }

    $consulta->close();
}

// Iniciar transacción
$conexion->begin_transaction();

try {

    // Registrar venta
    $sqlVenta = $conexion->prepare(
        "INSERT INTO ventas(total, metodo_pago)
         VALUES (?, ?)"
    );

    $sqlVenta->bind_param("ds", $total, $metodoPago);
    $sqlVenta->execute();

    $ventaId = $conexion->insert_id;

    // Registrar detalle
    foreach ($productos as $item) {

        $id = intval($item["id"]);
        $cantidad = intval($item["cantidad"]);

        $consulta = $conexion->prepare(
            "SELECT precio FROM libros WHERE id=?"
        );

        $consulta->bind_param("i", $id);
        $consulta->execute();

        $resultado = $consulta->get_result();
        $libro = $resultado->fetch_assoc();

        $precio = $libro["precio"];
        $subtotal = $precio * $cantidad;

        $detalle = $conexion->prepare(
            "INSERT INTO detalle_venta
            (venta_id, libro_id, cantidad, precio_unitario, subtotal)
            VALUES (?, ?, ?, ?, ?)"
        );

        $detalle->bind_param(
            "iiidd",
            $ventaId,
            $id,
            $cantidad,
            $precio,
            $subtotal
        );

        $detalle->execute();

        $detalle->close();
        $consulta->close();
    }

    $conexion->commit();

    echo json_encode([
        "ok" => true,
        "mensaje" => "Compra registrada correctamente.",
        "venta_id" => $ventaId
    ]);

} catch (Exception $e) {

    $conexion->rollback();

    echo json_encode([
        "ok" => false,
        "mensaje" => "Error al registrar la compra.",
        "error" => $e->getMessage()
    ]);
}

$conexion->close();
?>
