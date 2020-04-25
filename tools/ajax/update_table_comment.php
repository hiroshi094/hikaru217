<?php
require_once('../../config.php');
require_once('../models/TableInformation.php');

use tools\TableInformation as TableInformation;

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
    $tableInfo = new TableInformation();
    return $tableInfo->updateTableComment($tableName, $tableComment);
}
