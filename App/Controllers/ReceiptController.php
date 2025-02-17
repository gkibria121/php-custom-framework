<?php



declare(strict_types=1);



namespace App\Controllers;


use App\Services\ValidationService;
use Framework\Template;

class ReceiptController
{

    public function __construct(private Template $template, private ValidationService $validationService) {}

    public function createView(string $transaction_id)
    {

        echo $this->template->renderView("receipts.create");
    }
    public function create(string $transaction_id)
    {
        $request = array_merge($_POST, $_FILES);
        $this->validationService->uploadReceiptValidate($request);
        dd("validation passed!");
    }
}
