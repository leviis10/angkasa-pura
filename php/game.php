<?php
include "db/db.php";

$name = "anonymous";
if (isset($_GET["username"])) {
    $name = htmlspecialchars($_GET["username"]);
}

$data = $pdo->query("SELECT * FROM master_kata ORDER BY RAND() LIMIT 1")->fetch();
$kata = $data["kata"];
$clue = $data["clue"];
$randomWordClueIndex = mt_rand(0, strlen($kata) - 1);
?>

<?php include "layout/header.php"; ?>

<div class="container mt-5">
    <h1 class="text-center">Welcome, <?php echo $name; ?>!</h1>

    <p class="text-center">Guess the word below:</p>

    <form class="submit-game mt-4">
        <div class="d-flex justify-content-center flex-wrap mb-4">
            <?php for ($i = 0; $i < strlen($kata); $i++): ?>
                <input type="text" name="<?php echo $i; ?>" class="form-control mx-1" style="width: 40px;"
                    <?php if ($i == $randomWordClueIndex): ?>
                    value="<?php echo $kata[$randomWordClueIndex]; ?>" readonly
                    <?php endif; ?>>
            <?php endfor; ?>
        </div>

        <p class="text-center">Clue: <strong><?php echo $clue; ?></strong></p>

        <button type="submit" class="btn btn-primary btn-block">Submit</button>
    </form>
</div>

<script>
    <?php include "config/config.php"; ?>
    const submitGameForm = document.querySelector(".submit-game");
    submitGameForm.addEventListener("submit", async function(e) {
        e.preventDefault();

        const formData = new FormData(this);
        const kata = "<?php echo $kata; ?>";
        let score = 0;

        formData.forEach((item, i) => {
            if (item && +i !== <?php echo $randomWordClueIndex; ?>) {
                if (item === kata[i]) {
                    score += 10;
                } else {
                    score -= 2;
                }
            }
        });

        const res = await fetch("<?php echo $baseUrl; ?>/submit.php", {
            method: "POST",
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                username: "<?php echo $name; ?>",
                score
            })
        });

        const {
            redirectUrl
        } = await res.json();

        window.location.replace(redirectUrl);
    });
</script>

<?php include "layout/footer.php"; ?>