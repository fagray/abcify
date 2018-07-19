<?php 

namespace App\Controllers;

use Rayms\View\View;
use App\Models\Cart;
use App\Models\CartProduct;
use App\Models\Transaction;
use App\Models\Wallet;
use App\Models\User;
use App\Models\Auth;
use App\Presenters\JSONResponse;

class CartController {

	private $cart;
	private $cartProduct;
	private $transaction;
	private $wallet;
	private $user;
	private $auth;

	public function __construct()
	{

		$this->cart = new Cart;
		$this->cartProduct = new CartProduct;
		$this->transaction = new Transaction;
		$this->wallet = new Wallet;
		$this->user = new User;
		$this->auth = new Auth;
	}

	/**
	 * Show the listings of products in a cart
	 * @return  JSONResponse
	 */
	public function index() : JSONResponse
	{
		return new JSONResponse($this->cart->listProducts());
	}

	/**
	 * Start shopping 
	 * @return  JSONResponse
	 */
	public function startShopping() : JSONResponse
	{
		if ( ! $this->auth->authorize() )
		{
			return new JSONResponse(['msg' => 'Unauthorized', 'code' => 401]);
		}
		$productId 	= 		input('product_id');
		$qty		= 		input('qty');
		if ( $this->user->isAlreadyStrollingACart() )
		{
			$cart = $this->user->cart();
		}else 
		{
			$this->user->pullACart();
			$cart = $this->user->cart();
		}
		$product = [
				'cart_id' 			=> 		$cart,
				'product_id' 		=>		input('product_id'),
				'qty' 				=> 		input('qty'),
				'price' 			=> 		input('price')
			];
		if ($this->cartProduct->isAlreadyOnCart($productId,$cart))
		{
			$this->cartProduct->updateQtyInstead($productId,$qty);
			return new JSONResponse(['msg' => 'Cart has been updated!','code' => 200]);
		}
		$this->cart->loadNew($product);
		return new JSONResponse(['msg' => 'Product has been added to cart!','code' => 200]);
	}

	public function show() : bool
	{
		$productsOnCart = $this->cart->listProducts();
		$view = new View('cart/view.php');
		$view->assign('productsOnCart',$productsOnCart);
		return true;
	}

	public function checkout() : JSONResponse
	{
		$transactionCost = input('transaction_cost');
		$userWallet = $this->user->wallet();
		if ( ! $this->walletHasEnoughCashForThis($transactionCost, $userWallet))
		{
			return new JSONResponse(['msg' => 'Insufficient cash!','code' => 500]);
		}
		
		$transactionData = [
			'wallet_id'				=>		$userWallet['wallet_id'],
			'transaction_cost'		=>		input('transaction_cost'),
			'transaction_date'		=>		date('Y-m-d g:i:a '),
			'shipping_method'		=>		input('shipping_method'),
			'shipping_cost'			=>		input('shipping_cost')
		];
		// store the transaction
		$this->storeTransaction($transactionData);
		// deduct the balance
		$this->deductWalletBalance($transactionCost,$userWallet);
		// then, empty cart
		$this->emptyCart();

		return new JSONResponse(['msg' => 'Transaction completed!','code' => 200]);
	}

	public function walletHasEnoughCashForThis($transactionCost, $userWallet) : bool
	{
		if ( (float) $userWallet['wallet_current_balance'] >= $transactionCost )
		{
			return true;
		}
		return false;
	}

	/**
	 * Stores a transaction.
	 *
	 * @param      array     $transactionData  
	 *
	 * @return     boolean 
	 */
	public function storeTransaction($transactionData) : bool
	{
		$this->transaction->create($transactionData);
		return true;
	}

	public function deductWalletBalance($amount,$userWallet) : bool
	{
		$this->wallet->deductWalletBalance($amount,$userWallet);
		return true;
	}

	/**
	 * Empty the cart
	 */
	public function emptyCart() : bool
	{
		$this->cart->empty();
		return true;
	}

	public function removeProduct($cartListIndex) : JSONResponse
	{
		if ($this->cartProduct->removeFromCart($cartListIndex))
		{
			return new JSONResponse(['msg' => 'Product has been removed from cart!','code' => 200]);
		}
		return new JSONResponse(['msg' => 'Error removing product from cart!','code' => 500]);
	
	}
	public function updateProductQty($cartListIndex) : JSONResponse
	{
		$newQty = input('new_qty');
		if ($this->cartProduct->updateQty($cartListIndex,$newQty))
		{
			return new JSONResponse(['msg' => 'Product qty has been updated!','code' => 200]);
		}
		return new JSONResponse(['msg' => 'Error updating product qty!','code' => 500]);
	
	}

}

