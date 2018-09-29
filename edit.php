<?php
require_once "pdo.php";
session_start();
if ( ! isset($_SESSION ["email"]) || strlen($_SESSION ["email"]) < 1  ) {
    echo "You need to <a href='index.php'>Login</a><br/>";
    die('Name parameter missing');
}
$msg1="";
$msg2="";
$auto_id = $_GET['auto_id'];
if(isset($_POST['edit'])) {
    if(empty($_POST['make']) && empty($_POST['model']) && empty($_POST['year']) && empty($_POST['mileage'])) {
        echo "All fields are required";
    } else if (empty($_POST['make']) || empty($_POST['model']) || empty($_POST['year']) || empty($_POST['mileage'])) {
        echo "Make, Model, Year or Mileage is/are required...";
    } else if (!is_numeric ($_POST['year'])) {
        echo "Year must be integer..."; 
    } else if (!is_numeric ($_POST['mileage'])) {
        echo "Mileage must be integer...";  
    } else {           
        $sql = "UPDATE autos SET make = :make, model = :model, year = :year, mileage = :mileage WHERE auto_id = ". $auto_id;
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array(
            ':make' => $_POST['make'], 
            ':model' => $_POST['model'], 
            ':year' => $_POST['year'],
            ':mileage' => $_POST['mileage']));
        echo "<script>window.location=['autos.php?action_msg=Record Edited']</script>";
    }
}
if(isset($_POST['logout'])) {
    header ("location: index.php");
}
$stmt = $pdo->query("SELECT * FROM autos WHERE auto_id = ". $auto_id);
$row = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<html>
    <head>
    <title>Michelle P. Ombid</title>  
    </head>
    <body>
        <h1><p>Edit Tracking Autos</p></h1>

        <form method="post">
            <?php echo "<font color=green>".$msg1."</font>"; ?> 
            <table>
                <tr>
                    <td>Make</td>
                    <td><font color="red">* </font><input type="text" name="make" value="<?php echo $row['make']; ?>"></td>
                </tr>
                <tr>
                    <td>Model</td>
                    <td><font color="red">* </font><input type="text" name="model" value="<?php echo $row['model']; ?>"></td>
                </tr>
                <tr>
                    <td>Year</td>
                    <td><font color="red">* </font><input type="text" name="year" value="<?php echo $row['year']; ?>"></td>
                </tr>
                <tr>
                    <td>Mileage</td>
                    <td><font color="red">* </font><input type="text" name="mileage" value="<?php echo $row['mileage']; ?>"></td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <center>
                            <input type="submit" name="edit" value="Edit"/>  
                            <input type="submit" name="logout" value="Logout"/>
                        </center>
                    </td>
                </tr>
            </table>
        </form>
    </body>
</html>