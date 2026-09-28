<?php

    $servidor = "localhost";
    $usuario = "root";
    $password = "";
    $base_datos = "empleados";

    $conn = new mysqli($servidor, $usuario, $password, $base_datos);

    if ($conn->connect_error) {
        die("Error de conexión: " . $conn->connect_error);
    }

?>