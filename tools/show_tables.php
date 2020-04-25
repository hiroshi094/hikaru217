<?php
require_once('../config.php');
require_once('models/TableInformation.php');

use tools\TableInformation as TableInformation;

$tableInfo = new TableInformation();
$allTableList = $tableInfo->getAllTableList();
if (empty($allTableList)) {
    echo 'テーブルがありません';
}
?>
<?php include_once('components/common_header.php'); ?>
<link rel="stylesheet" type="text/css" href="css/show_table.css?<?php echo date('YmdGis', filemtime('css/show_table.css')); ?>">
<script src="js/show_tables.js"></script>
<div class="breadcrumbs">
<a href="../">TOP</a> » <span>テーブル一覧</span></div>
<h1>テーブル一覧</h1>
<h2 class="blog"><a href='https://blog.yutenji.biz'>還暦過ぎたエンジニアの挑戦</a></h2>
<div style="display:none;">Database Name : <?php echo $tableInfo->dbName; ?> </div>
<div class="filterInfo">フィルタには % (任意の0文字以上の文字列) が使えます</div>
<div class="tableInfo">
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>table name <input type="text" id="tableNameFilter" style="width:110px;"></th>
                <th>table comment <input type="text" id="commentFilter"></th>
                <th>action</th>
            </tr>
        </thead>
        <tbody>
        <?php $seq=1; ?>
            <?php foreach ($allTableList as $table) : ?>
                <tr>
                    <td><?php echo $seq; ?></td>
                    <td><?php echo $table['TABLE_NAME']; ?></td>
                    <td><?php echo $table['TABLE_COMMENT']; ?></td>
                    <td>
                        <i class="material-icons fsize20 actUpdateComment">edit</i>
                        <i class="material-icons fsize20 actShowTableDetail">description</i>
                    </td>
                </tr>
                <?php $seq++;?>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>