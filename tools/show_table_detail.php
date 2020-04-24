<?php
require_once('../config.php');
require_once('models/DbConnection.php');
require_once('models/TableInformation.php');

use tools\DbConnection as DbConnection;
use tools\TableInformation as TableInformation;

$dbConnection = new DbConnection();
if ($dbConnection === false) {
    echo '<a href="db_connection.php">データベースに接続してください</a>';
    exit();
}

if (isset($_GET['table_name'])) {
    $tableName = htmlspecialchars($_GET['table_name']);
} else {
    echo 'パラメータエラー<br>';
    echo '<a href="show_tables.php">戻る</a>';
    exit();
}

$tableInfo = new TableInformation($dbConnection);

if ($tableInfo->tableExists($tableName) === false) {
    echo 'テーブルがありません';
    exit();
}

$tableMdFileName = '../documents/tables/' . $tableName . '.MD';
$text = makeMdText($tableInfo, $tableName);

file_put_contents($tableMdFileName, $text);
header("Location: $tableMdFileName");
exit();

/**
 * テーブルの情報をMDテキスト形式に編集して返却する
 *
 * @param TableInformation $tableInfo
 * @param string $tableName
 * @return string
 */
function makeMdText(TableInformation $tableInfo, string $tableName)
{
    $tableDescription = $tableInfo->getTableList()[$tableName]['TABLE_COMMENT'] ?? '';
    $tableColumns = $tableInfo->getTableColumns($tableName);
    $tableIndexes = $tableInfo->getTableIndexes($tableName);
    $createTable  = $tableInfo->getCreateTable($tableName);

    $text = '## ' . $tableName . "\n";
    $text .= '### Description' . "\n";
    $text .= $tableDescription . "\n";

    $text .= '### Filed List' . "\n";
    $text .= makeFieldList($tableColumns) . "\n";

    $text .= '### Index List' . "\n";
    $text .= makeIndexList($tableIndexes) . "\n";

    $text .= '### Create SQL statement' . "\n";
    $text .= '```' . "\n";
    $text .= $createTable[0]["Create Table"] . "\n";
    $text .= '```' . "\n\n";

    $text .= '### for Mock or Fixture' . "\n";
    $text .= '```' . "\n";
    $text .= makeForFixtureText($tableColumns) . "\n";
    $text .= '```' . "\n";

    return $text;
}

/**
 * Column情報をMD用のテキストに変換して返却する
 *
 * @param array $tableColumns
 * @return string
 */
function makeFieldList(array $tableColumns)
{
    $text = "|"
        . 'No' . "|"
        . 'Field' . "|"
        . 'Type' . "|"
        . 'Null' . "|"
        . 'Key' . "|"
        . 'Default' . "|"
        . 'Extra' . "|"
        . 'Comment' . "|"
        . "\n";
    $text .= "|"
        . '--:' . "|"
        . '---' . "|"
        . '---' . "|"
        . '---' . "|"
        . '---' . "|"
        . '---' . "|"
        . '---' . "|"
        . '---' . "|"
        . "\n";
    $seq = 0;
    foreach ($tableColumns as $column) {
        $columnText = "|"
            . $seq . "|"
            . $column['Field'] . "|"
            . $column['Type'] . "|"
            . $column['Null'] . "|"
            . $column['Key'] . "|"
            . $column['Default'] . "|"
            . $column['Extra'] . "|"
            . $column['Comment'] . "|"
            . "\n";
        $text .= $columnText;
        $seq++;
    }
    return $text;
}

/**
 *  テーブルのindex情報をMD用のテキストに変換して返却する
 *
 * @param array $tableIndexes
 * @return void
 */
function makeIndexList(array $tableIndexes)
{
    $text = "|"
        . 'No' . "|"
        . 'Key name' . "|"
        . 'Seq in index' . "|"
        . 'Column Name' . "|"
        . "\n";
    $text .= "|"
        . '--:' . "|"
        . '---' . "|"
        . '---' . "|"
        . '---' . "|"
        . "\n";
    $seq = 0;
    foreach ($tableIndexes as $index) {
        $indexText = "|"
            . $seq . "|"
            . $index['Key_name'] . "|"
            . $index['Seq_in_index'] . "|"
            . $index['Column_name'] . "|"
            . "\n";
        $text .= $indexText;
        $seq++;
    }
    return $text;
}

/**
 * テーブルのfixture, Mock用の配列形式のテキストを生成して返却する
 *
 * @param array $tableColumns
 * @return string
 */
function makeForFixtureText(array $tableColumns)
{
    $text = "'testFor' => [\n";
    $maxFieldLength = 0;
    foreach ($tableColumns as $column) {
        if (strlen($column['Field']) > $maxFieldLength) {
            $maxFieldLength = strlen($column['Field']);
        }
    }
    foreach ($tableColumns as $column) {
        $spaceLength = $maxFieldLength - strlen($column['Field']) + 1;
        $columnText = "    '"
            . $column['Field']
            . str_pad("'", $spaceLength)
            . " => '',"
            . "\n";
        $text .= $columnText;
    }
    $text .= "],\n";
    return $text;
}

?>
