<?php
namespace tools;

require_once('DbConnection.php');

use tools\DbConnection as DbConnection;

/**
 * Table Informationを管理するクラス
 */
class TableInformation
{
    /** @var string dbConnection */
    private $dbConnection;
    /** @var array allTableList */
    private $allTableList = [];

    /** @var string データベース名 */
    public $dbName;

    public function __construct()
    {
        $dbConnection = new DbConnection();
        if ($dbConnection->hasError === true) {
            echo '<a href="db_connection.php">データベースに接続してください</a>';
            exit();
        }
        $this->dbConnection = $dbConnection;
        $this->dbName = $dbConnection->getDbName();
        $this->setAllTableList();
    }

    /**
     * テーブル情報を返却する
     *
     * @return array
     */
    public function getTableInformation(string $tableName = '', string $tableComment = '')
    {
        $sql = 'SELECT TABLE_TYPE, TABLE_NAME, ENGINE, TABLE_COMMENT'
        . ' FROM INFORMATION_SCHEMA.TABLES'
        . ' WHERE TABLE_SCHEMA=\'' . $this->dbConnection->getDbName() . '\'';

        if (empty($tableName) === false) {
            $sql .= ' AND TABLE_NAME LIKE \'' . $tableName . '\'';
        }
        if (empty($tableComment) === false) {
            $sql .= ' AND TABLE_COMMENT LIKE \'' . $tableComment . '\'';
        }
        $sql .= ';';
        return $this->dbConnection->queryAllBySql($sql);
    }

    /**
     * table のlistを配列にしておく
     *
     * @return void
     */
    private function setAllTablelist()
    {
        $this->allTableList = [];
        $tableInfo = $this->getTableInformation();
        foreach($tableInfo as $table) {
            $this->allTableList[$table['TABLE_NAME']] = $table;
        }
    }

    /**
     * table名の存在チェック
     *
     * @param string $tableName
     * @return bool
     */
    public function tableExists(string $tableName)
    {
        return isset($this->allTableList[$tableName]);
    }

    /**
     * テーブルのコメントを更新する
     *
     * @param string $tableName
     * @param string $tableComment
     * @return boolean
     */
    public function updateTableComment(string $tableName, string $tableComment)
    {
        $sql = 'SET sql_mode = \'\';';//SQL
        $sql .= 'ALTER TABLE ' . $tableName . ' COMMENT \'' . $tableComment . '\';';

        return $this->dbConnection->execute($sql);
    }

    public function getTableColumns(string $tableName)
    {
        $sql = 'SHOW FULL COLUMNS FROM ' . $tableName . ';';
        return $this->dbConnection->queryAllBySql($sql);
    }

    public function getTableIndexes(string $tableName)
    {
        $sql = 'SHOW INDEXES FROM ' . $tableName . ';';
        return $this->dbConnection->queryAllBySql($sql);
    }

    public function getCreateTable(string $tableName)
    {
        $sql = 'SHOW CREATE TABLE ' . $tableName . ';';
        return $this->dbConnection->queryAllBySql($sql);
    }

    public function getAllTableList()
    {
        return $this->allTableList;
    }
}
