<?php
    if (isset($_POST['submit'], $_POST['server_name'], $_POST['username'], $_POST['password'])) {
        $dbServer = $_POST['server_name'];
        $username = $_POST['username'];
        $password = $_POST['password'];
        $dbName = $_POST['dbname'];

        $dbConnectionString = 'mysql:dbname=' . $dbName . ';host=' . $dbServer . ';charset=utf8';
        $pdo = new PDO($dbConnectionString, $username, $password);
        
        $sql = "show tables;";
        $rows = $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
        echo "<table><tr><th>#</th><th>table name</th>";
        // $md = '#|table name' . "\n";
        // $md .= '--:|---' . "\n";
        $seq = 1;
        foreach ($rows as $row) {
            echo '<tr>';
            echo '<td>' . $seq . '</td>';
            echo '<td>' . htmlspecialchars(array_values($row)[0]) . '</td>';
            echo '</tr>';
            // $md .= $seq . '|' . htmlspecialchars(array_values($row)[0]) . "\n";
            $seq++;
        }
        echo '</table>';
        // echo $md;
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