<h1>Restablecer Contraseña</h1>

<form action="<?= BASE_URL ?>resetPassword/<?= htmlspecialchars($uniqueId) ?>" method="post" class="login">
    <input type="password" name="data[password]" class="form-control m-2" placeholder="Nueva Contraseña">
    <button type="submit" class="btn btn-primary">Restablecer Contraseña</button>

    <?php if (!empty($errors)): ?>
        <div class="error-messages">
            <?php foreach ($errors as $error): ?>
                <p class="text-danger"><?= htmlspecialchars($error) ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</form>

<style>
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

    .error-messages {
        margin-top: 10px;
        text-align: left;
    }

    .error-messages p {
        color: #e74c3c;
        font-size: 0.9rem;
        margin: 5px 0;
    }
</style>
