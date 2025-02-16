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
        $limit = 5;
        $currentPage = (int)($_GET['p'] ?? 1);

        $description = addcslashes($_GET['s'] ?? '', "%_");
        [$transactions, $total] =  $this->transactionService->getUserTransactions($currentPage, $limit, $description);
        $totalPage = ceil($total / $limit);

        $previousPage  = max($currentPage - 1, 1);
        $nextPage   =  min($currentPage + 1, $totalPage);

        echo $this->template->renderView("dashboard", [
            'title' => "Dashboard",
            "transactions" => $transactions,
            'total' => $totalPage,
            "previous" =>  $previousPage . "&s=$description",
            "next" => $nextPage . "&s=$description",
        ]);
    }
}
