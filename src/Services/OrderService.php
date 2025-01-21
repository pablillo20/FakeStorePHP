<?php
namespace Services;
use Repositories\OrderRepository;
use Models\Order;

class OrderService{

    private OrderRepository $OrderRepository;
    
    public function __construct(){
        $this->OrderRepository = new OrderRepository();
    }

    public function CreateOrder(Order $order): bool{
        return $this->OrderRepository->CreateOrder($order);
    }

    public function getLastInsertId(): int {
        return $this->OrderRepository->getLastInsertId();
    }

    public function getOrdersByUser(int $userId): array {
        return $this->OrderRepository->getOrdersByUserId($userId);
    }
}