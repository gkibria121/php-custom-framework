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
        redirectTo("/");
    }
    public function index()
    {
        $limit = 5;
        $currentPage = (int)($_GET['p'] ?? 1);

        $searchQueryString = addcslashes($_GET['s'] ?? '', "%_");

        [$transactions, $total] =  $this->transactionService->getUserTransactions($currentPage, $limit, $searchQueryString);

        $totalPages = ceil($total / $limit);

        $previousPage  = max($currentPage - 1, 1);
        $nextPage   =  min($currentPage + 1, $totalPages);

        echo $this->template->renderView("dashboard", [
            'title' => "Dashboard",
            "transactions" => $transactions,
            'total' => $totalPages,
            "previous" =>  $previousPage . "&s=$searchQueryString",
            "next" => $nextPage . "&s=$searchQueryString",
        ]);
    }
    public function editView(string $id)
    {

        $transaction  =  $this->transactionService->getUserTransaction((int) $id);

        if (!$transaction) {
            notFound();
        }
        echo $this->template->renderView("transactions.edit", [
            'title' => "Dashboard",
            "transaction" => $transaction,

        ]);
    }
}
