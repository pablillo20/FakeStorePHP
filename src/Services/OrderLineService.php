<?php
namespace Services;
use Repositories\OrderLineRepository;
use Models\Order;
use Models\OrderLine;

class OrderLineService{

    private OrderLineRepository $OrderLineRepository;
    
    public function __construct(){
        $this->OrderLineRepository = new OrderLineRepository();
    }

    public function CreateOrderLine(OrderLine $orderLine): bool{
        return $this->OrderLineRepository->CreateOrderLine($orderLine);
    }

    public function AllOrderLine (): array{
        return $this->OrderLineRepository->AllOrderLine();
    }
}