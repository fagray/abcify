<?php 

namespace App\Controllers;

use Rayms\View\View;
use App\Models\Transaction;
use App\Models\User;

class TransactionsController {

	private $transaction;
	private $user;

	public function __construct()
	{
		$this->transaction = new Transaction;
		$this->user = new User;
	}

	public function index()
	{
		$transactions  =  $this->user->transactions();
		$view = new View('transactions/index.php');
		$view->assign('transactions',$transactions);
	}

}

