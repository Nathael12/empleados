<?php
include("../common/conexion.php");
header('Content-Type: application/json');

$id = $_GET['id'] ?? null;

if (!$id) {
    echo json_encode(['status' => 'error', 'message' => 'ID no proporcionado']);
    exit;
}

$sql = "SELECT * FROM empleado WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $empleado = $result->fetch_assoc();
    echo json_encode(['status' => 'success', 'data' => $empleado]);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Empleado no encontrado']);
}

$stmt->close();
$conn->close();
?>