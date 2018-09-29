<?php
require_once "pdo.php";
session_start() ;
    
$ctr=0;
$msg1="";
    if(isset($_POST['add'])) {
        if(empty($_POST['make']) && empty($_POST['model']) && empty($_POST['year']) && empty($_POST['mileage'])) {
            echo "All fields are required";
        } else if (empty($_POST['make']) || empty($_POST['model']) || empty($_POST['year']) || empty($_POST['mileage'])) {
            echo "Make, Model, Year or Mileage is/are required...";
        } else if (!is_numeric ($_POST['year'])) {
            echo "Year must be integer..."; 
        } else if (!is_numeric ($_POST['mileage'])) {
            echo "Mileage must be integer...";  
        } else {           
            $sql = "INSERT INTO autos (make, model, year, mileage) 
            VALUES ( :make, :model, :year, :mileage)";
    
            $stmt = $pdo->prepare($sql);
            $stmt->execute(array(
                ':make' => $_POST['make'], 
                ':model' => $_POST['model'], 
                ':year' => $_POST['year'],
                ':mileage' => $_POST['mileage']));
            $msg1="Record inserted...";
        }
    }
    if(isset($_POST['logout'])) {
        header ("location: index.php");
        session_destroy();
    }
?>

<html>
    <head>
    <title>Michelle</title>  
    </head>
    <body>
        <?php
            if ( ! isset($_SESSION ["email"]) || strlen($_SESSION ["email"]) < 1  ) {
                echo "You need to <a href='index.php'>Login</a><br/>";
                die('Name parameter missing');
            }
        ?>
        <h1><p>Tracking Autos for </p></h1>
        <?php echo "<h1>" . $_SESSION['email'] . "</h1>";?>

        <form method="post">
            <?php echo "<font color=green>".$msg1."</font>"; ?>
            <?php if(isset($_GET["action_msg"])) { echo "<font color=green>".$_GET["action_msg"]."</font>"; }?>
            <table>
                <tr>
                    <td>Make</td>
                    <td><font color="red">* </font><input type="text" name="make"></td>
                </tr>
                <tr>
                    <td>Model</td>
                    <td><font color="red">* </font><input type="text" name="model"></td>
                </tr>
                <tr>
                    <td>Year</td>
                    <td><font color="red">* </font><input type="text" name="year"></td>
                </tr>
                <tr>
                    <td>Mileage</td>
                    <td><font color="red">* </font><input type="text" name="mileage"></td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <center>
                            <input type="submit" name="add" value="Add"/>  
                            <input type="submit" name="logout" value="Logout"/>
                        </center>
                    </td>
                </tr>
            </table>

            </p><?php echo "<h2> Automobiles </h2>"; ?></p>

            <?php 
                $stmt = $pdo->query("SELECT * FROM autos");
                echo '
                        <table border="1">
                        <tr>
                            <th>MAKE</th>
                            <th>MODEL</th>
                            <th>YEAR</th>
                            <th>MILEAGE</th>
                            <th>ACTION</th>
                        </tr>
                    ';
                while ( $row = $stmt->fetch(PDO::FETCH_ASSOC) ) {
                    echo '<tr>'.
                            '<td>'.$row['make'].'</td>'.
                            '<td>'.$row['model'].'</td>'.
                            '<td>'.$row['year'].'</td>'.
                            '<td>'.$row['mileage'].'</td>'.
                            '<td><a href="edit.php?auto_id='.$row['auto_id'].'">Edit</a> | <a href="delete.php?auto_id='.$row['auto_id'].'">Delete</a></td>'.
                         '</tr>';
                }
                echo '</table>';
            ?>
        </form>
    </body>
</html>