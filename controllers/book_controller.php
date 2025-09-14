<?php
function book_show()
{

    if (!is_get()) {
        redirect('errors/404');
    }
    // le controleur demande au model de le chercher dans la DB.


    $book_id = escape($_GET["id"]);
    $book_info = get_book_by_id($book_id);
    if (!$book_info) {
        error_logging(ErrorType::Warning, "Unable to find book with id#" . $book_id);
        redirect('errors/404');
    }

    $already_rented = null;
    if (is_logged_in()) {
        $user_id = current_user_id();
        $already_rented = is_media_already_borrowed_by_user($book_id, $user_id);
    }

    // la DB des medias du model
    $data = [
        'author' => $book_info["author"],
        'isbn' => $book_info["isbn"],
        'pages' => $book_info["pages"],
        'published_year' => $book_info["published_year"],
        'summary' => $book_info["summary"],
        'title' => $book_info["title"],
        'genre' => $book_info["genre"],
        'cover_img' => $book_info['cover_img'],
        'stock' => $book_info["stock"],
        'media_id' => $book_id,
        'already_rented' => $already_rented,
        'stylesheets' => ['assets/css/media.css', 'assets/css/confirm-popover.css']
    ];
    // renvoi vers la vu.
    load_view_with_layout('book/show', $data);
}

