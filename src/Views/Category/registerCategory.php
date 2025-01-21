<h1>Registrar Categoria</h1>

<form action="<?=BASE_URL?>createCategory" method="post" class="category">
    <input type="text" name="data[nombre]" class="form-control m-2" placeholder="Nombre">
    <?php if (!empty($errores)): ?>
        <div class="error-messages">
            <?php foreach ($errores as $error): ?>
                <p class="text-danger"><?= htmlspecialchars($error) ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
    <button type="submit" class="btn btn-primary">Registrar</button>
</form>


<style>
    .form-control {
        width: 21rem;
    }

    .category {
        margin: auto;
        width: 400px;
        padding: 20px;
        background: white;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        border-radius: 10px;
        text-align: center;
    }
</style>