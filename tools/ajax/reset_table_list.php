<?php
require_once('../../config.php');
require_once('../models/TableInformation.php');

use tools\TableInformation as TableInformation;

if (isset($_POST['nameFilter'], $_POST['commentFilter'])) {

    $nameFilter = htmlspecialchars($_POST['nameFilter']);
    if (empty($nameFilter) === false) {
        $nameFilter = preg_match('/^%[^%]+|[^%]+%$/', $nameFilter, $m)
                    ? $nameFilter : '%' . $nameFilter . '%';
    }
    $commentFilter = htmlspecialchars($_POST['commentFilter']);
    if (empty($commentFilter) === false) {
        $commentFilter = preg_match('/^%[^%]+|[^%]+%$/', $commentFilter, $m)
                    ? $commentFilter : '%' . $commentFilter . '%';
    }
    $tableBody = getTableInformationBody($nameFilter, $commentFilter);
    echo json_encode(array(
        'status' => 'OK',
        'tableBody' => $tableBody
    ));
} else {
    echo json_encode(array('status' => 'NG'));
}
exit();

function getTableInformationBody(string $nameFilter, string $commentFilter)
{
    $tableBody = '';
    $tableInfo = new TableInformation();
    $tableList = $tableInfo->getTableInformation($nameFilter, $commentFilter);
    if (empty($tableList) === false) {
        $seq = 1;
        foreach ($tableList as $table) {
            $tableBody .= '<tr>';
            $tableBody .= '<td>' . $seq . '</td>';
            $tableBody .= '<td>' . $table['TABLE_NAME'] . '</td>';
            $tableBody .= '<td>' . $table['TABLE_COMMENT'] . '</td>';
            $tableBody .= '<td>';
            $tableBody .= '<i class="material-icons fsize20 actUpdateComment">edit</i>';
            $tableBody .= '<i class="material-icons fsize20 actShowTableDetail">description</i>';
            $tableBody .= '</td>';
            $tableBody .= '</tr>';
            $seq++;
        }
    } else {
        $tableBody = '　該当なし';
    }

    return $tableBody;
}
