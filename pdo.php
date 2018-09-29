<?php
echo "<pre>\n";
try {
    // $pdo=new PDO('mysql:host=localhost;port=3306;dbname=misc', 'root', '');
    $pdo=new PDO('mysql:host=sql12.freemysqlhosting.net;port=3306;dbname=sql12255634', 'sql12255634', 'QDiHhPRFkL');
} catch (PDOException $e) {
    print "Error!: " . $e->getMessage() . "<br/>";
    die();
}
echo "</pre>\n";?>