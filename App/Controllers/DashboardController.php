<?php



declare(strict_types=1);



namespace App\Controllers;

use App\Services\TransactionService;
use Framework\Template;

class DashboardController
{

    public function __construct(private Template $template, private TransactionService $transactionService) {}

    public function index()
    {
        $transactions =  $this->transactionService->getTransactions();

        echo $this->template->renderView("dashboard", ['title' => "Dashboard", "transactions" => $transactions]);
    }
}
