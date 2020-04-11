<?php
require_once('models/DbConnection.php');

if (isset($_POST['submit'], $_POST['server_name'], $_POST['username'], $_POST['password'])) {
    $dbServer = htmlspecialchars($_POST['server_name']);
    $username = htmlspecialchars($_POST['username']);
    $password = htmlspecialchars($_POST['password']);
    $dbName = htmlspecialchars($_POST['dbname']);

    $dbConnectionString = 'mysql:dbname=' . $dbName . ';host=' . $dbServer . ';charset=utf8';
    try {
        $pdo = new PDO($dbConnectionString, $username, $password);
    } catch (Exception $e) {
        header('Location: db_connection_test.php');
        exit();
    }
    
    if ($pdo instanceof PDO) {
        echo "接続に成功しました";
        $dbConnection = new tools\DbConnection();
        $dbConnection->save(
            $dbServer, 
            $dbName, 
            $username, 
            $password
        );
    }
    exit;
}
$dbServer = ''; 
$dbName   = ''; 
$username = ''; 
$password = '';
$dbConnection = new tools\DbConnection();
$activeConnection = $dbConnection->getConnection();
// var_dump($activeConnection);exit;
if (empty($activeConnection) === false) {
    $dbServer = $activeConnection[0]['dbServer']; 
    $dbName   = $activeConnection[0]['dbName']; 
    $username = $activeConnection[0]['username']; 
    $password = $activeConnection[0]['password'];
}
?>
<h1>データベース接続テスト</h1>
<form id="dbConnect" action="" method="POST">
<table>
<tr><th>server_name</th><td><input type="text" name="server_name" value="<?php echo $dbServer ?>" style="width:240px;"></td></tr>
<tr><th>username</th><td><input type="text" name="username" value="<?php echo $username ?>" style="width:240px;"></td></tr>
<tr><th>password</th><td><input type="password" name="password" value="<?php echo $password ?>" style="width:240px;"></td></tr>
<tr><th>dbname</th><td><input type="text" name="dbname" value="<?php echo $dbName ?>" style="width:240px;"></td></tr>
</table>
<input type="submit" name="submit" value="接続確認">
</form>