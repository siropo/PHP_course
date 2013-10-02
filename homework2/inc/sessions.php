<?php

function init_session()
{
    session_start();
}

function set_session($key, $value)
{
    $_SESSION[$key] = $value;
}

function get_session($key)
{
    if (isset($_SESSION[$key])) {
        return $_SESSION[$key];
    }
    return false;
}

function destroy_session()
{
    session_destroy();
}