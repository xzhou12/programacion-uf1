<?php

// Conecta la bbdd
$con = conectarBD();

// Si conecta la base de datos, empieza la funcion
if ($con) {
    /*
    Dependiendo del Submit que se presione, hará una accion u otra
    */
    // Submit Muebles
    if (isset($_POST['addMuebles'])) {
        addMuebles($con);
    } else if (isset($_GET['getMuebles'])) {
        getMueblesDatos($con);
    // Submit Clientes
    } else if (isset($_POST['addClientes'])) {
        addClientes($con);
    } else if (isset($_POST['changeInfo'])) {
        modifyClientes($con);
    } else if (isset($_GET['showInfo'])) {
        showCliente($con);
    } else if (isset($_POST['deleteClient'])) {
        deleteClientes($con);
    }
} else {
    // Si no, muestra un mensaje de error
    echo 'No se ha conectado a la base de datos :(';
}



/*
Funcion para concectar a la BD
*/
function conectarBD()
{
    $server = "localhost";
    $user = "root";
    $pass = "";
    $bd = "datos";

    // Retorna la conexión a la bbdd
    return new mysqli($server, $user, $pass, $bd);
}

/*
Funcion para mostrar los datos en pantalla
*/
function getMueblesDatos($con)
{
    // Selecciona todos los muebles
    $sql = "SELECT * FROM muebles";
    $query = mysqli_query($con, $sql);

    // Y los muestra si ha encontrado más de 0 lineas
    if (mysqli_num_rows($query) > 0) {

        // Header de la tabla
        echo "<table>";
        echo "<tr>";
        echo "<th>id</th>";
        echo "<th>Color</th>";
        echo "<th>Dimensiones</th>";
        echo "<th>Tipo</th>";
        echo "</tr>";
        // Bucle que se repite segun el numero de lineas
        while ($row = mysqli_fetch_array($query)) {

            // Info de la tabla
            echo "<tr>";
            echo "<td>" . $row['id'] . "</td>";
            echo "<td>" . $row['color'] . "</td>";
            echo "<td>" . $row['dimensiones'] . "</td>";
            echo "<td>" . $row['tipo'] . "</td>";
            echo "</tr>";
        }

        echo "</table>";
    } else {
        // Si hay 0 resultados, muestra que no hay datos
        echo 'No hay datos';
    }
}

/*
Funcion para añadir muebles
*/
function addMuebles($con)
{
    // Recoge todos los datos del formulario HTML
    $color = $_POST['color'];
    $dimensiones = $_POST['dimensiones'];
    $tipo = $_POST['tipo'];
    $cliente = $_POST['cliente'];

    // Comprueba si el cliente existe
    $existe = comprobarCliente($cliente, $con);

    if ($existe > 0) { // Si existe el cliente, hace la funcion

        // Sentencia del mueble con el cliente
        $sql = 'INSERT INTO muebles(color, dimensiones, tipo, cliente)
        VALUES("' . $color . '", "' . $dimensiones . '", "' . $tipo . '", "' . $cliente . '")';

        // Ejecuta la sentencia
        $ejecutar = mysqli_query($con, $sql);

        if (!$ejecutar) {
            // Ha fallado la sentencia muestra un error
            echo 'Ha habido algun error al insertar los datos';
        } else {
            // Si ha salido bien, muestra que se han añadido satisfactoriamente
            echo 'Se han añadido los datos de forma satisfactoria';
        }
    } else {
        // Si el cliente no existe, muestra que no existe
        echo 'El cliente no existe!';
    }
}

/*
Funcion para comprobar si existe el cliente
*/
function comprobarCliente($cliente, $con)
{
    // Cuenta los rows que existen con el mismo dni que se le pasa por parametro
    $sql = 'SELECT COUNT(*) FROM cliente WHERE dni = ' . $cliente . '';
    $rows = mysqli_query($con, $sql);
    $row = mysqli_fetch_assoc($rows);

    // Retorna las filas contadas
    return $row['COUNT(*)'];
}

