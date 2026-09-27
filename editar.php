<?php

include("conexion.php");

if (!isset($_GET["id"])) {
    header("Location: index.php");
    exit;
}

$id = $_GET["id"];

$sql = "SELECT * FROM empleado WHERE id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();

$resultado = $stmt->get_result();

if ($resultado->num_rows == 0) {
    header("Location: index.php");
    exit;
}

$empleado = $resultado->fetch_assoc();

?>

<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Editar empleado</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">

</head>

<body>

<div class="container mt-5">

    <div class="card">

        <div class="card-header">
            <h4>Editar empleado</h4>
        </div>

        <div class="card-body">

            <form action="actualizar.php" method="POST">

                <input
                    type="hidden"
                    name="id"
                    value="<?php echo $empleado['id']; ?>">

                <div class="mb-3">

                    <label class="form-label">
                        NIF
                    </label>

                    <input
                        type="text"
                        name="nif"
                        class="form-control"
                        maxlength="9"
                        value="<?php echo htmlspecialchars($empleado['nif']); ?>"
                        required>

                </div>

                <div class="mb-3">

                    <label class="form-label">
                        Nombre
                    </label>

                    <input
                        type="text"
                        name="nombre"
                        class="form-control"
                        value="<?php echo htmlspecialchars($empleado['nombre']); ?>"
                        required>

                </div>

                <div class="mb-3">

                    <label class="form-label">
                        Primer apellido
                    </label>

                    <input
                        type="text"
                        name="apellido1"
                        class="form-control"
                        value="<?php echo htmlspecialchars($empleado['apellido1']); ?>"
                        required>

                </div>

                <div class="mb-3">

                    <label class="form-label">
                        Segundo apellido
                    </label>

                    <input
                        type="text"
                        name="apellido2"
                        class="form-control"
                        value="<?php echo htmlspecialchars($empleado['apellido2'] ?? ''); ?>">

                </div>

                <div class="mb-3">

                    <label class="form-label">
                        Departamento
                    </label>

                    <select
                        name="id_departamento"
                        class="form-select">

                        <option value="">
                            Sin departamento
                        </option>

                        <?php

                        $departamentos = $conn->query(
                            "SELECT id, nombre 
                             FROM departamento 
                             ORDER BY nombre"
                        );

                        while ($departamento = $departamentos->fetch_assoc()) {

                            $seleccionado = (
                                $departamento['id'] == $empleado['id_departamento']
                            ) ? "selected" : "";

                        ?>

                            <option
                                value="<?php echo $departamento['id']; ?>"
                                <?php echo $seleccionado; ?>>

                                <?php echo htmlspecialchars($departamento['nombre']); ?>

                            </option>

                        <?php } ?>

                    </select>

                </div>

                <a
                    href="index.php"
                    class="btn btn-secondary">
                    Cancelar
                </a>

                <button
                    type="submit"
                    class="btn btn-primary">
                    Actualizar
                </button>

            </form>

        </div>

    </div>

</div>

</body>

</html>