<?php

include 'global.php';
include 'sessions.php';

mb_internal_encoding('UTF-8');
$db = dbConnect();

function dbConnect()
{
    $connection = mysqli_connect('localhost', 'root', 'ot123kralev', 'books') or die('Database error');
    mysqli_query($connection, 'SET NAMES utf8');

    return $connection;
}

function isAuthorIdExsist($db, $ids)
{

    if (!is_array($ids)) {
        return false;
    }

    $sql = 'SELECT * FROM authors WHERE author_id IN(' . implode(',', $ids) . ')';

    $result = mysqli_query($db, $sql);

    if ($result->num_rows == count($ids)) {
        return true;
    }
    return false;
}

function tryAddAuthor($db, $authorName)
{
    $authorName = trim($authorName);

    if (mb_strlen($authorName) < 2) {
        echo '<div class="alert alert-danger">Name must be greater than two characters.</div>';
    } else {

        $authorName = mysqli_real_escape_string($db, $authorName);

        $sql = 'SELECT * FROM authors
	         	WHERE author_name = "' . $authorName . '"';

        $result = mysqli_query($db, $sql);

        if (!($result->num_rows > 0)) {
            newAuthorRecord($db, $authorName);
        } else {
            echo '<div class="alert alert-danger">This author already exist.</div>';
        }
    }
}

function tryAddBook($db, $title, $authors)
{
    $title = trim($title);

    if (!is_array($authors) || count($authors) == 0) {
        '<div class="alert alert-danger">Invalid name.</div>';
    }

    if (mb_strlen($title) < 2) {
        echo '<div class="alert alert-danger">Book name must be greater than two characters.</div>';
    } else {

        if (!isAuthorIdExsist($db, $authors)) {
            echo '<div class="alert alert-danger">Invalid Author.</div>';
            return;
        }

        $sql = 'SELECT * FROM books
	         	WHERE book_title = "' . $title . '"';

        $result = mysqli_query($db, $sql);

        if (!($result->num_rows > 0)) {
            $title = mysqli_real_escape_string($db, $title);
            newBookRecord($db, $title, $authors);
        } else {
            echo '<div class="alert alert-danger">Book name already exist.</div>';
        }

    }

}

function getAuhors($db)
{

    $sql = 'SELECT * FROM authors';

    if (!($result = mysqli_query($db, $sql))) {
        echo '<div class="alert alert-danger">Something went wrong, please try again!</div>';
        return false;
    } else {
        $authors = array();
        while ($row = $result->fetch_assoc()) {
            $authors[] = $row;
        }
        return $authors;
    }
}

function getBooks($db, $author_id = false)
{
    if (!$author_id) {
        $sql = 'SELECT * from books INNER JOIN books_authors
         ON books.book_id = books_authors.book_id
         INNER JOIN authors
         ON authors.author_id = books_authors.author_id
         ORDER BY books.book_id DESC, authors.author_id DESC';
    } else {
        $sql = 'SELECT * FROM books_authors as ba
        INNER JOIN books_authors bba
        ON bba.book_id=ba.book_id
        INNER JOIN books as b
        ON ba.book_id=b.book_id
        INNER JOIN authors as a
        ON bba.author_id=a.author_id
        WHERE ba.author_id=' . $author_id . '';
    }


    if (!($result = mysqli_query($db, $sql))) {
        echo '<div class="alert alert-danger">Something went wrong, please try again!</div>';
        return false;
    } else {
        $books = array();

        while ($row = $result->fetch_assoc()) {
            $books[$row['book_id']]['bookTitle'] = $row['book_title'];
            $books[$row['book_id']]['authors'][$row['author_id']] = $row['author_name'];
        }
        return $books;
    }
}

function newBookRecord($db, $title, $authors)
{
    $sql = "INSERT INTO books (book_title) VALUES ('" . $title . "')";

    if (!mysqli_query($db, $sql)) {
        echo '<div class="alert alert-danger">Something went wrong, please try again!</div>';
    } else {
        $lastInsertedId = mysqli_insert_id($db);

        $values = [];
        foreach ($authors as $value) {
            $values[] = "($lastInsertedId, $value)";
        }

        $query = "INSERT INTO books_authors VALUES " . implode(', ', $values) . "";

        $result = mysqli_query($db, $query);

        if ($result) {
            echo '<div class="alert alert-success">Book ' . $title . ' is successful added!</div>';
        } else {
            echo '<div class="alert alert-danger">Error adding book with authors, please try again!.</div>';
        }
    }
}

function newAuthorRecord($db, $name)
{

    $sql = 'INSERT INTO authors (author_name)
                		VALUES ("' . $name . '" );';

    if (mysqli_query($db, $sql)) {
        header('Location: add_author.php?success_addMessage=1');
    } else {
        echo '<div class="alert alert-danger">Something went wrong, please try again!</div>';
    }
}


