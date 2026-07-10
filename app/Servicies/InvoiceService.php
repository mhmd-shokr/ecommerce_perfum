<?php
namespace App\Servicies;

use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;

class InvoiceService{

    public function makePdf(Order $order){
        $order->loadMissing([
            'items',
            'address',
            'user',
        ]);

        return Pdf::loadView('pdf.invoice',[
            'order'=>$order,
        ]);
    }

    public function download(Order $order){
        return $this->makePdf($order)->download('invoice-'.$order->order_number.'.pdf');
    }

    public function stream(Order $order)
    {
        return $this->makePdf($order)
            ->stream('invoice-'.$order->order_number.'.pdf');
    }
    public function output(Order $order): string
    {
        return $this->makePdf($order)
            ->output();
    }
}