<?php



declare(strict_types=1);



namespace App\Controllers;

use App\Services\FileManagementService;
use App\Services\ReceiptService;
use App\Services\ValidationService;
use Exception;
use Framework\Template;

class ReceiptController
{

    public function __construct(private Template $template, private ValidationService $validationService, private ReceiptService $receiptService) {}

    public function createView(string $transaction_id)
    {

        echo $this->template->renderView("receipts.create");
    }
    public function create(string $transaction_id)
    {
        $request = array_merge($_POST, $_FILES);
        $this->validationService->uploadReceiptValidate($request);
        $this->receiptService->uploadReceipt($transaction_id, $request['receipt']);
        redirectTo("/");
    }
    public function receiptView(string $transaction_id, string $receipt_id)
    {
        $receipt = $this->receiptService->getReceipt($transaction_id, $receipt_id);
        if (!$receipt) {
            notFound();
        }
        $this->receiptService->read($receipt);
    }
}
