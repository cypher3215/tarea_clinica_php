<?php include "conexion.php"; ?>

<h2>Pacientes</h2>

<form method="POST">
    <input type="text" name="nombre" placeholder="Nombre" required>
    <input type="text" name="documento" placeholder="Documento" required>
    <input type="text" name="telefono" placeholder="Teléfono">
    <input type="text" name="direccion" placeholder="Dirección">
    <button type="submit" name="guardar">Guardar</button>
</form>

<?php
if (isset($_POST['guardar'])) {
    $sql = "INSERT INTO pacientes (nombre, documento, telefono, direccion)
            VALUES ('$_POST[nombre]', '$_POST[documento]', '$_POST[telefono]', '$_POST[direccion]')";
    $conn->query($sql);
}
?>

<table border="1">
<tr><th>Nombre</th><th>Documento</th><th>Teléfono</th><th>Dirección</th><th>Acciones</th></tr>
<?php
$result = $conn->query("SELECT * FROM pacientes");
while ($row = $result->fetch_assoc()) {
    echo "<tr>
        <td>{$row['nombre']}</td>
        <td>{$row['documento']}</td>
        <td>{$row['telefono']}</td>
        <td>{$row['direccion']}</td>
        <td>
            <a href='pacientes.php?eliminar={$row['id']}'>Eliminar</a>
        </td>
    </tr>";
}
?>

<?php
if (isset($_GET['eliminar'])) {
    $conn->query("DELETE FROM pacientes WHERE id=" . $_GET['eliminar']);
    header("Location: pacientes.php");
}
?>
</table>
