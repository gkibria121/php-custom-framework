<?php

declare(strict_types=1);


namespace App\Services;

use App\Library\Actions\FileManagerAction;
use Database\Database;
use Framework\Paths;

class ReceiptService
{

    public function __construct(private Database $db, private FileManagerAction $fileManagerAction) {}
    public function uploadReceipt(string $transaction_id, array $file)
    {

        $fileOriginalname = $file['name'];
        $mimeType = mime_content_type(($file['tmp_name']));
        $fileName =  $this->fileManagerAction->store($file, Paths::$STORAGE_DIR . "/uploads");
        $this->db->query("INSERT INTO receipts(transaction_id,name, mimeType,path) VALUES(:transaction_id,:name, :mimeType,:path)", [
            'transaction_id' => $transaction_id,
            'name' => $fileOriginalname,
            'path' => $fileName,
            'mimeType' => $mimeType,
        ]);
    }
}
