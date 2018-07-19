<?php 

namespace App\Models;

use Rayms\Models\Model;
use Rayms\Database\Database;

class Transaction extends Model {

    protected $fillableFields = ['wallet_id','transaction_cost','transaction_date','shipping_method','shipping_cost'];

    protected $primaryKey = 'transaction_id';

    protected $table = 'transactions';

    public function grabUserTransactions() : array
    {
        $userId = authUser()['user_id'];
        $sql = "SELECT * FROM {$this->table} as t LEFT JOIN wallets as w ";
        $sql .= "ON t.wallet_id = w.wallet_id LEFT JOIN users as u ";
        $sql .= "ON w.user_id = u.user_id ";
        $sql .= "WHERE u.user_id = {$userId} ORDER BY t.transaction_id DESC";
        $stmt = Database::getConnection()->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

}

