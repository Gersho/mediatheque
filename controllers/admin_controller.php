<?php

function admin_book_add()
{

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

        insert_new_book($book_data);
        
    }
    load_view_with_layout("admin/add_book");
}
function admin_movie_add()
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

        insert_new_movie($movie_data);
    }
    load_view_with_layout("admin/add_movie");
}

function admin_game_add()
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

        insert_new_game($game_data);
    }

    load_view_with_layout("admin/add_game");
}