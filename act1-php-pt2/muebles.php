<?php

if (isset($_GET['obtenerDatos'])) {
    getMueblesDatos();
} else {
    addMuebles();
}

function conectarBD() {
    $server = "localhost";
    $user = "root";
    $pass = "";
    $bd = "datos";

    return new mysqli($server, $user, $pass, $bd);
}

function getMueblesDatos() {
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

function addMuebles() {
    
    $con = conectarBD();

    if ($con) {
        $color = $_POST['color'];
        $dimensiones = $_POST['dimensiones'];
        $tipo = $_POST['tipo'];
        $cliente = $_POST['cliente'];

        $existe = comprobarCliente($cliente, $con);

        if ($existe > 0) {
            $sql = 'INSERT INTO muebles(color, dimensiones, tipo, cliente)
            VALUES("'. $color . '", "' . $dimensiones .'", "' . $tipo .'", "' . $cliente .'")';
        
            $ejecutar = mysqli_query($con, $sql);
        
            if (!$ejecutar) {
                echo 'Ha habido algun error al insertar los datos';
            } else{
                echo 'Se han añadido los datos de forma satisfactoria';
            }
        } else {
            echo 'El cliente no existe!';
        }
        
    } else {
        echo 'No se ha conectado a la base de datos :(';
    }
}

function comprobarCliente($cliente, $con) {
    $sql = 'SELECT COUNT(*) FROM cliente WHERE dni = ' . $cliente .'';
    $rows = mysqli_query($con, $sql);
    $row = mysqli_fetch_assoc($rows);
    return $row['COUNT(*)'];

}

?>