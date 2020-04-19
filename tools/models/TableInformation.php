<?php
namespace tools;

/**
 * Table Informationを管理するクラス
 */
class TableInformation
{
    /** @var string dbConnection */
    private $dbConnection;
    /** @var array tableList */
    private $tableList = [];

    public function __construct(DbConnection $dbConnection)
    {
        $this->dbConnection = $dbConnection;
        $this->setTableList();
    }

    /**
     * table のlistを配列にしておく
     *
     * @return void
     */
    private function setTablelist()
    {
        $this->tableList = [];
        $tableInfo = $this->dbConnection->getTableInformation();
        foreach($tableInfo as $table) {
            $this->tableList[$table['TABLE_NAME']] = $table;
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
        return isset($this->tableList[$tableName]);
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

    public function getTableList()
    {
        return $this->tableList;
    }
}