/*
Funcion para añadir clientes
*/
function addClientes($con)
{
    // Recoge todos datos del formulario html
    $dni = $_POST['DNI'];
    $nombre = $_POST['nombre'];
    $direccion = $_POST['direccion'];
    $email = $_POST['email'];

    // Comprueba si existe el cliente
    $existe = comprobarCliente($dni, $con);

    if ($existe == 0) { // Si no existe, empieza la funcion

        // Sentencia sql para insertar
        $sql = 'INSERT INTO cliente
            VALUES("' . $dni . '", "' . $nombre . '", "' . $direccion . '", "' . $email . '")';

        // Ejecuta la sentencia
        $ejecutar = mysqli_query($con, $sql);

        
        if (!$ejecutar) {
            // Si ha fallado la sentencia muestra un error
            echo 'Ha habido algun error al insertar los datos';
        } else {
            // Si ha salido bien, muestra que se han añadido satisfactoriamente
            echo 'Se han añadido los datos de forma satisfactoria';
        }
    } else {
        // Si el cliente ya existe, muestra que ya exsite
        echo 'El cliente ya existe!';
    }
}

/*
Funcion para modificar los datos de los clientes
*/
function modifyClientes($con)
{
    // Recoge el dni del formulario html
    $dni = $_POST['DNI'];
    // Comprueba si existe el cliente
    $existe = comprobarCliente($dni, $con);

    // Si existe el cliente
    if ($existe > 0) {
        // Recoge la información
        $nombre = $_POST['nombre'];
        $direccion = $_POST['direccion'];
        $email = $_POST['email'];

        // Y hace la sentencia de Update
        $sql = 'UPDATE cliente
            SET nombre ="' . $nombre . '", direccion = "' . $direccion . '", email = "' . $email . '"
            WHERE dni = "' . $dni . '"';

        // Ejecuta la sentencia
        $ejecutar = mysqli_query($con, $sql);


        if (!$ejecutar) {
            // Si ha fallado la sentencia muestra un error
            echo 'Ha habido algun error al cambiar los datos';
        } else {
            // Si ha salido bien, muestra que se han añadido satisfactoriamente
            echo 'Se han cambiado los datos de forma satisfactoria';
        }
    } else {
        // Si no existe el cliente, muestra que no existe
        echo 'El cliente NO existe!';
    }
}

function deleteClientes($con)
{
    // Recoge el dni del formulario html y comprueba si existe
    $dni = $_POST['DNI'];
    $existe = comprobarCliente($dni, $con);

    // Si existe, hace la funcion
    if ($existe > 0) {

        // Sentencia para eliminar
        $sql = 'DELETE FROM cliente
            WHERE dni = "' . $dni . '"';

        // Ejecuta la sentencia
        $ejecutar = mysqli_query($con, $sql);


        if (!$ejecutar) {
            // Si ha fallado la sentencia muestra un error
            echo 'Ha habido algun error al eliminar';
        } else {
            // Si ha salido bien, muestra que se han añadido satisfactoriamente
            echo 'Se ha eliminado el cliente';
        }
    } else {
         // Si no existe el cliente, muestra que no existe
        echo 'El cliente NO existe!';
    }
}

function showCliente($con)
{
    // Recoge el dni
    $dni = $_GET['DNI'];

    // Si DNI no tiene valor
    if ($dni == null) {
        // Hace un select de todo
        $sql = 'SELECT *
                FROM cliente';

        // Y ejecuta la sentencia
        $query = mysqli_query($con, $sql);
    } else {
        // Si no, comprueba que existe el cliente
        $existe = comprobarCliente($dni, $con);

        if ($dni > 0) {
            // Si existe, hace la sentencia para ese cliente
            $sql = 'SELECT *
                FROM cliente
                WHERE dni = "' . $dni . '"';

            // Ejecuta la sentencia
            $query = mysqli_query($con, $sql);
        } else {
            // Si no existe el cliente, muestra que no existe
            echo 'El cliente NO existe!';
        }
    }

    // Si hay más de 0 resultados
    if (mysqli_num_rows($query) > 0) {
        // Header de la tabla
        echo "<table>";
        echo "<tr>";
        echo "<th>dni</th>";
        echo "<th>nombre</th>";
        echo "<th>direccion</th>";
        echo "<th>email</th>";
        echo "</tr>";
        // Bucle que se repite tantas veces como resultados haya
        while ($row = mysqli_fetch_array($query)) {
            echo "<tr>";
            // Muestra los resultados
            echo "<td>" . $row['dni'] . "</td>";
            echo "<td>" . $row['nombre'] . "</td>";
            echo "<td>" . $row['direccion'] . "</td>";
            echo "<td>" . $row['email'] . "</td>";
            echo "</tr>";
        }

        echo "</table>";
    } else {
        // Si no hay resultados, muestra que no hay resultados
        echo 'No hay datos';
    }
}
