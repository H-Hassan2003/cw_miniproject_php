if (isset($_GET["logout"])) {
    session_destroy();
    header("location: login_file.php");
}