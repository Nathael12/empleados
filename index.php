<?php

include("conexion.php");

// Obtener empleados junto con su departamento
$sql = "SELECT 
            e.id,
            e.nif,
            e.nombre,
            e.apellido1,
            e.apellido2,
            d.nombre AS departamento
        FROM empleado e
        LEFT JOIN departamento d 
            ON e.id_departamento = d.id
        ORDER BY e.id ASC";

$resultado = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Gestión de Empleados</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body>

<div class="container mt-5">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Gestión de Empleados</h2>

        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalAgregar">
            + Agregar empleado
        </button>
    </div>


    <div class="table-responsive">

        <table class="table table-bordered table-striped align-middle">

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

                <?php while ($empleado = $resultado->fetch_assoc()) { ?>

                    <tr>

                        <td><?php echo $empleado['id']; ?></td>

                        <td><?php echo $empleado['nif']; ?></td>

                        <td><?php echo $empleado['nombre']; ?></td>

                        <td><?php echo $empleado['apellido1']; ?></td>

                        <td>
                            <?php echo $empleado['apellido2'] ?? ''; ?>
                        </td>

                        <td>
                            <?php echo $empleado['departamento'] ?? 'Sin departamento'; ?>
                        </td>

                        <td>

                            <a href="editar.php?id=<?php echo $empleado['id']; ?>"
                               class="btn btn-warning btn-sm">
                                Editar
                            </a>

                            <a href="eliminar.php?id=<?php echo $empleado['id']; ?>"
                               class="btn btn-danger btn-sm"
                               onclick="return confirm('¿Seguro que deseas eliminar este empleado?');">
                                Eliminar
                            </a>

                        </td>

                    </tr>

                <?php } ?>

            </tbody>

        </table>

    </div>

</div>


<!-- Modal Agregar -->

<div class="modal fade" id="modalAgregar" tabindex="-1">

    <div class="modal-dialog">

        <div class="modal-content">

            <div class="modal-header">

                <h5 class="modal-title">
                    Agregar empleado
                </h5>

                <button type="button"
                        class="btn-close"
                        data-bs-dismiss="modal">
                </button>

            </div>


            <form action="guardar.php" method="POST">

                <div class="modal-body">

                    <div class="mb-3">

                        <label class="form-label">
                            NIF
                        </label>

                        <input type="text"
                               name="nif"
                               class="form-control"
                               maxlength="9"
                               required>

                    </div>


                    <div class="mb-3">

                        <label class="form-label">
                            Nombre
                        </label>

                        <input type="text"
                               name="nombre"
                               class="form-control"
                               required>

                    </div>


                    <div class="mb-3">

                        <label class="form-label">
                            Primer apellido
                        </label>

                        <input type="text"
                               name="apellido1"
                               class="form-control"
                               required>

                    </div>


                    <div class="mb-3">

                        <label class="form-label">
                            Segundo apellido
                        </label>

                        <input type="text"
                               name="apellido2"
                               class="form-control">

                    </div>


                    <div class="mb-3">

                        <label class="form-label">
                            Departamento
                        </label>

                        <select name="id_departamento"
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

                            ?>

                                <option value="<?php echo $departamento['id']; ?>">

                                    <?php echo $departamento['nombre']; ?>

                                </option>

                            <?php } ?>

                        </select>

                    </div>

                </div>


                <div class="modal-footer">

                    <button type="button"
                            class="btn btn-secondary"
                            data-bs-dismiss="modal">
                        Cancelar
                    </button>

                    <button type="submit"
                            class="btn btn-primary">
                        Guardar
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>