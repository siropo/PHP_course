<?php
include 'header.php';

if ($_POST) {
    if ($_POST['title'] != '' && $_POST['message'] != '') {

        $title = $_POST['title'];
        $message = $_POST['message'];
        $error = false;

        if (mb_strlen($title, 'UTF-8') > 50) {
            echo '<div class="alert alert-danger">The Title should be a maximum length of 50 characters!</div>';
            $error = true;
        }

        if (mb_strlen($message, 'UTF-8') > 250) {
            echo '<div class="alert alert-danger">The Message should be a maximum length of 250 characters!</div>';
            $error = true;
        }

        if ($error == false) {
            newMessageRecord($title, $message);
        }

    } else {
        echo '<div class="alert alert-danger">Please fill all fields</div>';
    }
}

?>

    <div class="row content">
        <div class="col-md-8">
            <form action="new_message.php" method="POST" class="form-signin">
                <h2 class="form-signin-heading">Your message</h2>
                <input type="text" class="form-control" name="title" placeholder="Title" autofocus>
                <textarea class="form-control" name="message" placeholder="Message"></textarea>
                <button class="btn btn-lg btn-primary btn-block" type="submit">Submit</button>
            </form>
        </div>
    </div>

<?php
include 'footer.php';
?>