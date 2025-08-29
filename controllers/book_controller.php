<?php

function book_display()
{
    if (!is_get()) {
        redirect('home');
    }

    $book_id = escape($_GET["id"]);
    $book_info = get_book_by_id($book_id);
    if (!$book_info) {
        error_logging(ErrorType::Warning, "Unable to find book with id#" . $book_id);
        redirect('errors/404');
    }

    $data = [
        'title' => $book_info["title"],
        'author' => $book_info["author"],
        'isbn' => $book_info["isbn"],
        'genre' => $book_info["genre"],
        'pages' => $book_info["pages"],
        'published_year' => $book_info["published_year"],
        'summary' => $book_info["summary"],
        'stock' => $book_info["stock"]
    ];

    load_view_with_layout('book/display', $data);
}