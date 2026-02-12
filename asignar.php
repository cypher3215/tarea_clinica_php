<?php include "conexion.php"; ?>

<h2>Asignar Medicamento a Paciente</h2>

<form method="POST">
    <select name="paciente_id" required>
        <option value="">Seleccione Paciente</option>
        <?php
        $pacientes = $conn->query("SELECT * FROM pacientes");
        while ($p = $pacientes->fetch_assoc()) {
            echo "<option value='{$p['id']}'>{$p['nombre']}</option>";
        }
        ?>
    </select>

    <select name="medicamento_id" required>
        <option value="">Seleccione Medicamento</option>
        <?php
        $meds = $conn->query("SELECT * FROM medicamentos");
        while ($m = $meds->fetch_assoc()) {
            echo "<option value='{$m['id']}'>{$m['nombre']}</option>";
        }
        ?>
    </select>

    <input type="date" name="fecha" required>
    <input type="text" name="dosis" placeholder="Dosis" required>
    <button type="submit" name="asignar">Asignar</button>
</form>

<?php
if (isset($_POST['asignar'])) {
    $sql = "INSERT INTO paciente_medicamento (paciente_id, medicamento_id, fecha, dosis)
            VALUES ('$_POST[paciente_id]', '$_POST[medicamento_id]', '$_POST[fecha]', '$_POST[dosis]')";
    $conn->query($sql);
}
?>

<h3>Asignaciones actuales</h3>
<table border="1">
<tr><th>Paciente</th><th>Medicamento</th><th>Fecha</th><th>Dosis</th><th>Acción</th></tr>
<?php
$result = $conn->query("
    SELECT pm.id, p.nombre AS paciente, m.nombre AS medicamento, pm.fecha, pm.dosis
    FROM paciente_medicamento pm
    JOIN pacientes p ON pm.paciente_id = p.id
    JOIN medicamentos m ON pm.medicamento_id = m.id
");

while ($row = $result->fetch_assoc()) {
    echo "<tr>
        <td>{$row['paciente']}</td>
        <td>{$row['medicamento']}</td>
        <td>{$row['fecha']}</td>
        <td>{$row['dosis']}</td>
        <td><a href='asignar.php?eliminar={$row['id']}'>Eliminar</a></td>
    </tr>";
}
?>

<?php
if (isset($_GET['eliminar'])) {
    $conn->query("DELETE FROM paciente_medicamento WHERE id=" . $_GET['eliminar']);
    header("Location: asignar.php");
}
?>
</table>
