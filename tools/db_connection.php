<?php
require_once('models/DbConnection.php');

use tools\DbConnection as DbConnection;

if (isset($_POST['submit'], $_POST['server_name'], $_POST['username'], $_POST['password'])) {
    $dbServer = htmlspecialchars($_POST['server_name']);
    $username = htmlspecialchars($_POST['username']);
    $password = htmlspecialchars($_POST['password']);
    $dbName = htmlspecialchars($_POST['dbname']);

    $dbConnection = DbConnection::saveConfig($dbServer, $dbName, $username, $password);
    if ($dbConnection === false) {
        header('Location: db_connection_test.php');
        exit();
    }

    echo "接続に成功しました<br>";
    echo '<a href="index.php">メニューに戻る</a>';
    exit();
}

$dbServer = '';
$dbName   = '';
$username = '';
$password = '';
$dbConnection = new DbConnection();
if ($dbConnection !== false) {
    $dbServer = $dbConnection->getDbServer();
    $dbName   = $dbConnection->getDbName();
    $username = $dbConnection->getUserName();
    $password = $dbConnection->getPassword();
}
?>
<h1>データベース接続</h1>
<form id="dbConnect" action="" method="POST">
<table>
    <tr>
        <th>server_name</th>
        <td><input type="text" name="server_name" value="<?php echo $dbServer ?>" style="width:240px;"></td>
    </tr>
    <tr>
        <th>username</th>
        <td><input type="text" name="username" value="<?php echo $username ?>" style="width:240px;"></td>
    </tr>
    <tr>
        <th>password</th>
        <td><input type="password" name="password" value="<?php echo $password ?>" style="width:240px;"></td>
    </tr>
    <tr>
        <th>dbname</th>
        <td><input type="text" name="dbname" value="<?php echo $dbName ?>" style="width:240px;"></td>
    </tr>
</table>
<input type="submit" name="submit" value="接続確認">
</form>
