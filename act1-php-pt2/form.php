<?php

if (isset($_POST['addMuebles'])) {
    addMuebles();
} else if (isset($_GET['getMuebles'])) {
    getMueblesDatos();
} else if (isset($_POST['addClientes'])) {
    addClientes();
} else if (isset($_POST['changeInfo'])) {
    modifyClientes();
} else if (isset($_GET['showInfo'])) {
    echo 'HAAA';
} else if (isset($_POST['deleteClient'])) {
    deleteClientes();
}



function conectarBD()
{
    $server = "localhost";
    $user = "root";
    $pass = "";
    $bd = "datos";

    return new mysqli($server, $user, $pass, $bd);
}

function getMueblesDatos()
{
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

function addMuebles()
{

    $con = conectarBD();

    if ($con) {
        $color = $_POST['color'];
        $dimensiones = $_POST['dimensiones'];
        $tipo = $_POST['tipo'];
        $cliente = $_POST['cliente'];

        $existe = comprobarCliente($cliente, $con);

        if ($existe > 0) {
            $sql = 'INSERT INTO muebles(color, dimensiones, tipo, cliente)
            VALUES("' . $color . '", "' . $dimensiones . '", "' . $tipo . '", "' . $cliente . '")';

            $ejecutar = mysqli_query($con, $sql);

            if (!$ejecutar) {
                echo 'Ha habido algun error al insertar los datos';
            } else {
                echo 'Se han añadido los datos de forma satisfactoria';
            }
        } else {
            echo 'El cliente no existe!';
        }
    } else {
        echo 'No se ha conectado a la base de datos :(';
    }
}

function comprobarCliente($cliente, $con)
{
    $sql = 'SELECT COUNT(*) FROM cliente WHERE dni = ' . $cliente . '';
    $rows = mysqli_query($con, $sql);
    $row = mysqli_fetch_assoc($rows);
    return $row['COUNT(*)'];
}

function addClientes()
{
    $con = conectarBD();

    if ($con) {
        $dni = $_POST['DNI'];
        $nombre = $_POST['nombre'];
        $apellidos = $_POST['apellidos'];
        $direccion = $_POST['direccion'];

        $existe = comprobarCliente($dni, $con);

        if ($existe == 0) {
            $sql = 'INSERT INTO cliente
            VALUES("' . $dni . '", "' . $nombre . '", "' . $apellidos . '", "' . $direccion . '")';

            $ejecutar = mysqli_query($con, $sql);

            if (!$ejecutar) {
                echo 'Ha habido algun error al insertar los datos';
            } else {
                echo 'Se han añadido los datos de forma satisfactoria';
            }
        } else {
            echo 'El cliente ya existe!';
        }
    } else {
        echo 'No se ha conectado a la base de datos :(';
    }
}

function modifyClientes()
{
    $con = conectarBD();

    if ($con) {
        $dni = $_POST['DNI'];
        $existe = comprobarCliente($dni, $con);

        if ($existe > 0) {
            $nombre = $_POST['nombre'];
            $apellidos = $_POST['apellidos'];
            $direccion = $_POST['direccion'];

            $sql = 'UPDATE cliente
            SET nombre ="' . $nombre . '", apellidos = "' . $apellidos . '", direccion = "' . $direccion . '"
            WHERE dni = "'. $dni . '"';

            echo $sql;

            $ejecutar = mysqli_query($con, $sql);

            if (!$ejecutar) {
                echo 'Ha habido algun error al cambiar los datos';
            } else {
                echo 'Se han cambiado los datos de forma satisfactoria';
            }
        } else {
            echo 'El cliente NO existe!';
        }
    } else {
        echo 'No se ha conectado a la base de datos :(';
    }
}

function deleteClientes() {
    $con = conectarBD();

    if ($con) {
        $dni = $_POST['DNI'];
        $existe = comprobarCliente($dni, $con);


        if ($existe > 0) {
            $sql = 'DELETE FROM cliente
            WHERE dni = "'. $dni . '"';

            $ejecutar = mysqli_query($con, $sql);

            if (!$ejecutar) {
                echo 'Ha habido algun error al eliminar';
            } else {
                echo 'Se ha eliminado el cliente';
            }
        } else {
            echo 'El cliente NO existe!';
        }

    } else {
        echo 'No se ha conectado a la base de datos :(';
    }
}

function showCliente() {
    $con = conectarBD();

    if ($con) {
        $dni = $_POST['DNI'];
        $existe = comprobarCliente($dni, $con);


        if ($existe > 0) {
            $sql = 'SELECT *
            FROM cliente
            WHERE dni = "' . $dni .'"';

            $ejecutar = mysqli_query($con, $sql);

            if (!$ejecutar) {
                echo 'Ha habido algun error al eliminar';
            } else {
                echo 'Se ha eliminado el cliente';
            }
        } else {
            echo 'El cliente NO existe!';
        }

    } else {
        echo 'No se ha conectado a la base de datos :(';
    }
}

