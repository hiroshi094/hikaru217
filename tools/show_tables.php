<?php
require_once('models/DbConnection.php');

use tools\DbConnection as DbConnection;

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
<?php include_once('components/common_header.php'); ?>
<link rel="stylesheet" type="text/css" href="css/show_table.css?<?php echo date('YmdGis', filemtime('css/show_table.css')); ?>">
<h1>テーブル一覧</h1>
<div class="tableInfo">
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>table name</th>
                <th>table comment</th>
                <th>action</th>
            </tr>
        </thead>
        <tbody>
        <?php $seq=1; ?>
            <?php foreach ($tableInfo as $table) : ?>
                <tr>
                    <td><?php echo $seq; ?></td>
                    <td><?php echo $table['TABLE_NAME']; ?></td>
                    <td><?php echo $table['TABLE_COMMENT']; ?></td>
                    <td><i class="material-icons fsize20">edit</i><i class="material-icons fsize20">description</i></td>
                </tr>
                <?php $seq++;?>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>