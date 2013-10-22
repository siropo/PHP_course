<?php
include 'header.php';

if ($_POST) {

}

?>

    <div class="row content">
        <?php
        if (isset($_GET['author_id'])) {
            $books = getBooks($db, $_GET['author_id']);
        } else {
            $books = getBooks($db);
        }
        //echo '<pre>' . print_r($books, true) . '</pre>';
        foreach ($books as $bookName) {
            ?>
            <div class="row content">
                <div class="col-md-8">
                    <?= $bookName['bookTitle']; ?>
                    <div class="row">
                        <div class="col-md-6">Authors:
                            <?php
                            foreach ($bookName['authors'] as $id => $authors) {
                                echo '<a href="index.php?author_id=' . $id . '">' . $authors . '</a> ';
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>

        <?php } ?>
    </div>

<?php
include 'footer.php';
?>