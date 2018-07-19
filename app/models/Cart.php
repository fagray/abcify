<?php 

namespace App\Models;

use Rayms\Models\Model;
use Rayms\Database\Database;
use App\Models\CartProduct;
use App\Models\User;

class Cart extends Model {

    protected $fillableFields = ['user_id','cart_status'];

    protected $primaryKey = 'cart_id';

    protected $table = 'shopping_carts';

    public function getAllWithCompleteProductMetadata() : array
    {

        $sql = "SELECT * FROM {$this->table} as c LEFT JOIN products as p ";
        $sql .= "ON c.product_id = p.product_id ";
        $stmt = Database::getConnection()->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function listProducts() : array
    {
        $cartId = $this->findByShopper(authUser()['user_id']);
       return (new CartProduct)->getCartProducts($cartId);
    }


    public function findByShopper($shopper) : bool
    {
        $cart = $this->where(['user_id' => $shopper,'cart_status' => 'open']);
        if ( $cart != null  ){
            return $cart[0]['cart_id'];
        }
        return false;
        
    }

    public function loadNew($product) : bool
    {
        return (new CartProduct)->create($product);
    }

    public function getProduts($cartId) : array
    {
        $sql = "SELECT * FROM cart_products as cp LEFT JOIN products as p ";
        $sql .= "ON cp.product_id = p.product_id ";
        $stmt = Database::getConnection()->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function empty() : bool
    {
        $cart = (new User)->cart();
        $this->update(['cart_status' => 'closed'], ['cart_id' => $cart]);
        $stmt = Database::getConnection()->prepare($sql);
        $result = $stmt->execute();
        return $result;

    }


}

