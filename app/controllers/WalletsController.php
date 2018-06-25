<?php 

namespace App\Controllers;

use Rayms\View\View;
use App\Models\Wallet;
use App\Models\User;

class WalletsController {

	private $wallet;
	private $user;

	public function __construct()
	{
		$this->wallet = new Wallet;
		$this->user = new User;
	}

	public function getBalance()
	{
		$userWallet = $this->user->wallet();
		return json(['wallet_balance' => $userWallet['wallet_current_balance']]);
	}

}

