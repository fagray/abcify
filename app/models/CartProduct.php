<?php 

namespace App\Models;

use Rayms\Models\Model;
use Rayms\Database\Database;
use App\Models\Cart;
use App\Models\User;

class CartProduct extends Model {

    protected $fillableFields = ['product_id','qty','cart_id','price'];

    protected $primaryKey = 'cart_product_id';

    protected $table = 'cart_products';

    public function isAlreadyOnCart($product,$cart) : bool
    {
        $row = $this->where(['product_id'   => $product, 'cart_id' => $cart]);
        if (count($row) > 0)
        {
            return true;
        }
        return false;
    }

    public function updateQtyInstead($product, $qty) : bool
    {
        $cart = (new User)->cart();
        $productCart = $this->where(['product_id' => $product, 'cart_id' => $cart]);
        $newQty = (float) $qty + (float) $productCart[0]['qty']; 
        $result = $this->update(
            ['qty'      => $newQty],
            [
                'product_id'    =>      $product,
                'cart_id'       =>      $cart
            ]
        );
        return true;
    }

    public function getCartProducts($cartId) : array
    {
        $sql = "SELECT * FROM {$this->table} as cp LEFT JOIN products as p ";
        $sql .= "ON cp.product_id = p.product_id WHERE cp.cart_id = {$cartId}  ";
        $stmt = Database::getConnection()->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getAllWithCompleteProductMetadata() : array
    {
        $sql = "SELECT * FROM {$this->table} as c LEFT JOIN products as p ";
        $sql .= "ON c.product_id = p.product_id ";
        $stmt = Database::getConnection()->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function empty() : bool
    {
        $sql = "DELETE FROM {$this->table}";
        $stmt = Database::getConnection()->prepare($sql);
        $result = $stmt->execute();
        return $result;

    }

    public function removeFromCart($cartListIndex) : bool
    {
        return $this->delete($cartListIndex);
    }

    public function updateQty($cartListIndex,$newQty) : bool
    {
        return $this->update(['qty' => $newQty],['cart_product_id' => $cartListIndex]);
    }


}

