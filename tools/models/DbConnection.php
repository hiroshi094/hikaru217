<?php
namespace tools;

use tools\config as config;

/**
 * DB Connectionを管理するクラス
 * @copyright Copyright (C) 2014 Ispro. All Rights Reserved.
 */
class DbConnection
{
    /** @var string dbServer */
    private $dbServer;
    /** @var string dbName */
    private $dbName;
    /** @var string username */
    private $userName;
    /** @var string password */
    private $password;

    /** @var bool hasError */
    public $hasError;

    public function __construct()
    {
        $this->hasError = $this->getConfig() === false;
    }

    public function getConfig()
    {
        $dbConfigFile = config::param()['documentRoot'] . 'json/db_connections.json';
        if (file_exists($dbConfigFile)) {
            $json = file_get_contents($dbConfigFile);
            $dbConnection = json_decode($json, true);
            $this->dbServer = $dbConnection[0]['dbServer'];
            $this->dbName   = $dbConnection[0]['dbName'];
            $this->userName = $dbConnection[0]['username'];
            $this->password = $dbConnection[0]['password'];
            try {
                $pdo = new \PDO($this->dbConnectionString(), $this->userName, $this->password);
            } catch (\PDOException $e) {
                return false;
            }
            return true;
        }
        return false;
    }

    /**
     * queryを実行して結果を配列にして返却する
     *
     * @param string $sql
     * @return array
     */
    public function queryAllBySql(string $sql)
    {
        $pdo = new \PDO($this->dbConnectionString(), $this->userName, $this->password);
        $sqlResult = $pdo->query($sql);

        $result = array();
        while ($row = $sqlResult->fetch(\PDO::FETCH_ASSOC)) {
            $result[] = $row;
        }
        $pdo = null;
        return $result;
    }

    /**
     * queryを実行して結果を配列にして返却する
     *
     * @param string $sql
     * @return array
     */
    public function execute(string $sql)
    {
        $pdo = new \PDO($this->dbConnectionString(), $this->userName, $this->password);
        $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_SILENT);

        $command = $pdo->prepare($sql);
        $result = $command->execute();

        $pdo = null;
        $command = null;
        return $result;
    }

    public function getDbServer()
    {
        return $this->dbServer;
    }

    public function getDbName()
    {
        return $this->dbName;
    }

    private function dbConnectionString()
    {
        return 'mysql:dbname=' . $this->dbName . ';host=' . $this->dbServer . ';charset=utf8';
    }

    public function getUserName()
    {
        return $this->userName;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public static function saveConfig($dbServer, $dbName, $username, $password)
    {
        $dbConnectionString = 'mysql:dbname=' . $dbName . ';host=' . $dbServer . ';charset=utf8';
        try {
            $pdo = new \PDO($dbConnectionString, $username, $password);
        } catch (\Exception $e) {
            return false;
        }

        if ($pdo instanceof \PDO) {
            $dbConnectionList[] = array(
                'dbServer' => $dbServer,
                'dbName'   => $dbName,
                'username' => $username,
                'password' => $password
            );
            $json = json_encode(
                $dbConnectionList,
                JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE
            );
            file_put_contents('../json/db_connections.json', $json);
        }
        $dbConnection = new self();
        return $dbConnection;
    }
}
