<?php
require_once "pdo.php";
session_start() ;
    
$ctr=0;
$msg1="";
$msg2="";
if ( isset($_POST['make']) && isset($_POST['year']) 
     && isset($_POST['mileage'])) {
    
    if ($_POST['action']=='Logout'){
        header("location: index.php");
    } 
    else if (empty($_POST['make']) || empty($_POST['year']) || empty($_POST['mileage'])) {
        echo "Make, Year or Mileage is/are required...";    
    }
    else if (isset($_POST['Logout'])) {
        header ("location: /workshop04/index.php");
    }
    else if (!is_numeric ($_POST['year'])) {
        echo "Year must be numeric..."; 
    }
    else if (!is_numeric ($_POST['mileage'])) {
        echo "Mileage must be numeric...";  
    }
    else {
    
        
            $sql = "INSERT INTO autos (make, year, mileage) 
            VALUES ( :make, :year, :mileage)";
    
            $stmt = $pdo->prepare($sql);
            $stmt->execute(array(
                ':make' => $_POST['make'], 
                ':year' => $_POST['year'],
                ':mileage' => $_POST['mileage']));

            $msg1="Record inserted...";
                    
    }
} 

?>


<html>

<head>
    <title>Michelle P. Ombid</title>  
</head><body>

<?php

if ( ! isset($_GET['name']) || strlen($_GET['name']) < 1  ) {
    die('Name parameter missing');
}

?>
<h1><p>Tracking Autos for </p></h1>
 <?php  
        echo "<h1>" . $_SESSION['email'] . "</h1>";         
   
 ?>

<form method="post">
<?php echo "<font color=green>".$msg1."</font>"; ?> 
<p>Make:
<input type="text" name="make"</p>
<p>Year:
<input type="text" name="year"></p>
<p>Mileage:
<input type="text" name="mileage"></p>
<p><input type="submit" name="action" value="Add"/>  
   <input type="submit" name="action" value="Logout"/></p>   
   </p><?php echo "<h2> Automobiles </h2>"; ?></p>

   <?php 

            $stmt = $pdo->query("SELECT * FROM autos");

echo '<table border="1">'."\n";
while ( $row = $stmt->fetch(PDO::FETCH_ASSOC) ) {
    echo "<tr><td>";
    echo($row['make']);
    echo("</td><td>");
    echo($row['year']);
    echo("</td><td>");
    echo($row['mileage']);
    echo("</td></tr>\n");
}
echo "</table>\n";

?>

</form>
</body>
</html>