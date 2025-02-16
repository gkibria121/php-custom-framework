<?php



declare(strict_types=1);



namespace App\Controllers;

use App\Services\TransactionService;
use App\Services\ValidationService;
use Framework\Template;

class TransactionController
{

    public function __construct(private Template $template, private ValidationService $validationService, private TransactionService $transactionService) {}

    public function createView()
    {
        echo $this->template->renderView("transactions.create", ['title' => "Dashboard"]);
    }
    public function create()
    {
        $this->validationService->transactionValidate($_POST);
        $this->transactionService->addTransaction($_POST);
    }
}
