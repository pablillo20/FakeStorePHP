<h1>Registrar Producto</h1>
<form action="<?= BASE_URL ?>product" method="post" class="login">


    <!-- Selección de Categoría -->
    <select name="data[categoria_id]" class="form-control m-2">
        <option value="">Selecciona una Categoría</option>
        <?php foreach ($categories as $category): ?>
            <option value="<?= $category->getId() ?>"><?= $category->getName() ?></option>
        <?php endforeach; ?>
    </select>
    <?php if (isset($errores['categoria_id'])): ?>
        <p class="error"><?= htmlspecialchars($errores['categoria_id']) ?></p>
    <?php endif; ?>
    


    <!-- Otros campos -->
    <input type="text" name="data[nombre]" class="form-control m-2" placeholder="Nombre">
    <?php if (isset($errores['nombre'])): ?>
        <p class="error"><?= htmlspecialchars($errores['nombre']) ?></p>
    <?php endif; ?>



    <input type="text" name="data[descripcion]" class="form-control m-2" placeholder="Descripción">
    <?php if (isset($errores['descripcion'])): ?>
        <p class="error"><?= htmlspecialchars($errores['descripcion']) ?></p>
    <?php endif; ?>


    <input type="text" name="data[precio]" class="form-control m-2" placeholder="Precio">
    <?php if (isset($errores['precio'])): ?>
        <p class="error"><?= htmlspecialchars($errores['precio']) ?></p>
    <?php endif; ?>
    <input type="text" name="data[stock]" class="form-control m-2" placeholder="Stock">
    <?php if (isset($errores['stock'])): ?>
        <p class="error"><?= htmlspecialchars($errores['stock']) ?></p>
    <?php endif; ?>


    <input type="text" name="data[oferta]" class="form-control m-2" placeholder="Oferta">
    <?php if (isset($errores['oferta'])): ?>
        <p class="error"><?= htmlspecialchars($errores['oferta']) ?></p>
    <?php endif; ?>


    <input type="text" name="data[fecha]" class="form-control m-2" placeholder="Fecha">
    <?php if (isset($errores['fecha'])): ?>
        <p class="error"><?= htmlspecialchars($errores['fecha']) ?></p>
    <?php endif; ?>


    <input type="text" name="data[imagen]" class="form-control m-2" placeholder="Imagen">
    <?php if (isset($errores['iamgen'])): ?>
        <p class="error"><?= htmlspecialchars($errores['imagen']) ?></p>
    <?php endif; ?>

    <button type="submit" class="btn btn-primary">Registrar</button>
</form>
<style>
    .error {
        color: red;
    }

    .form-control {
        width: 21rem;
    }

    .login {
        margin: auto;
        width: 400px;
        padding: 20px;
        background: white;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        border-radius: 10px;
        text-align: center;
    }
</style>