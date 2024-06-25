<?php
 $user = 'test_user';
 $pass = 'test_pass';

 $dsn = 'mysql:host=mysql;dbname=information_schema;charset=utf8';
 $pdo = new PDO($dsn, $user, $pass);
 $stmt= $pdo->query('select * from tables');
 $row = $stmt->fetch();
 echo "<pre>";
 print_r($row);
 echo "</pre>";
?>

