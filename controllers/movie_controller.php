<?php

function movie_show()
{
    if (!is_get()) {
        redirect('errors/404');
    }

    $movie_id = escape($_GET["id"]);
    $movie_info = get_movie_by_id($movie_id);
    if (!$movie_info) {
        error_logging(ErrorType::Warning, "Unable to find movie with id#" . $movie_id);
        redirect('errors/404');
    }

    $already_rented = null;
    if (is_logged_in()) {
        $user_id = current_user_id();
        $already_rented = is_media_already_borrowed_by_user($movie_id, $user_id);
    }

    $data = [
        'title' => $movie_info["title"],
        'genre' => $movie_info["genre"],
        'director' => $movie_info["director"],
        'duration' => $movie_info["duration"],
        'published_year' => $movie_info["published_year"],
        'synopsis' => $movie_info["synopsis"],
        'certification' => $movie_info["certification"],
        'cover_img' => $movie_info['cover_img'],
        'stock' => $movie_info["stock"],
        'media_id' => $movie_id,
        'already_rented' => $already_rented,
        'stylesheets' => ['assets/css/media.css']
    ];

    load_view_with_layout('movie/show', $data);
}
