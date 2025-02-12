<h1>Login</h1>

<form action="<?= BASE_URL ?>login" method="post" class="login">
    <input type="text" name="data[email]" class="form-control m-2" placeholder="Email">
    <input type="password" name="data[password]" class="form-control m-2" placeholder="Password">
    <button type="submit" class="btn btn-primary">Login</button>
    <a href="#" class="btn btn-link" data-toggle="modal" data-target="#passwordResetModal">¿Olvidaste tu contraseña?</a>

    <?php if (!empty($errors)): ?>
        <div class="error-messages">
            <?php foreach ($errors as $error): ?>
                <p class="text-danger"><?= htmlspecialchars($error) ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</form>

<!-- Modal de recuperación de contraseña -->
<div class="modal fade" id="passwordResetModal" tabindex="-1" role="dialog" aria-labelledby="passwordResetModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="passwordResetModalLabel">Recuperar Contraseña</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="<?= BASE_URL ?>requestPasswordReset" method="post" class="login">
                    <input type="email" name="data[email]" class="form-control m-2" placeholder="Email">
                    <button type="submit" class="btn btn-primary">Recuperar Contraseña</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php if (isset($_SESSION['login'])): ?>
    <?php if ($_SESSION['login'] == 'Success'): ?>
        <p>Acceso completado</p>
    <?php else: ?>
        <p>Error al iniciar sesión</p>
    <?php endif; ?>
    <?php unset($_SESSION['login']); ?>
<?php endif; ?>

<?php if (isset($_SESSION['password_reset'])): ?>
    <?php if ($_SESSION['password_reset'] == 'Success'): ?>
        <p>Se ha enviado un enlace para restablecer la contraseña a su correo electrónico.</p>
    <?php else: ?>
        <p>Error al enviar el enlace de restablecimiento de contraseña.</p>
    <?php endif; ?>
    <?php unset($_SESSION['password_reset']); ?>
<?php endif; ?>

<?php if (isset($_SESSION['confirmacion'])): ?>
    <?php if ($_SESSION['confirmacion'] == false): ?>
        <p>Por favor, confirme su cuenta desde el enlace enviado a su correo electrónico.</p>
    <?php endif; ?>
    <?php unset($_SESSION['confirmacion']); ?>
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

<!-- Incluir scripts de Bootstrap -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
