<?php 
namespace Routes;

use Controllers\AuthController;
use Lib\Router;
use Controllers\ErrorController;
use Controllers\DashboardController;
use Controllers\ProductController;
use Controllers\CartController;
use Controllers\CategoryController;
use Controllers\OrderController;
use Controllers\OrderLineController;
use Models\Category;

class Routes{
    public static function index(){
        Router::add('GET', '/', function(){
            (new DashboardController())->index();
        });

        /*Auth Routes*/
        Router::add('GET', '/register', function(){
            (new AuthController())->register();
        });

        Router::add('POST', '/register', function(){
            (new AuthController())->register();
        });

        Router::add('GET', '/login', function(){
            (new AuthController())->login();
        });

        Router::add('POST', '/login', function(){
            (new AuthController())->login();
        });

        Router::add('POST', '/logout', function(){
            (new AuthController())->logout();
        });

        Router::add('GET', '/logout', function(){
            (new AuthController())->logout();
        });

        /* Product Routes */
        Router::add('GET', '/product', function(){
            (new ProductController())->product();
        });

        Router::add('POST', '/product', function(){
            (new ProductController())->product();
        });

        Router::add('GET', '/AllProducts', function(){
            (new ProductController())->AllProducts();
        });

        Router::add('GET', '/editProducts/:id', function($id){
            (new ProductController())->editProducts($id);
        });

        Router::add('POST', '/editProducts/:id', function($id){
            (new ProductController())->editProducts($id);
            
        });

        Router::add('GET', '/DeleteProduct/:id', function($id){
            (new ProductController())->deleteProduct($id);
        });

        Router::add('POST', '/DeleteProduct/:id', function($id){
            (new ProductController())->DeleteProduct($id);
            
        });

        // Order Router

        Router::add('POST', '/createOrder', function(){
            (new OrderController())->createOrder();
            (new OrderLineController())->createOrderLine();  
        });

        Router::add('GET', '/createOrder', function(){
            (new OrderController())->createOrder();   
            (new OrderLineController())->createOrderLine();  

        });

        Router::add('POST', '/showOrders', function(){
            (new OrderController())->showOrders();
        });

        Router::add('GET', '/showOrders', function(){
            (new OrderController())->showOrders();
        });


        Router::add('POST', '/FilterProducts', function(){
            (new ProductController())->FilterProducts();
        });

        Router::add('GET', '/FilterProducts', function(){
            (new ProductController())->FilterProducts();
        });

        // Order Line

        Router::add('POST', '/AllOrderLine', function(){
            (new OrderLineController())->AllOrderLine();
        });

        Router::add('GET', '/AllOrderLine', function(){
            (new OrderLineController())->AllOrderLine();
        });



        

        /* Cart Routes */
        Router::add('POST', '/ShowCart', function(){
            (new CartController())->AddCart();
        });

        Router::add('GET', '/ShowCart', function(){
            (new CartController())->ShowCart();
        });

        Router::add('GET', '/AddCart', function(){
            (new CartController())->ShowCart();
        });

        Router::add('POST', '/AddCart', function(){
            (new CartController())->AddCart();
        });

        Router::add('POST', '/updateCart', function(){
            (new CartController())->updateCart();
        });

        Router::add('GET', '/updateCart', function(){
            (new CartController())->updateCart();
        });


        /* Category Routes */

        Router::add('POST','/createCategory', function(){
            (new CategoryController())->createCategory();
        });

        
        Router::add('GET','/createCategory', function(){
            (new CategoryController())->createCategory();
        });

        /* Error Routes */

        Router::add('GET', '/not-found', function(){
            ErrorController::error404();
        });

        Router::dispatch();
    }
}

?>