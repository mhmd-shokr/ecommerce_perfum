<?php
namespace App\Servicies;

use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;

class InvoiceService{

    public function download(Order $order){
        $order->loadMissing([
            'items',
            'address',
            'user',
        ]);

        $pdf=Pdf::loadView('pdf.invoice',[
            'order'=>$order,
        ]);

        return $pdf->download(
            'invoice-'.$order->order_number. '.pdf'
        );
    }
}