<?php

include("conexion.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $id = $_POST["id"];
    $nif = $_POST["nif"];
    $nombre = $_POST["nombre"];
    $apellido1 = $_POST["apellido1"];
    $apellido2 = !empty($_POST["apellido2"]) 
        ? $_POST["apellido2"] 
        : NULL;

    $id_departamento = !empty($_POST["id_departamento"])
        ? $_POST["id_departamento"]
        : NULL;

    $sql = "UPDATE empleado SET
                nif = ?,
                nombre = ?,
                apellido1 = ?,
                apellido2 = ?,
                id_departamento = ?
            WHERE id = ?";

    $stmt = $conn->prepare($sql);

    $stmt->bind_param(
        "ssssii",
        $nif,
        $nombre,
        $apellido1,
        $apellido2,
        $id_departamento,
        $id
    );

    if ($stmt->execute()) {

        header("Location: index.php");
        exit;

    } else {

        echo "Error al actualizar: " . $conn->error;

    }

    $stmt->close();
}

$conn->close();

?>