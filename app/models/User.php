<?php 

namespace App\Models;

use Rayms\Models\Model;
use Rayms\Database\Database;
use App\Models\Cart;
use App\Models\Wallet;
use App\Models\Transaction;

class User extends Model {

    protected $fillableFields = ['name','username','password'];

    protected $primaryKey = 'user_id';

    protected $table = 'users';

    /**
     * Determines if the user has an existing cart
     *
     * @return     boolean  
     */
    public function isAlreadyStrollingACart() : bool
    {
        $shopper = authUser()['user_id'];
        $cart = (new Cart)->findByShopper($shopper);
        var_dump($cart);
        if ( count((array)$cart) > 0 ) 
        {
            return $cart;
       }
       return false;
    }

    /**
     * Returns the cart of the user
     *
     * @return     boolean  
     */
    public function cart() : bool
    {
        $shopper = authUser()['user_id'];
       return (new Cart)->findByShopper($shopper);
        
    }

    /**
     * Returns the existing cart of the user
     *
     * @return     array  
     */
    public function pullACart() : bool
    {
        $data = ['user_id' => authUser()['user_id'],'cart_status' => 'open'];
        return (new Cart)->create($data);
    }

    /**
     * Returns the user wallet
     *
     * @return     boolean  
     */
    public function wallet()
    {
        $wallet = (new Wallet)->findByColumn('user_id', authUser()['user_id']);
        if ($wallet)
        {
            return $wallet;
        }
        return false;
    }

    /**
     * Returns the transaction list of the user
     */
    public function transactions() : array
    {
        return (new Transaction)->grabUserTransactions();
    }


    /**
     * Authenticate the user
     *
     * @param      string   $user   
     *
     * @return     boolean  
     */
    public function authenticate($user) : array
    {   
        return $this->where(['username' => $user['username'],'password' => $user['password']]) ;
    }

}

