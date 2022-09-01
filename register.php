<?php

$pdo = new PDO("mysql:host=localhost;port=3306;dbname=products_crud", "root", "");
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


$warnings = [];

$fullName = "";
$userName = "";
$userEmail = "";
$userPassword = "";

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["register_btn"])) {
    $fullName = $_POST["fullName"] ?? null;
    $userName = $_POST["userName"];
    $userEmail = $_POST["userEmail"];
    $userPassword = $_POST["userPassword"];

    if (!$userName) {
      $warnings[] = "User name is required for registration!";
    }

    if (!$userEmail) {
      $warnings[] = "Email is required for registration!";
    }

    if (!$userPassword) {
      $warnings[] = "Please set a password for your account!";
    }

    if (empty($warnings)) {

    $statement = $pdo->prepare(" INSERT INTO users (full_name, user_name, email, password) VALUES (:full_name, :user_name, :email, :password) ");

    $statement->bindValue(":full_name", $fullName);
    $statement->bindValue(":user_name", $userName);
    $statement->bindValue(":email", $userEmail);
    $statement->bindValue(":password", md5($userPassword));
    $statement->execute();
    header("location: index.php");
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

<main class="form-signin w-100 m-auto text-center" style="padding: 50px;">
  <form method="POST">
    <img class="mb-4" src="http://localhost/codeweekend_MiniProject/codeweekend.png" alt="" width="100">
    <h1 class="h3 mb-3 fw-normal">Please sign in to access more features</h1>

    <div class="form-floating">
      <input type="type" class="form-control text-center" name="fullName" value="<?php echo $fullName ?>">
      <label>Full name</label>
    </div>
    <div class="form-floating">
      <input type="text" class="form-control text-center" name="userName" value="<?php echo $userName ?>">
      <label>User name</label>
    </div>
    <div class="form-floating">
      <input type="email" class="form-control text-center" name="userEmail" value="<?php echo $userEmail ?>">
      <label>Email address</label>
    </div>
    <div class="form-floating">
      <input type="password" class="form-control text-center" name="userPassword">
      <label>Password</label>
    </div>
    <button class="w-100 btn btn-lg btn-primary" type="submit" name="register_btn">Sign in</button>
    <p class="mt-5 mb-3 text-muted">&copy; 2020–2022</p>
  </form>
</main>

  </body>
</html>