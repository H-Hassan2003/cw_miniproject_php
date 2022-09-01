<?php

session_start();


$pdo = new PDO("mysql:host=localhost;port=3306;dbname=products_crud", "root", "");
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$search = $_GET["search"] ?? '';
if ($search) {
    $statement = $pdo->prepare("SELECT * FROM products WHERE title LIKE :title ORDER BY create_date DESC");
    $statement->bindValue(":title", "%$search%");

} else {
    $statement = $pdo->prepare("SELECT * FROM products ORDER BY create_date DESC");
}

$statement->execute();
$products = $statement->fetchAll(PDO::FETCH_ASSOC);

if (isset($_GET["logout"])) {
    session_destroy();
    header("location: login.php");
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
    <h1>Products List</h1>

    <p>
        <a href="create.php" class="btn btn-success">Add More Products</a>
        <a href="http://localhost/codeweekend_miniproject/index.php?logout=true" class="btn btn-success">Logout</a>
    </p>

    <form>
    <div class="input-group mb-3">
        <input type="text" class="form-control" placeholder="Search for products" name="search" value="<?php echo $search ?>" >
        <div>
            <button class="btn btn-outline-secondary" type="submit">Search</button>
        </div>
    </div>
    </form>

        <table class="table">
            <thead>
                <tr>
                <th scope="col">#</th>
                <th scope="col">Image</th>
                <th scope="col">Title</th>
                <th scope="col">Price</th>
                <th scope="col">Create Date</th>
                <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($products as $i=> $product): ?>
                    <tr>
                        <th scope='row'><?php echo $i + 1 ?></th>
                        <td>
                            <img src="<?php echo $product["image"] ?>" class="thumb-image">
                        </td>
                        <td><?php echo $product["title"] ?></td>
                        <td><?php echo $product["price"] ?></td>
                        <td><?php echo $product["create_date"] ?></td>
                        <td>

                        <a href="update.php?id=<?php echo $product["id"] ?>" class="btn btn-sm btn-outline-primary">Edit</a>
                        <form style="display: inline-block;" action="delete.php" method="POST">
                            <input type="hidden" name="id" value="<?php echo $product["id"] ?>">
                            <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                        </form>

                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

  </body>
</html>
