<?php 

namespace App\Models;

use Rayms\Models\Model;
use Rayms\Database\Database;

class Wallet extends Model {

    protected $fillableFields = ['wallet_current_balance','wallet_previous_balance'];

    protected $primaryKey = 'wallet_id';

    protected $table = 'wallets';

    public function getBalance($userWallet)
    {
        return $userWallet['wallet_current_balance'];
    }

    public function deductWalletBalance($amount, $userWallet)
    {
        $newBalance = (float) $this->getBalance($userWallet) - (float) $amount;
        $this->updateBalance($newBalance, $userWallet);
    }

    public function updateBalance($newBalance, $userWallet)
    {
        $this->update([
                'wallet_current_balance' => $newBalance,
                'wallet_previous_balance' => $this->getBalance($userWallet)
            ],
            [ 'wallet_id' => $userWallet['wallet_id'] ]);   
        return;
    }

}

