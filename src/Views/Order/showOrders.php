<?php
$orders = $orders ?? [];
?>
<h1>Mis Pedidos</h1>
<?php if (!empty($orders)): ?>
    <table>
        <thead>
            <tr>
                <th>ID de Pedido</th>
                <th>Fecha</th>
                <th>Total</th>
                <th>Producto ID</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($orders as $order): ?>
                <tr>
                    <td><?= $order['pedido_id'] ?></td>
                    <td><?= $order['fecha'] ?></td>
                    <td><?= $order['coste'] ?></td>
                    <td><?= $order['producto_id'] ?></td>
                    <td><?= $order['estado'] ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <p>No tienes órdenes.</p>
<?php endif; ?>

<style>
    /* Tabla de órdenes */
    table {
        width: 90%;
        margin: 0 auto;
        border-collapse: collapse;
        background-color: #ffffff;
        box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        border-radius: 10px;
        overflow: hidden;
    }

    table thead {
        background-color: #3498db;
        color: white;
    }

    table thead th {
        padding: 10px;
        text-align: center;
        font-size: 1em;
    }

    table tbody tr {
        border-bottom: 1px solid #ddd;
    }

    table tbody td {
        text-align: center;
        padding: 10px;
        font-size: 0.9em;
    }

    .boton {
        display: inline-block;
        padding: 5px 10px;
        background-color: #3498db;
        color: white;
        text-align: center;
        text-decoration: none;
        border-radius: 5px;
        font-size: 0.9em;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    .boton:hover {
        background-color: #2980b9;
    }

    /* Mensaje de órdenes vacías */
    p {
        text-align: center;
        font-size: 1.1em;
        color: #7f8c8d;
    }
</style>
