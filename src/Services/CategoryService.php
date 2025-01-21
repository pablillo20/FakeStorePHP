<?php
namespace Services;

use Models\Category;
use Repositories\CategoryRepository;
use Models\Product;

class CategoryService{

    private CategoryRepository $CategoryRepository;
    
    public function __construct(){
        $this->CategoryRepository = new CategoryRepository();
    }

    public function registerCategory (Category $category): void{
        $this->CategoryRepository->registerCategory($category);
    }   

    public function getAllCategories(): array {
        return $this->CategoryRepository->getAllCategories();
    }
    
    
}