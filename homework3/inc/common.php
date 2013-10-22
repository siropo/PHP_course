<?php

include 'global.php';
include 'sessions.php';

mb_internal_encoding('UTF-8');
$GLOBALS['dbConnection'] = dbConnect();

function dbConnect()
{
    $connection = mysqli_connect('localhost', 'root', 'ot123kralev', 'post_message_board') or die('Database error');
    mysqli_query($connection, 'SET NAMES utf8');

    return $connection;
}

function loginUser($user, $id)
{
    set_session('username', $user);
    set_session('userID', $id);
    set_session('isLogin', true);
    header('Location: messages.php');
}

function tryLoginUser($user, $pass)
{
    $dbConnect = $GLOBALS['dbConnection'];
    $username = mysqli_real_escape_string($dbConnect, trim($user));
    $password = mysqli_real_escape_string($dbConnect, trim($pass));

    $sql = 'SELECT username, password
				FROM users
	         	WHERE username = "' . $username . '" AND password = "' . $password . '"
		';

    $result = mysqli_query($dbConnect, $sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        loginUser($username, $row['id']);

    } else {
        echo '<div class="alert alert-danger">Incorrect username or password</div>';
    }
}

function tryRegisterUser($user, $pass)
{
    $dbConnect = $GLOBALS['dbConnection'];
    $username = mysqli_real_escape_string($dbConnect, trim($user));
    $password = mysqli_real_escape_string($dbConnect, trim($pass));

    if (mb_strlen($username, 'UTF-8') < 5 || mb_strlen($password, 'UTF-8') < 5) {
        echo '<div class="alert alert-danger">Username and Password must be at least 5 symbols!</div>';
    } else {
        $sql = 'SELECT username
					FROM users
                	WHERE username = "' . $username . '"
			';

        $result = mysqli_query($dbConnect, $sql);

        if ($result->num_rows > 0) {
            echo '<div class="alert alert-danger">The username is already taken!</div>';
        } else {
            registerUser($user, $pass);
        }
    }
}

function registerUser($user, $pass)
{
    $dbConnect = $GLOBALS['dbConnection'];
    $sql = 'INSERT INTO users (username, password )
                		VALUES ("' . $user . '", "' . $pass . '");
                ';

    if (mysqli_query($dbConnect, $sql)) {
        header('Location: index.php?success_register=1');
    } else {
        echo '<div class="alert alert-danger">Something with registration went wrong</div>';
    }

}

function getMessages()
{
    $dbConnect = $GLOBALS['dbConnection'];

    $sql = 'SELECT * FROM messages';

    $result = mysqli_query($dbConnect, $sql);
    $messages = array();
    while ($row = $result->fetch_assoc()) {
        $messages[] = $row;
    }

    return $messages;
}

function newMessageRecord($title, $message)
{
    $dbConnect = $GLOBALS['dbConnection'];
    $userID = get_session('userID');
    $date = date('Y-m-d H:i:s');

    $sql = 'INSERT INTO messages (title, message, user_id, date )
                		VALUES ("' . $title . '", "' . $message . '", "' . $userID . '", "' . $date . '" );
                ';

    if (mysqli_query($dbConnect, $sql)) {
        header('Location: messages.php?success_addMessage=1');
    } else {
        echo '<div class="alert alert-danger">Something went wrong, please try again!</div>';
    }
}


