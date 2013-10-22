<?php
include 'header.php';

if ($_POST) {

    if (isset($_POST['authors']) && isset($_POST['book-title'])) {
        tryAddBook($db, $_POST['book-title'], $_POST['authors']);
    } else {
        echo '<div class="alert alert-danger">Please enter Book name and select Author.</div>';
    }

}
?>

    <div class="row content">
        <form method="POST" action="add_book.php" role="form">
            <p>
                <label for="book-title">Book Title: </label>
                <input type="text" name="book-title" id="book-title" autofocus
                       autocomplete="off" value="" />
            </p>

            <p>
                <label>Choose Authors: </label>
                <select name="authors[]" multiple>
                    <?php
                    $authors = getAuhors($db);
                    for ($i = 0; $i < count($authors); $i++) {
                        ?>
                        <option value="<?= $authors[$i]['author_id']; ?>">
                            <?= $authors[$i]['author_name']; ?>
                        </option>
                    <?php } ?>
                </select>
            </p>
            <p>
                <input type="submit" name="add-book" value="Add" />
                <input type="reset" />
            </p>
        </form>
    </div>

<?php
include 'footer.php';
?>