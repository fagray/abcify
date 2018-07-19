<?php 

namespace App\Controllers;

use Rayms\View\View;
use App\Models\Product;

class HomeController {

	private $product;

	public function __construct()
	{
		$this->product = new Product;
	}

	/**
	 * Show all products
	 * @return  mixed
	 */
	public function index() : boolean
	{
		$products = $this->product->all();
		$view = new View('products/index.php');
		$view->assign('products',$products);
		return true;
	
	}
}

