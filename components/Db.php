<?php

class Db
{
    public static function getConnection()
    {
        $confPath = ROOT . '/config/conf.php';
        $params = include($confPath);
        $dsn = "mysql:host={$params["host"]};dbname={$params['dbname']}";

        try {
            $pdo = new PDO($dsn, $params['user'], $params['password']);
        } catch (PDOException $e) {
            die("set config variable to connections mysql in $confPath ");
        }

        if (!Db::tableExists($pdo, "url")) Db::createDb($pdo, "url");

        return $pdo;
    }


    private static function tableExists(PDO $pdo, $tableName)
    {
        $mrSql = "SHOW TABLES LIKE :table_name";
        $mrStmt = $pdo->prepare($mrSql);
        //protect from injection attacks
        $mrStmt->bindParam(":table_name", $tableName, PDO::PARAM_STR);

        $sqlResult = $mrStmt->execute();
        if ($sqlResult) {
            $row = $mrStmt->fetch(PDO::FETCH_NUM);
            return ($row[0]);
        } else {
            //some PDO error occurred
            echo("Could not check if table exists, Error: " . var_export($pdo->errorInfo(), true));
            return false;
        }
    }


    /**
     * @param PDO $db
     * @param $tableName
     */
    private static function createDb(PDO $db, $tableName)
    {
        try {
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $sql = "CREATE TABLE $tableName (
                    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                    url_before VARCHAR(64) NOT NULL,
                    url_after VARCHAR(64) NOT NULL,
                    unix_timestamp TIMESTAMP
                    )";

            $db->exec($sql);
            echo "Table URL created successfully";
        } catch (PDOException $e) {
            echo $sql . "<br>" . $e->getMessage();
        }
    }
}