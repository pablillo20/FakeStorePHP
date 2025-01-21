<!-- Formulario para seleccionar la categoría -->
<form method="POST" action="<?= BASE_URL ?>FilterProducts">
    <select name="data[categoria_id]" class="form-control m-2">
        <option value="0">Selecciona una Categoría</option>
        <?php foreach ($categories as $category): ?>
            <option value="<?= $category->getId() ?>" <?= isset($_GET['data']['categoria_id']) && $_GET['data']['categoria_id'] == $category->getId() ? 'selected' : '' ?>>
                <?= htmlspecialchars($category->getName()) ?>
            </option>
        <?php endforeach; ?>
    </select>
    <button type="submit">Filtrar</button>
</form>

<!-- Mostrar productos filtrados -->
<?php if (!empty($products)): ?>
    <div class="product-list">
        <?php foreach ($products as $product): ?>
            <div class="product-item">
                <img class="product-image" 
                     src="<?= !empty($product['imagen']) ? htmlspecialchars($product['imagen']) : 'https://img.freepik.com/vector-premium/no-hay-foto-disponible-icono-vector-simbolo-imagen-predeterminado-imagen-proximamente-sitio-web-o-aplicacion-movil_87543-10615.jpg' ?>" 
                     alt="<?= htmlspecialchars($product['nombre']) ?>">

                <div class="product-content">
                    <h2 class="product-title"><?= htmlspecialchars($product['nombre']) ?></h2>
                    <p class="product-description">Descripción: <?= htmlspecialchars($product['descripcion']) ?></p>
                    <p class="product-price">Precio: $<?= number_format($product['precio'], 2) ?></p>
                    <p class="product-stock <?= $product['stock'] > 5 ? '' : 'low' ?>">Stock: <?= htmlspecialchars($product['stock']) ?></p>

                    <?php if (!empty($product['oferta'])): ?>
                        <p class="product-offer">Oferta: <?= htmlspecialchars($product['oferta']) ?></p>
                    <?php endif; ?>

                    <form action="<?= BASE_URL ?>AddCart" method="post" style="display: inline;">
                        <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                        <button type="submit">Comprar</button>
                    </form>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php else: ?>
    <p>No se encontraron productos en esta categoría.</p>
<?php endif; ?>


<style>
form {
    margin: 20px auto;
    padding: 15px;
    background: #fff;
    border: 1px solid #ddd;
    border-radius: 5px;
    width: 90%;
    max-width: 600px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
}

form select {
    width: calc(100% - 4px);
    padding: 10px;
    font-size: 16px;
    border: 1px solid #ccc;
    border-radius: 4px;
}

form button {
    margin-top: 10px;
    padding: 10px 20px;
    font-size: 16px;
    color: #fff;
    background-color: #007bff;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    transition: background-color 0.3s;
}

form button:hover {
    background-color: #0056b3;
}

/* Estilos de la lista de productos */
.product-list {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
    padding: 20px;
    justify-content: center;
}

.product-item {
    background: #fff;
    border: 1px solid #ddd;
    border-radius: 8px;
    overflow: hidden;
    width: 280px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s, box-shadow 0.3s;
}

.product-item:hover {
    transform: translateY(-5px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
}

.product-image {
    width: 100%;
    height: 200px;
    object-fit: cover;
    background-color: #f4f4f4;
}

.product-content {
    padding: 15px;
}

.product-title {
    font-size: 18px;
    margin: 0 0 10px;
    color: #007bff;
    text-decoration: none;
    transition: color 0.3s;
}

.product-title:hover {
    color: #0056b3;
}

.product-description {
    font-size: 14px;
    margin: 5px 0;
    color: #555;
}

.product-price {
    font-size: 16px;
    font-weight: bold;
    margin: 10px 0;
    color: #28a745;
}

.product-stock {
    font-size: 14px;
    margin: 5px 0;
}

.product-stock.low {
    color: #dc3545;
    font-weight: bold;
}

.product-offer {
    font-size: 14px;
    color: #ffc107;
    font-weight: bold;
    margin: 5px 0;
}

.product-content form {
    margin-top: 10px;
}

.product-content button {
    padding: 10px 15px;
    font-size: 14px;
    color: #fff;
    background-color: #28a745;
    border: none;
    cursor: pointer;
}

.product-content button:hover {
    background-color: #218838;
}

/* Mensaje de error o vacío */
.product-list ~ p {
    text-align: center;
    font-size: 16px;
    color: #555;
    margin-top: 20px;
}
</style>
