<?php
  require_once "pdo.php";
  session_start() ;
  $errmsg="";
  if (!isset($_POST['email'])  || !isset($_POST['password'])) {
    $_POST["email"] = "";
    $_POST["password"] = "";
  } else if ($_POST['action']=='Cancel') {
    header("location: index.php");	
  } else if (empty ($_POST['email']) || empty ($_POST['password'])) {
    $errmsg="<p> <font color=red> Email and password are required.</font> </p>";
  } else if (!strpos($_POST['email'], '@')) {
    $errmsg= "<p> <font color=red> Email must have an at-sign (@).</font> </p>";
  } else if (isset($_POST['email']) && isset($_POST['password'])) {
    $sql = "SELECT * FROM users 
    WHERE email = :email AND password = :password";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(
    ':email' => $_POST['email'], 
    ':password' => $_POST['password']));
    $row = $stmt->fetch(PDO::FETCH_ASSOC);    
    if ( $row === FALSE ) {
      $errmsg = "<h3><font color=red>Login password incorrect.</font></h3>\n";
    } else { 
      $_SESSION ["email"]=$row['email'];
      header ("location: autos.php?name=".urlencode($row['name']) );
    }
  } 
?>

<html>
  <head>
    <title>JMichelle O. Ombid</title>
  </head>
  <body>
    <h1><p>Please Log In</p></h1>
    <?php echo "$errmsg";?>
    <form method="post" action="">
      <p>User name <input type="text" name="email"></p>			
      <p>Password  <input type="password" name="password"></p>
      <p><input type="submit" name="action" value="Login"/>
      <input type="submit" name="action" value="Cancel"/></p>
      For a password hint, view the source and find a password hint in the HTML comments.
    </form>
  </body>
</html>