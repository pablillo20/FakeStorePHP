<form action="<?= BASE_URL ?>editProducts/<?= htmlspecialchars($product->getId()); ?>" method="POST" enctype="multipart/form-data">

    <input type="hidden" id="id" name="data[id]" value="<?= htmlspecialchars($product->getId()); ?>" required>



    <div class="form-group">
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="data[nombre]" class="form-control" value="<?= htmlspecialchars($product->getNombre()); ?>">
        <?php if (isset($errores['nombre'])): ?>
            <p class="error"><?= htmlspecialchars($errores['nombre']) ?></p>
        <?php endif; ?>
    </div>

    <div class="form-group">
        <label for="descripcion">Descripción:</label>
        <textarea id="descripcion" name="data[descripcion]" class="form-control" ><?= htmlspecialchars($product->getDescripcion()); ?></textarea>
        <?php if (isset($errores['descripcion'])): ?>
            <p class="error"><?= htmlspecialchars($errores['descripcion']) ?></p>
        <?php endif; ?>
    </div>

    <div class="form-group">
        <label for="categoria">Categoría:</label>
        <select id="categoria" name="data[categoria_id]" class="form-control" required>
            <?php foreach ($categories as $category): ?>
                <option value="<?= htmlspecialchars($category->getId()); ?>" <?= $category->getId() == $product->getCategoriaId() ? 'selected' : ''; ?>>
                    <?= htmlspecialchars($category->getName()); ?>
                </option>
            <?php endforeach; ?>
        </select>
        <?php if (isset($errores['categoria_id'])): ?>
            <p class="error"><?= htmlspecialchars($errores['categoria_id']) ?></p>
        <?php endif; ?>
    </div>


    <div class="form-group">
        <label for="precio">Precio:</label>
        <input type="number" id="precio" name="data[precio]" class="form-control" step="0.01" value="<?= htmlspecialchars($product->getPrecio()); ?>">
        <?php if (isset($errores['precio'])): ?>
            <p class="error"><?= htmlspecialchars($errores['precio']) ?></p>
        <?php endif; ?>
    </div>

    <div class="form-group">
        <label for="stock">Stock:</label>
        <input type="number" id="stock" name="data[stock]" class="form-control" value="<?= htmlspecialchars($product->getStock()); ?>">
        <?php if (isset($errores['stock'])): ?>
            <p class="error"><?= htmlspecialchars($errores['stock']) ?></p>
        <?php endif; ?>
    </div>

    <div class="form-group">
        <label for="oferta">Oferta:</label>
        <input type="number" id="oferta" name="data[oferta]" class="form-control" value="<?= htmlspecialchars($product->getOferta()); ?>">
        <?php if (isset($errores['oferta'])): ?>
            <p class="error"><?= htmlspecialchars($errores['oferta']) ?></p>
        <?php endif; ?>
    </div>

    <button type="submit" class="btn btn-primary">Actualizar Producto</button>
</form>

</div>

<style>
    .error{
        color: red;
    }
</style>