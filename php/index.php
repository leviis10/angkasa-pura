<?php
$flag = false;
if (isset($_GET["username"]) && isset($_GET["score"])) {
    $flag = true;
    $username = htmlspecialchars($_GET["username"]);
    $score = htmlspecialchars($_GET["score"]);
}
?>

<?php include "layout/header.php"; ?>

<div class="container mt-5">
    <h1 class="text-center">Welcome to the Game</h1>
    <form action="game.php" method="get" class="mt-4">
        <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" id="username" name="username" class="form-control" required />
        </div>

        <button type="submit" class="btn btn-primary">Play</button>
    </form>

    <?php if ($flag): ?>
        <div class="alert alert-success mt-4" role="alert">
            Hello <?php echo $username; ?>, You scored <?php echo $score; ?>!
        </div>
    <?php endif; ?>
</div>

<?php include "layout/footer.php"; ?>