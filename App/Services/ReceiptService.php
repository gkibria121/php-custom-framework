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
    public function getReceipt(string $transaction_id, string $receipt_id)
    {
        $this->db->query("SELECT * FROM receipts WHERE transaction_id = :transaction_id AND id = :id", [
            'transaction_id' => $transaction_id,
            'id' => $receipt_id
        ]);
        return $this->db->fetch()->get();
    }
    public function read(array $receipt)
    {
        $file = [
            'name' => $receipt['name'],
            'path' => Paths::$STORAGE_DIR . "/uploads/" . $receipt['path'],
            'mimeType' => $receipt['mimeType'],
        ];

        $this->fileManagerAction->readFile($file);
    }
}
