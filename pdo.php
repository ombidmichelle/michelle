<?php
echo "<pre>\n";
try {
    $pdo=new PDO('mysql:host=sql12.freemysqlhosting.net;dbname=sql12218082', 'sql12218082', '9HaaYaV9gz');
} catch (PDOException $e) {
    print "Error!: " . $e->getMessage() . "<br/>";
    die();
}
echo "</pre>\n";?>
