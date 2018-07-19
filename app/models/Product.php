<?php 

namespace App\Models;

use Rayms\Models\Model;

class Product extends Model {

    protected $fillableFields = ['product_name','product_price','product_desc','product_rating'];

    protected $primaryKey = 'product_id';

    protected $table = 'products';

    public function rate($productId, $rating) : bool
    {
        (new ProductRating)->create([
                'user_id'       => authUser()['user_id'],
                'product_id'    => $productId,
                'rating'        => $rating
            ]);
        $averageRating = (new ProductRating)->getAverageRating($productId);
        $this->update(['product_rating' => $averageRating],['product_id' => $productId]);
        return true;
    }


}

