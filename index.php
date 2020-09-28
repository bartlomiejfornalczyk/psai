<?php
require_once("setup.php");
if($_SESSION['logged'])
{
    header("location: panel.php");
}    


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.2/css/bootstrap.min.css">
    <title>PowerShell App Installer</title>
</head>
<body>
<div class="global-container">
	<div class="card login-form">
	<div class="card-body">
		<h3 class="card-title text-center">Log in to Panel</h3>
		<div class="card-text">
			<form method="post" action="#">
				<div class="form-group">
					<label for="exampleInputEmail1">Email address</label>
					<input  class="form-control form-control-sm" name="email">
				</div>
				<div class="form-group">
					<label for="exampleInputPassword1">Password</label>
					<input type="password" class="form-control form-control-sm" name="password">
				</div>
				<button type="submit" class="btn btn-primary btn-block" name="send">Sign in</button>
			</form>
		</div>
	</div>
</div>
</div>
<?php
    if(isset($_POST['send'])){
        $email = htmlentities($_POST['email']);
        $pw = $_POST['password'];
        $stmt = $conn->prepare("SELECT password FROM user WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $r = $result->fetch_row();
        $r = $r[0];
        var_dump($r);
        $stmt->close();
        $x =  password_verify($pw, $r);
        if($x == 1)
        {
            $_SESSION["logged"] = true;
            header("location: panel.php");
        } 
        }
?>