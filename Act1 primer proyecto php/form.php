<?php

if (isset($_GET['obtenerDatos'])) {
    getDatos();
} else {
    addDatos();
}

function conectarBD() {
    $server = "localhost";
    $user = "root";
    $pass = "";
    $bd = "muebles";

    return new mysqli($server, $user, $pass, $bd);
}

function getDatos() {
    $con = conectarBD();

    if ($con) {
        $sql = "SELECT * FROM muebles";
             
        $query = mysqli_query($con, $sql);

        if (mysqli_num_rows($query) > 0) {
            echo "<table>";
            echo "<tr>";
                echo "<th>id</th>";
                echo "<th>Color</th>";
                echo "<th>Dimensiones</th>";
                echo "<th>Tipo</th>";
            echo "</tr>";
            while ($row = mysqli_fetch_array($query)) {
                echo "<tr>";
                echo "<td>" . $row['id'] . "</td>";
                echo "<td>" . $row['color'] . "</td>";
                echo "<td>" . $row['dimensiones'] . "</td>";
                echo "<td>" . $row['tipo'] . "</td>";
                echo "</tr>";
            }

            echo "</table>";
        } else {
            echo 'No hay datos';
        }

    } else {
        echo 'No se ha conectado a la base de datos :(';
    }
}

function addDatos() {
    
    $con = conectarBD();

    if ($con) {
        $color = $_POST['color'];
        $dimensiones = $_POST['dimensiones'];
        $tipo = $_POST['tipo'];
    
        $sql = 'INSERT INTO muebles(color, dimensiones, tipo)
        VALUES("'. $color . '", "' . $dimensiones .'", "' . $tipo .'")';
    
        $ejecutar = mysqli_query($con, $sql);
    
        if (!$ejecutar) {
            echo 'Ha habido algun error al insertar los datos';
        } else{
            echo 'Se han añadido los datos de forma satisfactoria';
        }
        
    } else {
        echo 'No se ha conectado a la base de datos :(';
    }
}

?>