<?php

session_start();

if (isset($_SESSION["verified"])) {
    header("location: index.php");
}

$pdo = new PDO("mysql:host=localhost;port=3306;dbname=products_crud", "root", "");
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$warnings = [];
$userEmail = "";
$userPassword = "";

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["loginBtn"])) {

    $userEmail = $_POST["userEmail"];
    $userPassword = $_POST["userPassword"];

    if (!$userEmail) {
      $warnings[] = "Email is required for loging in!";
    }

    if (!$userPassword) {
      $warnings[] = "Please provide your password for loging in!";
    }

    if (empty($warnings)) {

        $userPassword = md5($userPassword);
            
        $statement = $pdo->prepare("SELECT * FROM users WHERE email = '$userEmail' AND password = '$userPassword' ");
        $statement->execute();
        $user = $statement->fetchAll(PDO::FETCH_ASSOC);

        if ($user) {
            $_SESSION["auth_user"] = [
                "fullName" => $user["full_name"],
                "userName" => $user["user_name"],
                "email" => $user["eamil"],
                "password" => $user["password"],
            ];
    
                $_SESSION["verified"] = true;
    
                header("location: index.php");
    
            } else {
                $warnings[] = "The provided credentials were not found! Try again!";
        }
    }
}


?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.rtl.min.css" integrity="sha384-+4j30LffJ4tgIMrq9CwHvn0NjEvmuDCOfk6Rpg2xg7zgOxWWtLtozDEEVvBPgHqE" crossorigin="anonymous">

    <link rel="stylesheet" href="app.css">
    <title>Products Crud</title>
  </head>
  <body>

    <?php if (!empty($warnings)): ?>
        <div class="alert alert-danger">
        <?php foreach ($warnings as $warning): ?>
            <div><?php echo $warning ?></div>
        <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <form style="padding: 100px;" method="POST" class="text-center">
    <img class="mb-4" src="http://localhost/codeweekend_MiniProject/codeweekend.png" alt="" width="100">
    <h1 class="h3 mb-3 fw-normal">Login to your account</h1>
        <div class="mb-3 text-center">
            <label class="form-label">Email address</label>
            <input type="email" class="form-control text-center" name="userEmail">
        </div>
        <div class="mb-3 text-center">
            <label class="form-label">Password</label>
            <input type="password" class="form-control text-center" name="userPassword">
        </div>
        <div class="text-center">
            <button type="submit" class="btn btn-primary text-center" name="loginBtn">Confirm Identity</button>
            <p>New here <a href="http://localhost/codeweekend_miniproject/register.php">Register</a></p>
        </div>
    </form>

  </body>
</html>

?>