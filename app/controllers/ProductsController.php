<?php 

namespace App\Controllers;

use Rayms\View\View;
use App\Models\Product;
use App\Models\Auth;

class ProductsController {

	private $product;
	private $auth;

	public function __construct()
	{
		$this->product = new Product;
		$this->auth = new Auth;
	}

	/**
	 * Show the listings of all resource
	 * @return  mixed
	 */
	public function index()
	{
		return json($this->product->all());	
	}

	/**
	 * Store the newly created resource
	 * @return  mixed
	 */
	public function rate($productId)
	{
		if ( ! $this->auth->authorize() )
		{
			return json(['msg' => 'Unauthorized', 'code' => 401]);
		}
		$rating = $_POST['rating'];
		$this->product->rate($productId, $rating);
		return json(['msg' => 'Rating has been added !','code' => 200]);
	}

}

