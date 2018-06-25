<?php 

namespace App\Controllers;

use Rayms\View\View;
use App\Models\Cart;
use App\Models\CartProduct;
use App\Models\Transaction;
use App\Models\Wallet;
use App\Models\User;
use App\Models\Auth;

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
	 * @return  mixed
	 */
	public function index()
	{
		return json($this->cart->listProducts());
	}

	/**
	 * Store the newly created resource
	 * @return  mixed
	 */
	public function startShopping()
	{
		if ( ! $this->auth->authorize() )
		{
			return json(['msg' => 'Unauthorized', 'code' => 401]);
		}
		$productId 	= 		$_POST['product_id'];
		$qty		= 		$_POST['qty'];
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
				'product_id' 		=>		$_POST['product_id'],
				'qty' 				=> 		$_POST['qty'],
				'price' 			=> 		$_POST['price']
			];
		if ($this->cartProduct->isAlreadyOnCart($productId,$cart))
		{
			$this->cartProduct->updateQtyInstead($productId,$qty);
			return json(['msg' => 'Cart has been updated!','code' => 200]);
		}
		$this->cart->loadNew($product);
		return json(['msg' => 'Product has been added to cart!','code' => 200]);
	}

	public function show()
	{
		$productsOnCart = $this->cart->listProducts();
		$view = new View('cart/view.php');
		$view->assign('productsOnCart',$productsOnCart);
	}

	public function checkout()
	{
		$transactionCost = $_POST['transaction_cost'];
		$userWallet = $this->user->wallet();
		if ( ! $this->walletHasEnoughCashForThis($transactionCost, $userWallet))
		{
			return json(['msg' => 'Insufficient cash!','code' => 500]);
		}
		
		$transactionData = [
			'wallet_id'				=>		$userWallet['wallet_id'],
			'transaction_cost'		=>		$_POST['transaction_cost'],
			'transaction_date'		=>		date('Y-m-d g:i:a '),
			'shipping_method'		=>		$_POST['shipping_method'],
			'shipping_cost'			=>		$_POST['shipping_cost']
		];
		$this->storeTransaction($transactionData)
			->deductWalletBalance($transactionCost,$userWallet)
			->andEmptyCart();

		return json(['msg' => 'Transaction completed!','code' => 200]);
	}

	public function walletHasEnoughCashForThis($transactionCost, $userWallet)
	{
		if ( (float) $userWallet['wallet_current_balance'] >= $transactionCost )
		{
			return true;
		}
		return false;
	}

	public function storeTransaction($transactionData)
	{
		$this->transaction->create($transactionData);
		return $this;
	}

	public function deductWalletBalance($amount,$userWallet)
	{
		$this->wallet->deductWalletBalance($amount,$userWallet);
		return $this;
	}

	public function andEmptyCart()
	{
		$this->cart->empty();
	}

	public function removeProduct($cartListIndex)
	{
		if ($this->cartProduct->removeFromCart($cartListIndex))
		{
			return json(['msg' => 'Product has been removed from cart!','code' => 200]);
		}
		return json(['msg' => 'Error removing product from cart!','code' => 500]);
	
	}
	public function updateProductQty($cartListIndex)
	{
		$newQty = $_POST['new_qty'];
		if ($this->cartProduct->updateQty($cartListIndex,$newQty))
		{
			return json(['msg' => 'Product qty has been updated!','code' => 200]);
		}
		return json(['msg' => 'Error updating product qty!','code' => 500]);
	
	}

}

