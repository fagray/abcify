<?php 

namespace App\Models;

use Rayms\Models\Model;
use Rayms\Database\Database;

class ProductRating extends Model {

    protected $fillableFields = ['user_id','product_id','rating'];

    protected $primaryKey = 'product_id';

    protected $table = 'product_ratings';

    public function getAverageRating($productId) : double
    {
        $sql = "SELECT SUM(rating) as average_rating, COUNT(rating) as rating_count FROM {$this->table} WHERE product_id = {$productId}";
        $stmt = Database::getConnection()->prepare($sql);
        $stmt->execute();
        $row =  $stmt->fetch(\PDO::FETCH_ASSOC);
        $averageRating = $row['average_rating'] / $row['rating_count'];
        return number_format($averageRating,1);
    }

}

