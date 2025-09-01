<?php

function admin_add_book()
{
    // TODO validation, Check unique constaints (by insert or by select)
    if (is_post()) {
        $all_data = [
            "title",
            "genre",
            "stock",
            "author",
            "isbn",
            "pages",
            "published_year",
            "summary",
        ];

        foreach ($all_data as $key) {
            if (isset($_POST[$key])) {
                $book_data[$key] = clean_input($_POST[$key]);
            } else {
                set_flash("error", "Veuillez remplir tous les champs");
                return false;
            }
        }
        $book_data['type'] = 'Book';
        insert_new_media($book_data, 'insert_new_book');
        //TODO if success redirect to dashboard ?
    }
    load_view_with_layout("admin/add_book");
}
function admin_add_movie()
{

    if (is_post()) {
        $all_data = [
            "title",
            "genre",
            "stock",
            "director",
            "duration",
            "published_year",
            "synopsis",
            "certification",
        ];

        foreach ($all_data as $key) {
            if (isset($_POST[$key])) {
                $movie_data[$key] = clean_input($_POST[$key]);
            } else {
                set_flash("error", "Veuillez remplir tous les champs");
                return false;
            }
        }
        $movie_data['type'] = 'Movie';
        insert_new_media($movie_data, 'insert_new_movie');
    }
    load_view_with_layout("admin/add_movie");
}

function admin_add_game()
{

    if (is_post()) {
        $all_data = [
            "title",
            "genre",
            "stock",
            "editor",
            "plateform",
            "pegi",
            "description",
        ];
        foreach ($all_data as $key) {
            if (isset($_POST[$key])) {
                $game_data[$key] = clean_input($_POST[$key]);
            } else {
                set_flash("error", "Veuillez remplir tous les champs");
                return false;
            }
        }
        $game_data["type"] = "Game";
        insert_new_media($game_data, 'insert_new_game');
    }
    load_view_with_layout("admin/add_game");
}

//TODO delete
function admin_fill_db()
{
    $datas = include_once "../testing/database/db_data.php";
    foreach ($datas as $data) {
        $insert_function = "insert_new_" . strtolower($data["type"]);
        insert_new_media($data, $insert_function);
    }
}