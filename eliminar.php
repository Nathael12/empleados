<?php

include("conexion.php");

if (isset($_GET["id"])) {

    $id = $_GET["id"];

    $sql = "DELETE FROM empleado WHERE id = ?";

    $stmt = $conn->prepare($sql);

    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {

        header("Location: index.php");
        exit;

    } else {

        echo "Error al eliminar el empleado: " . $conn->error;

    }

    $stmt->close();
}

$conn->close();

?>