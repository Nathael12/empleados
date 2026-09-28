<?php
include("../common/conexion.php");
header('Content-Type: application/json');

$id = $_POST['id'] ?? null;

if (!$id) {
    echo json_encode(['status' => 'error', 'message' => 'ID no proporcionado']);
    exit;
}

$sql = "DELETE FROM empleado WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    echo json_encode(['status' => 'success', 'message' => 'Empleado eliminado correctamente']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Error al eliminar: ' . $conn->error]);
}

$stmt->close();
$conn->close();
?>