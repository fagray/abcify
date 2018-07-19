<?php 

namespace App\Models;

use Rayms\Models\Model;
use Rayms\Database\Database;

class Wallet extends Model {

    protected $fillableFields = ['wallet_current_balance','wallet_previous_balance'];

    protected $primaryKey = 'wallet_id';

    protected $table = 'wallets';

    public function getBalance($userWallet) : string
    {
        return $userWallet['wallet_current_balance'];
    }

    public function deductWalletBalance($amount, $userWallet) : bool
    {
        $newBalance = (float) $this->getBalance($userWallet) - (float) $amount;
        $this->updateBalance($newBalance, $userWallet);
        return true;
    }

    public function updateBalance($newBalance, $userWallet) : bool
    {
        $this->update([
                'wallet_current_balance' => $newBalance,
                'wallet_previous_balance' => $this->getBalance($userWallet)
            ],
            [ 'wallet_id' => $userWallet['wallet_id'] ]);   
        return true;
    }

}

