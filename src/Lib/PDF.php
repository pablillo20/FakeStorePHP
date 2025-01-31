<?php
    namespace Lib;
    USE FPDF;


    class PDF extends FPDF
    {
        function generarPDF($order): string
    {
        $pdf = new Fpdf();
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Cell(0, 10, 'Confirmacion de Pedido', 0, 1, 'C');
        $pdf->Ln(10);
        $pdf->SetFont('Arial', '', 12);

        // Información del pedido
        $pdf->Cell(0, 10, "ID del Pedido: " . $_SESSION['order_id'], 0, 1);
        $pdf->Cell(0, 10, "Usuario: " . $_SESSION['user']['username'], 0, 1);
        $pdf->Cell(0, 10, "Direccion: " . $order->getDireccion(), 0, 1);
        $pdf->Cell(0, 10, "Fecha: " . $order->getFecha(), 0, 1);
        $pdf->Cell(0, 10, "Hora: " . $order->getHora(), 0, 1);
        $pdf->Cell(0, 10, "Total: $" . $order->getCoste(), 0, 1);

        // Detalles de los productos
        $pdf->Ln(10);
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Cell(0, 10, 'Productos:', 0, 1);
        $pdf->SetFont('Arial', '', 12);
        foreach ($_SESSION['cart'] as $product) {
            $pdf->Cell(0, 10, "{$product['nombre']} (x{$product['quantity']}): $" . ($product['precio'] * $product['quantity']), 0, 1);
        }

        // Guardar el PDF en memoria
        return $pdf->Output('S');
    }
}

?>