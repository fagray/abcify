<?php 

namespace App\Controllers;

use Rayms\View\View;
use App\Models\Product;
use App\Models\Auth;
use App\Presenters\JSONResponse;

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
	public function index() : JSONResponse
	{
		return new JSONResponse($this->product->all());	
	}

	/**
	 * Store the newly created resource
	 * @return  mixed
	 */
	public function rate($productId) : JSONResponse
	{
		if ( ! $this->auth->authorize() )
		{
			return new JSONResponse(['msg' => 'Unauthorized', 'code' => 401]);
		}
		$rating = input('rating');
		$this->product->rate($productId, $rating);
		return new JSONResponse(['msg' => 'Rating has been added !','code' => 200]);
	}

}

