<?php

function game_display()
{
    if (!is_get()) {
        redirect('home');
    }

    $game_id = escape($_GET["id"]);
    $game_info = get_game_by_id($game_id);
    if (!$game_info) {
        error_logging(ErrorType::Warning, "Unable to find game with id#" . $game_id);
        redirect('errors/404');
    }

    $data = [
        'title' => $game_info["title"],
        'genre' => $game_info["genre"],
        'editor' => $game_info["editor"],
        'plateform' => $game_info["plateform"],
        'pegi' => $game_info["pegi"],
        'description' => $game_info["description"],
        'stock' => $game_info["stock"]
    ];

    load_view_with_layout('game/display', $data);
}