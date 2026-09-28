<?php
include("../common/conexion.php");
header('Content-Type: application/json');

$id = $_POST['id'] ?? null;
$nif = $_POST['nif'] ?? '';
$nombre = $_POST['nombre'] ?? '';
$apellido1 = $_POST['apellido1'] ?? '';
$apellido2 = $_POST['apellido2'] ?? null;
$id_departamento = $_POST['id_departamento'] ?? null;

if (empty($id) || empty($nif) || empty($nombre) || empty($apellido1)) {
    echo json_encode(['status' => 'error', 'message' => 'Los campos obligatorios no pueden estar vacíos']);
    exit;
}

if (empty($id_departamento)) {
    $id_departamento = null;
}

$sql = "UPDATE empleado SET nif = ?, nombre = ?, apellido1 = ?, apellido2 = ?, id_departamento = ? WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssssii", $nif, $nombre, $apellido1, $apellido2, $id_departamento, $id);

if ($stmt->execute()) {
    echo json_encode(['status' => 'success', 'message' => 'Empleado actualizado correctamente']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Error al actualizar: ' . $conn->error]);
}

$stmt->close();
$conn->close();
?>