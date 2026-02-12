<?php include "conexion.php"; ?>

<h2>Medicamentos</h2>

<form method="POST">
    <input type="text" name="nombre" placeholder="Nombre" required>
    <input type="text" name="descripcion" placeholder="Descripción">
    <input type="number" name="stock" placeholder="Stock">
    <input type="text" name="proveedor" placeholder="Proveedor">
    <button type="submit" name="guardar">Guardar</button>
</form>

<?php
if (isset($_POST['guardar'])) {
    $sql = "INSERT INTO medicamentos (nombre, descripcion, stock, proveedor)
            VALUES ('$_POST[nombre]', '$_POST[descripcion]', '$_POST[stock]', '$_POST[proveedor]')";
    $conn->query($sql);
}
?>

<table border="1">
<tr><th>Nombre</th><th>Descripción</th><th>Stock</th><th>Proveedor</th><th>Acciones</th></tr>
<?php
$result = $conn->query("SELECT * FROM medicamentos");
while ($row = $result->fetch_assoc()) {
    echo "<tr>
        <td>{$row['nombre']}</td>
        <td>{$row['descripcion']}</td>
        <td>{$row['stock']}</td>
        <td>{$row['proveedor']}</td>
        <td>
            <a href='medicamentos.php?eliminar={$row['id']}'>Eliminar</a>
        </td>
    </tr>";
}
?>

<?php
if (isset($_GET['eliminar'])) {
    $conn->query("DELETE FROM medicamentos WHERE id=" . $_GET['eliminar']);
    header("Location: medicamentos.php");
}
?>
</table>
