<?php
$cart = $_SESSION['cart'] ?? [];
?>
<h1>Carrito de Compras</h1>
<?php if (!empty($cart)): ?>
    <table>
        <thead>
            <tr>
                <th>Imagen</th>
                <th>Producto</th>
                <th>Precio</th>
                <th>Cantidad</th>
                <th>Total</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($cart as $productId => $product): ?>
                <tr>
                    <td><img src="<?= $product['imagen'] ?>" alt="<?= $product['nombre'] ?>" width="50"></td>
                    <td><?= $product['nombre'] ?></td>
                    <td><?= $product['precio'] ?></td>
                    <td><?= $product['quantity'] ?></td>
                    <td><?= $product['precio'] * $product['quantity'] ?></td>
                    <td>

                        <form action="<?= BASE_URL ?>updateCart" method="post" style="display:inline;">
                            <input type="hidden" name="product_id" value="<?= $productId ?>">
                            <input type="hidden" name="action" value="decrease">
                            <button type="submit">-</button>
                        </form>

                        <form action="<?= BASE_URL ?>updateCart" method="post" style="display:inline;">
                            <input type="hidden" name="product_id" value="<?= $productId ?>">
                            <input type="hidden" name="action" value="increase">
                            <button type="submit">+</button>
                        </form>

                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <a href="<?= BASE_URL ?>createOrder" class="boton">Comprar</a>
<?php else: ?>
    <p>El carrito está vacío.</p>
<?php endif; ?>

<style>
    /* Tabla del carrito */
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

    table tbody img {
        border-radius: 5px;
    }

    .boton{
        display: block;
        width: 100px;
        margin: 20px auto;
        padding: 10px;
        background-color: #3498db;
        color: white;
        text-align: center;
        text-decoration: none;
        border-radius: 5px;
    }
    /* Botones de acciones */
    form button {
        background-color: #3498db;
        color: white;
        border: none;
        padding: 5px 10px;
        border-radius: 5px;
        font-size: 0.9em;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    form button:hover {
        background-color: #2980b9;
    }


    /* Mensaje de carrito vacío */
    p {
        text-align: center;
        font-size: 1.1em;
        color: #7f8c8d;
    }
</style>