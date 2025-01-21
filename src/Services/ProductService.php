<?php
namespace Services;
use Repositories\ProductRepository;
use Models\Product;

class ProductService{

    private ProductRepository $ProductRepository;
    
    public function __construct(){
        $this->ProductRepository = new ProductRepository();
    }
    
    public function registerProduct (Product $product): void{
        $this->ProductRepository->registerProduct($product);
    }   

    public function getAllProducts(): array{
        return $this->ProductRepository->getAllProducts();
    }

    public function getProductById(int $id): Product|bool{
        return $this->ProductRepository->getProductById($id);
    }

    public function updateProduct(Product $product): void {
        $this->ProductRepository->updateProduct($product);
    }

    public function getProductsByCategoryId(int $categoryId): array {
        return $this->ProductRepository->getProductsByCategoryId($categoryId);
    }

    public function DeleteProduct(int $id): bool{
        return $this->ProductRepository->DeleteProduct($id);
    }

    public function decreaseStock(int $productId, int $quantity): void {
        $product = $this->getProductById($productId);
        if ($product) {
            $product->setStock($product->getStock() - $quantity);
            $this->updateProduct($product);
        }
    }
}