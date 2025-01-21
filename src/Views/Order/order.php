<form action="<?= BASE_URL ?>createOrder" method="post">
    <label for="provincia">Provincia:</label>
    <input type="text" id="provincia" name="data[provincia]"><br><br>
    <?php if (isset($errors['provincia'])): ?>
        <p class="error"><?= htmlspecialchars($errors['provincia']) ?></p>
    <?php endif; ?>
    <label for="localidad">Localidad:</label>
    <input type="text" id="localidad" name="data[localidad]"><br><br>
    <?php if (isset($errors['localidad'])): ?>
        <p class="error"><?= htmlspecialchars($errors['localidad']) ?></p>
    <?php endif; ?>

    <label for="direccion">Dirección:</label>
    <input type="text" id="direccion" name="data[direccion]"><br><br>
    <?php if (isset($errors['direccion'])): ?>
        <p class="error"><?= htmlspecialchars($errors['direccion']) ?></p>
    <?php endif; ?>

    <?php if (isset($_SESSION['fallos'])): ?>
        <div class="error">
            <?php foreach ($_SESSION['fallos'] as $error): ?>
                <p><?= $error ?></p>
            <?php endforeach; ?>
        </div>
        <?php $_SESSION['fallos'] = null; ?>
    <?php endif; ?>

    <input type="submit" value="Enviar">

</form>

<style>
    /* Estilos generales del formulario */
    form {
        max-width: 400px;
        margin: 30px auto;
        padding: 20px;
        background-color: #ffffff;
        box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        border-radius: 10px;
        font-family: Arial, sans-serif;
    }

    form label {
        display: block;
        margin-bottom: 5px;
        font-weight: bold;
        color: #2c3e50;
    }

    form input[type="text"] {
        width: 100%;
        padding: 10px;
        margin-bottom: 15px;
        border: 1px solid #ccc;
        border-radius: 5px;
        font-size: 1em;
        box-sizing: border-box;
        transition: border-color 0.3s;
    }

    form input[type="text"]:focus {
        border-color: #3498db;
        outline: none;
        box-shadow: 0 0 5px rgba(52, 152, 219, 0.5);
    }

    form input[type="submit"] {
        width: 100%;
        padding: 10px;
        background-color: #3498db;
        color: white;
        border: none;
        border-radius: 5px;
        font-size: 1em;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    form input[type="submit"]:hover {
        background-color: #2980b9;
    }

    /* Mensajes de error */
    form .error {
        color: #e74c3c;
        font-size: 0.9em;
        margin: -10px 0 10px 0;
    }
</style>