<?php

include 'global.php';
include 'sessions.php';

function checkLogin($username, $password)
{
    $username = trim($username);
    $password = trim($password);
    $login = get_login_detail();

    if ($username == $login->username && $password == $login->password) {
        set_session('isLogin', true);
        set_session('username', $username);
    } else {
        return $GLOBALS['message'] = '<span class="alert alert-error">' . 'Грешно име или парола.' . '</span>';
    }
}

function getSize($size)
{
    if ($size < 1024) {
        $result = $size . ' bytes';
    } else if ($size < (1024 * 1024)) {
        $result = round($size / 1024) . ' KB';
    } else if ($size < (1024 * 1024 * 1024)) {
        $result = round($size / (1024 * 1024), 1) . ' MB';
    }

    return $result;
}

function stringReplace($string) {
    return (strlen($string) > 35) ? substr($string,0,32).'...' : $string;
}

function listDirectory($dir)
{
    if ($handle = opendir($dir)) {
        $filesDir = array();

        foreach (glob("files/*") as $file) {
            $filesDir[$file] = filemtime($file);

        }

        asort($filesDir);
        $reverseDir = array_reverse($filesDir);

        foreach ($reverseDir as $key => $value) {
            $name = basename($key);
            $size = filesize($key);
            $pathToDownload = $dir . DIRECTORY_SEPARATOR . $name;
            echo '<tr>' .
                '<td>' .
                '<a href="' . $pathToDownload . '" target="_blank">' . stringReplace($name) . '</a>' .
                '</td>' .
                '<td>' .
                '<span class="size">file size: ' . getSize($size) . '</span>' .
                '</td>' .
                '</tr>';
        }
        closedir($handle);
    }
}

function uploadFiles($file)
{
    if ($file['tmp_name'] !== '') {
        if (move_uploaded_file($file['tmp_name'], 'files' . DIRECTORY_SEPARATOR . $file['name'])) {
            return $GLOBALS['message'] = '<span class="alert alert-success">' . 'Качването на файла е успешно.' . '</span>';
        } else {
            return $GLOBALS['message'] = '<span class="alert alert-error">' . 'Неуспешно качване на файла.' . '</span>';
        }
    } else {
        return $GLOBALS['message'] = '<span class="alert alert-error">' . 'Не е избран файл за качване.' . '</span>';
    }

}