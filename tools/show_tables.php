<?php
require_once('models/DbConnection.php');

use tools\DbConnection as DbConnection;

echo '<h1>テーブル一覧</h1>';

$dbConnection = new DbConnection();
if ($dbConnection === false) {
    echo '<a href="db_connection.php">データベースに接続してください</a>';
    exit();
}

$tableInfo = $dbConnection->getTableInformation();
if (empty($tableInfo)) {
    echo 'テーブルがありません';
}
?>
<table>
    <tr>
        <th>#</th>
        <th>table name</th>
        <th>table comment</th>
    </tr>
    <?php $seq=1; ?>
    <?php foreach ($tableInfo as $table) : ?>
        <tr>
            <td><?php echo $seq; ?></td>
            <td><?php echo $table['TABLE_NAME']; ?></td>
            <td><?php echo $table['TABLE_COMMENT']; ?></td>
        </tr>
        <?php $seq++;?>
    <?php endforeach; ?>
</table>