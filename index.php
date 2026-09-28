<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD Empleados</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="css/estilos.css">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Gestión de Empleados</h2>
        <button type="button" class="btn btn-primary" id="btnAgregar">
            Agregar Empleado
        </button>
    </div>

    <div class="mb-3">
        <input type="text" id="buscador" class="form-control" placeholder="Buscar por NIF, nombre, apellido o departamento...">
    </div>

    <div class="card shadow">
        <div class="card-body">
            <table class="table table-hover table-striped" id="tablaEmpleados">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>NIF</th>
                        <th>Nombre</th>
                        <th>Apellido 1</th>
                        <th>Apellido 2</th>
                        <th>Departamento</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    include("common/conexion.php");
                    $sql = "SELECT e.*, d.nombre AS departamento_nombre 
                            FROM empleado e 
                            LEFT JOIN departamento d ON e.id_departamento = d.id";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) { ?>
                            <tr id="fila-<?= $row['id'] ?>">
                                <td><?= $row['id'] ?></td>
                                <td><?= $row['nif'] ?></td>
                                <td><?= $row['nombre'] ?></td>
                                <td><?= $row['apellido1'] ?></td>
                                <td><?= $row['apellido2'] ?? '' ?></td>
                                <td><?= $row['departamento_nombre'] ?? 'Sin asignar' ?></td>
                                <td>
                                    <button class="btn btn-warning btn-sm btnEditar" data-id="<?= $row['id'] ?>">
                                        Editar
                                    </button>
                                    <button class="btn btn-danger btn-sm btnEliminar" data-id="<?= $row['id'] ?>">
                                        Eliminar
                                    </button>
                                </td>
                            </tr>
                        <?php }
                    } else {
                        echo "<tr><td colspan='7' class='text-center'>No hay empleados registrados</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="modalAgregar" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Agregar Empleado</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formAgregar">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="nif" class="form-label">NIF</label>
                        <input type="text" class="form-control" id="nif" name="nif" required>
                    </div>
                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" required>
                    </div>
                    <div class="mb-3">
                        <label for="apellido1" class="form-label">Apellido 1</label>
                        <input type="text" class="form-control" id="apellido1" name="apellido1" required>
                    </div>
                    <div class="mb-3">
                        <label for="apellido2" class="form-label">Apellido 2</label>
                        <input type="text" class="form-control" id="apellido2" name="apellido2">
                    </div>
                    <div class="mb-3">
                        <label for="id_departamento" class="form-label">Departamento</label>
                        <select class="form-select" id="id_departamento" name="id_departamento">
                            <option value="">Seleccione un departamento</option>
                            <?php
                            $departamentos = $conn->query("SELECT id, nombre FROM departamento");
                            while($dep = $departamentos->fetch_assoc()) {
                                echo "<option value='{$dep['id']}'>{$dep['nombre']}</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modalEditar" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-warning text-dark">
                <h5 class="modal-title">Editar Empleado</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formEditar">
                <div class="modal-body">
                    <input type="hidden" name="id" id="editId">
                    <div class="mb-3">
                        <label for="editNif" class="form-label">NIF</label>
                        <input type="text" class="form-control" id="editNif" name="nif" required>
                    </div>
                    <div class="mb-3">
                        <label for="editNombre" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="editNombre" name="nombre" required>
                    </div>
                    <div class="mb-3">
                        <label for="editApellido1" class="form-label">Apellido 1</label>
                        <input type="text" class="form-control" id="editApellido1" name="apellido1" required>
                    </div>
                    <div class="mb-3">
                        <label for="editApellido2" class="form-label">Apellido 2</label>
                        <input type="text" class="form-control" id="editApellido2" name="apellido2">
                    </div>
                    <div class="mb-3">
                        <label for="editDepartamento" class="form-label">Departamento</label>
                        <select class="form-select" id="editDepartamento" name="id_departamento">
                            <option value="">Seleccione un departamento</option>
                            <?php
                            $departamentos2 = $conn->query("SELECT id, nombre FROM departamento");
                            while($dep2 = $departamentos2->fetch_assoc()) {
                                echo "<option value='{$dep2['id']}'>{$dep2['nombre']}</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-warning">Actualizar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="js/empleados.js"></script>

</body>
</html>