<h1>Registro de usuario</h1>

<form action="<?=BASE_URL?>register" method="post" class="login">
    <label for="name">Nombre</label>
    <input type="text" name="data[nombre]" id="name" class="form-control m-2" >
    <label for="lastName">LastName</label>
    <input type="text" name="data[apellido]" id="lastName" class="form-control m-2">
    <label for="email">Email</label>
    <input type="email" name="data[email]" id="email" class="form-control m-2">
    <label for="password">Contraseña</label>
    <input type="password" name="data[password]" id="password" class="form-control m-2">
    <input type="submit" value="Registrarse" class="btn btn-primary">

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
</style>