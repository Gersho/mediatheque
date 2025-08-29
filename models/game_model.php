<?php

function get_game_by_id($id)
{
    $query = "SELECT * FROM  games WHERE id = ? LIMIT 1";
    return db_select_one($query, [$id]);
}

function insert_new_game($game_data)
{
        $id = insert_new_media('Game');

        $query = "INSERT INTO games
        (id,title, genre, stock, editor, plateform, pegi, description)
        VALUES(?,?,?,?,?,?,?,?)";

                if (db_execute(
                    $query,
                    [
                        $id,
                        $game_data['title'],
                        $game_data['genre'],
                        $game_data['stock'],
                        $game_data['editor'],
                        $game_data['plateform'],
                        $game_data['pegi'],
                        $game_data['description'],
                    ]
                )) {
                    set_flash('success','Média ajouté avec succès');
                    return db_last_insert_id();
                }
                return false;
    }

