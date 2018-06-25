<?php 

namespace Rayms\Database;

class Database
{
    /**
     * Return the database connection instance
     *
     * @return     \     The connection instance
     */
    public static function getConnection()
    {
        $host       = config('DB_HOST');
        $username   = config('DB_USERNAME');
        $dbName     = config('DB_DATABASE');
        $pass       = config('DB_PASSWORD');

        try {
            return  new \PDO("mysql:host={$host};dbname={$dbName}", $username, $pass);
        }
        // handle connection error
        catch(\PDOException $exception){
            echo "Connection error: " . $exception->getMessage();
        }
    }
}