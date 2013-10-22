<?php
include 'header.php';

if (isset($_POST['authorName'])) {
    tryAddAuthor($db, $_POST['authorName']);
}

?>

    <div class="row content">
        <form action="add_author.php" method="POST">
            <p>
                <label for="authorName">Автор:</label>
                <input name="authorName" value="<?= isset($authorName) ? $authorName : '' ?>" />
                <input type="submit" value="Добави" />
            </p>
        </form>
        <div class="row content">
            <h2>Authors:</h2>
        </div>
        <?php

        if (isset($_GET['success_addMessage'])) {
            echo '<div class="alert alert-success">Record success</div>';
        }

        $authors = getAuhors($db);
        for ($i = 0; $i < count($authors); $i++) {
            ?>
            <div class="row content">
                <div class="col-md-8">
                    <a href="index.php?author_id=<?= $authors[$i]['author_id']; ?>"><?= $authors[$i]['author_name']; ?></a>
                </div>
            </div>

        <?php } ?>
    </div>
<?php
include 'footer.php';
?>