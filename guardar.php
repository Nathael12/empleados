<?php

include("conexion.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nif = $_POST["nif"];
    $nombre = $_POST["nombre"];
    $apellido1 = $_POST["apellido1"];
    $apellido2 = !empty($_POST["apellido2"]) ? $_POST["apellido2"] : NULL;
    $id_departamento = !empty($_POST["id_departamento"]) 
        ? $_POST["id_departamento"] 
        : NULL;

    $sql = "INSERT INTO empleado 
            (nif, nombre, apellido1, apellido2, id_departamento)
            VALUES (?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);

    $stmt->bind_param(
        "ssssi",
        $nif,
        $nombre,
        $apellido1,
        $apellido2,
        $id_departamento
    );

    if ($stmt->execute()) {
        header("Location: index.php");
        exit;
    } else {
        echo "Error al guardar el empleado: " . $conn->error;
    }

    $stmt->close();
}

$conn->close();

?>