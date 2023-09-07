<?php

namespace App\Services;

use App\Http\Resources\OrderResource;
use Barryvdh\DomPDF\Facade\Pdf;
use Exception;
use Illuminate\Support\Facades\File;

class PdfFileService
{
    protected $fileCloudService;

    public function __construct(FileCloudService $fileCloudService)
    {
        $this->fileCloudService = $fileCloudService;
    }

    public function makePdfOrderDetail($order)
    {
        $data['subtotal'] = 0;
        $data['order'] = json_decode((new OrderResource($order))->toJson());
        try {
            $pdf = Pdf::loadView('pdf-template.order-detail', $data)->setPaper('a4', 'landscape');
            $pdfFilePath = tempnam(sys_get_temp_dir(), 'pdf');
            $pdf->save($pdfFilePath);

            $datafile = [
                'name' => 'pdf',
                'Mime-Type' => 'application/pdf',
                'contents' =>  fopen($pdfFilePath, 'r')
            ];

            $res = $this->fileCloudService->storeFile($datafile, "public/tenants/{$order->tenant->uuid}/order/{$order->identify}", 'pdf');

            File::delete($pdfFilePath);

            return $res;
        } catch (Exception $e) {
            // throw new Exception ($e->getMessage());
        }
    }
}   
