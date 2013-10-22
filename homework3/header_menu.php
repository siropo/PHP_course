<ul class="nav nav-pills pull-right">
    <li><a href="index.php">Home</a></li>
    <?php
    if (get_session('isLogin')) {
    ?>
        <li><a href="new_message.php">New message</a></li>
        <li><a href="index.php?logout=1">Logout</a></li>
    <?php } else { ?>
        <li><a href="register.php">Register</a></li>
    <?php } ?>
</ul>