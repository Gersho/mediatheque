<?php

function game_show()
{
    if (!is_get()) {
        redirect('errors/404');
    }

    $game_id = escape($_GET["id"]);
    $game_info = get_game_by_id($game_id);
    if (!$game_info) {
        error_logging(ErrorType::Warning, "Unable to find game with id#" . $game_id);
        redirect('errors/404');
    }

    $already_rented = null;
    if (is_logged_in()) {
        $user_id = current_user_id();
        $already_rented = is_media_already_borrowed_by_user($game_id, $user_id);
    }

    $data = [
        'title' => $game_info["title"],
        'genre' => $game_info["genre"],
        'editor' => $game_info["editor"],
        'plateform' => $game_info["plateform"],
        'pegi' => $game_info["pegi"],
        'description' => $game_info["description"],
        'cover_img' => $game_info['cover_img'],
        'stock' => $game_info["stock"],
        'media_id' => $game_id,
        'already_rented' => $already_rented,
        'stylesheets' => ['assets/css/media.css']
    ];

    load_view_with_layout('game/show', $data);
}
