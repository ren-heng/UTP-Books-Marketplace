<?php

header("Content-Type: application/json");

include "conexion.php";

// Leer carrito enviado desde JavaScript
$productos = json_decode(file_get_contents("php://input"), true);

if (!$productos || count($productos) == 0) {

    echo json_encode([
        "success" => false,
        "message" => "El carrito está vacío."
    ]);

    exit;
}

// Calcular total
$total = 0;

foreach ($productos as $item) {

    $id = intval($item["id"]);
    $cantidad = intval($item["qty"]);

    $consulta = $conexion->prepare("SELECT precio FROM libros WHERE id=?");
    $consulta->bind_param("i", $id);
    $consulta->execute();

    $resultado = $consulta->get_result();

    if ($libro = $resultado->fetch_assoc()) {

        $total += $libro["precio"] * $cantidad;

    }

    $consulta->close();

}

$conexion->begin_transaction();

try {

    // Registrar venta
    $venta = $conexion->prepare(
        "INSERT INTO ventas(total)
         VALUES (?)"
    );

    $venta->bind_param("d", $total);
    $venta->execute();

    $ventaId = $conexion->insert_id;

    $venta->close();

    // Registrar detalle
    foreach ($productos as $item) {

        $id = intval($item["id"]);
        $cantidad = intval($item["qty"]);

        $consulta = $conexion->prepare(
            "SELECT precio FROM libros WHERE id=?"
        );

        $consulta->bind_param("i", $id);
        $consulta->execute();

        $resultado = $consulta->get_result();
        $libro = $resultado->fetch_assoc();

        $precio = $libro["precio"];

        $consulta->close();

        $detalle = $conexion->prepare(
            "INSERT INTO detalle_venta
            (venta_id, producto_id, cantidad, precio)
            VALUES (?, ?, ?, ?)"
        );

        $detalle->bind_param(
            "iiid",
            $ventaId,
            $id,
            $cantidad,
            $precio
        );

        $detalle->execute();
        $detalle->close();

    }

    $conexion->commit();

    echo json_encode([
        "success" => true,
        "message" => "Compra registrada correctamente.",
        "venta_id" => $ventaId
    ]);

} catch (Exception $e) {

    $conexion->rollback();

    echo json_encode([
        "success" => false,
        "message" => $e->getMessage()
    ]);

}

$conexion->close();

?>
