<h1>Listado de Productos</h1>

<?php if (!empty($products)): ?>
    <div class="product-grid">
        <?php foreach ($products as $product): ?>
            <div class="product-card">
                <img class="product-image" src="<?= !empty($product['imagen']) ? htmlspecialchars($product['imagen']) : 'https://img.freepik.com/vector-premium/no-hay-foto-disponible-icono-vector-simbolo-imagen-predeterminado-imagen-proximamente-sitio-web-o-aplicacion-movil_87543-10615.jpg' ?>" alt="<?= htmlspecialchars($product['nombre']) ?>">
                <div class="product-content">
                    <h2 class="product-title"><?= htmlspecialchars($product['nombre']) ?></h2>
                    <p class="product-description">Descripción: <?= htmlspecialchars($product['descripcion']) ?></p>
                    <p class="product-price">Precio: $<?= number_format($product['precio'], 2) ?></p>
                    <p class="product-stock <?= $product['stock'] > 5 ? '' : 'low' ?>">Stock: <?= htmlspecialchars($product['stock']) ?></p>
                    <?php if (!empty($product['oferta'])): ?>
                        <p class="product-offer">Oferta: <?= htmlspecialchars($product['oferta']) ?></p>
                    <?php endif; ?>
                    <a href="<?= BASE_URL ?>editProducts/<?= $product['id'] ?>" class="edit-button">Editar</a>
                    <a href="<?= BASE_URL ?>DeleteProduct/<?= $product['id'] ?>" class="delete-buton">Borrar</a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php else: ?>
    <p class="no-products">No hay productos disponibles.</p>
<?php endif; ?>

<style>
    h1 {
        text-align: center;
        color: #0056b3;
    }

    .product-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        gap: 20px;
        margin-top: 20px;
    }

    .product-card {
        background-color: #ffffff;
        border: 1px solid #ddd;
        border-radius: 8px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        transition: transform 0.2s ease;
    }

    .product-card:hover {
        transform: translateY(-5px);
    }

    .product-image {
        width: 100%;
        height: 150px;
        object-fit: cover;
        background-color: #eaeaea;
    }

    .product-content {
        padding: 15px;
    }

    .product-title {
        font-size: 18px;
        color: #0056b3;
        margin: 0;
        margin-bottom: 10px;
        font-weight: bold;
    }

    .product-description {
        font-size: 14px;
        color: #555;
        margin-bottom: 10px;
    }

    .product-price {
        font-size: 16px;
        color: #007bff;
        font-weight: bold;
    }

    .product-stock {
        font-size: 14px;
        color: #28a745;
        margin-top: 10px;
    }

    .product-stock.low {
        color: #dc3545;
    }

    .product-offer {
        font-size: 14px;
        color: #ff9900;
        margin-top: 5px;
    }

    .no-products {
        text-align: center;
        font-size: 18px;
        color: #555;
    }

    /* Estilos para los botones Editar y Borrar */
    .edit-button, .delete-button {
        display: inline-block;
        padding: 5px 10px;
        margin-top: 10px;
        margin-left: 5px;
        font-size: 14px;
        text-align: center;
        text-decoration: none;
        cursor: pointer;
        border-radius: 4px;
    }

    .edit-button {
        background-color: #ffc107;
        color: white;
    }

    .edit-button:hover {
        background-color: #e0a800;
    }

    .delete-button {
        background-color: #dc3545;
        color: white;
        border: none;
    }

    .delete-button:hover {
        background-color: #c82333;
    }
</style>
