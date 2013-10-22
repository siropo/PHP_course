<?php
include 'header.php';

if (get_session('isLogin')) {
    echo 'Здравей, ' . get_session('username') . '<br><br>';

    if (isset($_GET['success_addMessage'])) {
        echo '<div class="alert alert-success">Record success</div>';
    }

    $messages = getMessages();
    for ($i = 0; $i < count($messages); $i++) {
        ?>
        <div class="row content">
            <div class="col-md-8">message: <?= $messages[$i]['message']; ?>
                <div class="row">
                    <div class="col-md-6">user: <?= $messages[$i]['user_id']; ?></div>
                    <div class="col-md-6">date: <?= $messages[$i]['date']; ?></div>
                </div>
            </div>
        </div>
    <?php
    }
} else {
    header('Location: index.php');
}
?>
<?php
include 'footer.php';
?>