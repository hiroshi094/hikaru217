<?php
    if (isset($_POST['submit'], $_POST['server_name'], $_POST['username'], $_POST['password'])) {
        $DBSERVER = $_POST['server_name'];
        $username = $_POST['username'];
        $password = $_POST['password'];
        $DBNAME = $_POST['dbname'];

        //$pdo = new PDO($dsn, $username, $password);
        
        $con = mysql_connect($DBSERVER, $username, $password);
        mysql_select_db($DBNAME);
        $sql = "show tables;";
        echo "<pre>";
            $rst = mysql_query($sql);
            //$row = mysql_fetch_row ($rst);
            while ($row = mysql_fetch_array ($rst))
            {
                var_dump($row);  
            }
        exit;
    }
?>
<form id="dbConnect" action="" method="POST">
<dl>
<dt>server_name</dt><dd><input type="text" name="server_name"></dd>
<dt>username</dt><dd><input type="text" name="username"></dd>
<dt>password</dt><dd><input type="text" name="password"></dd>
<dt>dbname</dt><dd><input type="text" name="dbname"></dd>
<dt>接続確認</dt><dd><input type="submit" name="submit" value="submit"></dd>
</form>