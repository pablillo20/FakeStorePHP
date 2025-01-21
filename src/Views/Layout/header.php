<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
        rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
        crossorigin="anonymous" />

    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css">

    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&family=Roboto:wght@300;400;500&display=swap"
        rel="stylesheet">

    <title>Tienda</title>
    <style>
        /* General body styling */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f9;
            color: #333;
        }

        /* Header styling */
        h1 {
            text-align: center;
            margin-top: 20px;
            color: #222;
        }

        /* Navigation bar styling */
        nav {
            background-color: #007BFF;
            padding: 10px 0;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        nav ul {
            display: flex;
            justify-content: center;
            list-style: none;
            margin: 0;
            padding: 0;
        }

        nav ul li {
            margin: 0 15px;
        }

        nav ul li a {
            text-decoration: none;
            color: #fff;
            font-size: 16px;
            font-weight: bold;
            padding: 10px 15px;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        nav ul li a:hover {
            background-color: #0056b3;
        }

        /* Active link styling */
        nav ul li a.active {
            background-color: #0056b3;
        }

        /* Content styling */
        .content {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>

<body>

    <h1>Bienvenido a mi tienda <?= isset($_SESSION['user']['username']) ? htmlspecialchars($_SESSION['user']['username']) : 'Visitante' ?> </h1>

    <nav>
        <ul>
            <?php if (!isset($_SESSION['user'])) { ?>
                <!-- Mostrar opciones de Login y Register si el usuario no está logueado -->
                <li><a href="<?= BASE_URL ?>login">Login</a></li>
                <li><a href="<?= BASE_URL ?>register">Register</a></li>
            <?php } else { ?>
                <!-- Mostrar cerrar sesión si el usuario está logueado -->
                <li><a href="<?= BASE_URL ?>logout">Cerrar Sesión</a></li>
                <li><a href="<?= BASE_URL ?>ShowCart">Carrito</a></li>
                <li><a href="<?= BASE_URL ?>showOrders">Mis Pedidos</a></li>
            <?php } ?>

            <!-- Lista de productos está siempre disponible -->
            <li><a href="<?= BASE_URL ?>FilterProducts">Lista de Productos</a></li>

            <?php if (isset($_SESSION['admin']) && $_SESSION['admin'] === 1) { ?>
                <!-- Mostrar "Registrar Productos" solo si el usuario es admin -->
                <li><a href="<?= BASE_URL ?>product">Registrar Productos</a></li>
                <li><a href="<?= BASE_URL ?>createCategory">Crear Categoria</a></li>
                <li><a href="<?=BASE_URL ?>AllProducts">Administrar Productos</a></li>
                <li><a href="<?=BASE_URL ?>AllOrderLine">Linea de Pedidos</a></li>
            <?php } ?>
        </ul>
    </nav>

    <div class="content">
        <p>¡Explora nuestra tienda y encuentra lo que necesitas!</p>
    </div>

    <script
        src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
        crossorigin="anonymous"></script>

    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
        crossorigin="anonymous"></script>

</body>

</html>