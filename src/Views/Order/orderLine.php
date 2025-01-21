<h1 style="text-align: center;">Tabla de Pedidos</h1>
    <table>
        <thead>
            <tr>
                <th>Pedido ID</th>
                <th>Producto ID</th>
                <th>Cantidad</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($orderLine as $order): ?>
                <tr>
                    <td><?= htmlspecialchars($order['pedido_id']); ?></td>
                    <td><?= htmlspecialchars($order['producto_id']); ?></td>
                    <td><?= htmlspecialchars($order['unidades']); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

<style>
    /* Estilos generales para tablas */
table {
    width: 80%;
    margin: 20px auto;
    border-collapse: collapse;
    font-family: Arial, sans-serif;
    background-color: #ffffff;
    box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
    border-radius: 10px;
    overflow: hidden;
}

table thead {
    background-color: #3498db;
    color: white;
    text-align: left;
}

table thead th {
    padding: 10px;
    font-size: 1.1em;
}

table tbody tr:nth-child(even) {
    background-color: #f2f2f2;
}

table tbody tr:nth-child(odd) {
    background-color: #ffffff;
}

table tbody td {
    padding: 10px;
    text-align: left;
    border-bottom: 1px solid #ddd;
}

table tbody tr:hover {
    background-color: #f1f1f1;
    transition: background-color 0.3s;
}

/* Encabezado de la tabla */
h1 {
    font-family: Arial, sans-serif;
    color: #2c3e50;
    margin-top: 20px;
}
</style>