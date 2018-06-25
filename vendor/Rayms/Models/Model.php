<?php 

namespace Rayms\Models;

use Rayms\Database\Database;

class Model
{
    private $database;
    protected $table;
    protected $primaryKey = 'id';
    protected $fillableFields = [];

    /**
     * Store resource on the storage
     *
     * @param      array   $attributes  The attributes
     *
     * @return     <type>  ( description_of_the_return_value )
     */
    public function create($attributes = [])
    {
        $attributes = sanitizeAttributes($attributes);
        $sql  = $this->formulateQueryFor('insert',$attributes);
        $stmt = Database::getConnection()->prepare($sql);
        return $this->getResultOf($stmt);
    }

    /**
     * Return all resource from the storage
     *
     * @return       array
     */
    public function all()
    {
        $sql = "SELECT * FROM {$this->table} ";
        $stmt = Database::getConnection()->prepare($sql);
        $result =  $this->getResultOf($stmt);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * Find resource by its identifier
     *
     * @param      int  $identifier  
     *
     * @return       array
     */
    public function find($identifier)
    {
        $sql = "SELECT * FROM {$this->table} WHERE {$this->primaryKey} = {$identifier}";
        $stmt = Database::getConnection()->prepare($sql);
        $result = $this->getResultOf($stmt);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    /**
     * Find resource by means of its attributes
     *
     * @param      array   $atributes  
     *
     * @return       array
     */
    public function where($attributes = [])
    {
        $valuePairs = [];
        $counter = 0;
        foreach($attributes as $key => $value) 
        {
            if (  $counter <= count($attributes) -2   )
            {
                $valuePairs[] = "{$key}='{$value}' AND ";
            }else 
            {
                $valuePairs[] = "{$key}='{$value}' ";
            }
            $counter++;
        }
        $sql = $this->formulateQueryFor('where',$valuePairs);
        $stmt = Database::getConnection()->prepare($sql);
        $result = $this->getResultOf($stmt);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    /**
     * Find resource by a single attribute
     *
     * @param      string  $column  
     * @param      string  $value   
     *
     * @return       array
     */
    public function findByColumn($column, $value)
    {
        $sql = "SELECT * FROM {$this->table} WHERE {$column} = {$value}";
        $stmt = Database::getConnection()->prepare($sql);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    /**
     * Update a specified resource on the storage
     *
     * @param      array    $atributes  
     * @param      array    $values     
     *
     * @return     boolean  
     */
    public function update($atributes = [], $values = [])   
    {
        $attributePairs = [];
        $valuePairs = [];
        $attributes = sanitizeAttributes($atributes);
        foreach($attributes as $key => $value) 
        {
            $attributePairs[] = "{$key}='{$value}'";
        }
        $counter = 0;
        foreach($values as $key => $value) 
        {
            if (  $counter <= count($values) -2    )
            {
                $valuePairs[] = "{$key}='{$value}' AND";
            }else 
            {
                $valuePairs[] = "{$key}='{$value}'";
            }
            $counter++;
        }
        $sql = $this->formulateQueryFor('update',$attributePairs, $valuePairs);
        $stmt = Database::getConnection()->prepare($sql);
        return $this->getResultOf($stmt);
    }

    public function delete($cartListIndex)
    {
        $sql = "DELETE FROM {$this->table} WHERE {$this->primaryKey} = {$cartListIndex}";
        $stmt = Database::getConnection()->prepare($sql);
        return $this->getResultOf($stmt);
    }

    public function getResultOf($stmt)
    {
        $result = $stmt->execute();
        if( $result )
        {
            return true;
        }
        if ( ! $result )
        {
            $databaseErrors = $stmt->errorInfo();
            $errorInfo = print_r($databaseErrors, true);
            echo $errorLogMsg = "error info: $errorInfo"; 
            exit();
        }
        return $result;
    }

    public function formulateQueryFor($stmt, $attributePairs, $valuePairs = [])
    {
        $sql = null;
        switch ($stmt) {

            case 'insert':
                $sql = "INSERT INTO {$this->table} (";
                $sql .= join(", ", array_keys($attributePairs));
                $sql .= ") VALUES ('";
                $sql .= join("', '", array_values($attributePairs));
                $sql .= "')";
                break;

            case 'where':
                $sql = "SELECT * FROM {$this->table} WHERE ";
                $sql .= join(" ", $attributePairs);
                break;

            case 'update':
                $sql = "UPDATE {$this->table} SET ";
                $sql .= join(", ", $attributePairs);
                $sql .= " WHERE ";
                $sql .= join(" ", $valuePairs);
                break;
            
            default:
                # code...
                break;
        }
       return $sql;
    }


}

