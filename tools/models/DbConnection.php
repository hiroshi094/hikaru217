<?php
namespace tools;

/**
 * DB Connectionを管理するクラス
 * @copyright Copyright (C) 2014 Ispro. All Rights Reserved.
 */
class DbConnection
{
    /** @var array dbConnectionList */
    protected $dbConnectionList = array();

    public function __construct()
    {
    }

    public function save($dbServer, $dbName, $username, $password)
    {
        $this->dbConnectionList[] = array(
            'dbServer' => $dbServer, 
            'dbName' => $dbName, 
            'username' => $username, 
            'password' => $password
        );
        $json = json_encode(
            $this->dbConnectionList, 
            JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE
        );
        file_put_contents('json/db_connections.json', $json);
    }

    public function getConnection()
    {
        $json = file_get_contents('json/db_connections.json');
        return json_decode($json, true);
    }
}
