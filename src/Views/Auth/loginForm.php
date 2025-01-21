<h1>Login</h1>

<form action="<?= BASE_URL ?>login" method="post" class="login">
    <input type="text" name="data[email]" class="form-control m-2" placeholder="Email">
    <input type="password" name="data[password]" class="form-control m-2" placeholder="Password">
    <button type="submit" class="btn btn-primary">Login</button>

    <?php if (!empty($errors)): ?>
        <div class="error-messages">
            <?php foreach ($errors as $error): ?>
                <p class="text-danger"><?= htmlspecialchars($error) ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</form>

<?php if (isset($_SESSION['login'])): ?>
    <?php if ($_SESSION['login'] == 'Success'): ?>
        <p>Acceso completado</p>
    <?php else: ?>
        <p>Error al iniciar sesión</p>
    <?php endif; ?>
    <?php unset($_SESSION['login']); ?>
<?php endif; ?>

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
