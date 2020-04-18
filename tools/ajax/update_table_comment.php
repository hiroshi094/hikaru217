<?php
require_once('../models/DbConnection.php');

use tools\DbConnection as DbConnection;

if (isset($_POST['tableName'], $_POST['tableComment'])) {
    $tableName = htmlspecialchars($_POST['tableName']);
    $tableComment = htmlspecialchars($_POST['tableComment']);
    $result = updateTableComment($tableName, $tableComment);
    echo json_encode(array(
        'status' => 'OK',
        'result' => $result
    ));
} else {
    echo json_encode(array('status' => 'NG'));
}
exit();

function updateTableComment(string $tableName, string $tableComment)
{
    $dbConnection = new DbConnection();
    if ($dbConnection === false) {
        return false;
    }
    return $dbConnection->updateTableComment($tableName, $tableComment);
}
