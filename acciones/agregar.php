<?php
include("../common/conexion.php");
header('Content-Type: application/json');

$nif = $_POST['nif'] ?? '';
$nombre = $_POST['nombre'] ?? '';
$apellido1 = $_POST['apellido1'] ?? '';
$apellido2 = $_POST['apellido2'] ?? null;
$id_departamento = $_POST['id_departamento'] ?? null;

if (empty($nif) || empty($nombre) || empty($apellido1)) {
    echo json_encode(['status' => 'error', 'message' => 'NIF, Nombre y Apellido 1 son obligatorios']);
    exit;
}

if (empty($id_departamento)) {
    $id_departamento = null;
}

$sql = "INSERT INTO empleado (nif, nombre, apellido1, apellido2, id_departamento) VALUES (?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssssi", $nif, $nombre, $apellido1, $apellido2, $id_departamento);

if ($stmt->execute()) {
    echo json_encode(['status' => 'success', 'message' => 'Empleado agregado correctamente']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Error al agregar: ' . $conn->error]);
}

$stmt->close();
$conn->close();
?>