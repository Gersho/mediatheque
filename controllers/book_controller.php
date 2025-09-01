<?php

function book_show()
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


    // var_dump($book_info);

    $data = [
        'author' => $book_info["author"],
        'isbn' => $book_info["isbn"],
        'pages' => $book_info["pages"],
        'published_year' => $book_info["published_year"],
        'summary' => $book_info["summary"],
        'title' => $book_info["title"],
        'genre' => $book_info["genre"],
        'cover_path' => $book_info['cover_path'],
        'stock' => $book_info["stock"],
        'stylesheets' => ['assets/css/media.css']
    ];

    load_view_with_layout('book/show', $data);
}


// array(11) { 
//     ["id"]=> int(2) 
//     ["author"]=> string(19) "F. Scott Fitzgerald" 
//     ["isbn"]=> string(13) "9780743273565" 
//     ["pages"]=> int(180) 
//     ["published_year"]=> int(1925) 
//     ["summary"]=> string(68) "A mysterious millionaire pursues the woman he loves in the Jazz Age." 
//     ["title"]=> string(16) "The Great Gatsby" 
//     ["genre"]=> string(5) "Drama" 
//     ["type"]=> string(4) "Book" 
//     ["cover_path"]=> string(60) "https://m.media-amazon.com/images/I/91yg5rniqwL._SL1500_.jpg" 
//     ["stock"]=> int(4) } 