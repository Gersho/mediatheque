<?php

function get_movie_by_id($id)
{
    $query = "SELECT * FROM  movies WHERE id = ? LIMIT 1";
    return db_select_one($query, [$id]);
}

function insert_new_movie($movie_data)
{
        $id = insert_new_media('Movie');

        $query = "INSERT INTO movies 
        (id, title, genre, stock, director, duration, published_year, synopsis, certification)
        VALUES(?,?,?,?,?,?,?,?,?)";

                if (db_execute(
                    $query,
                    [
                        $id,
                        $movie_data['title'],
                        $movie_data['genre'],
                        $movie_data['stock'],
                        $movie_data['director'],
                        $movie_data['duration'],
                        $movie_data['published_year'],
                        $movie_data['synopsis'],
                        $movie_data['certification'],
                    ]
                )) {
                    set_flash('success','Média ajouté avec succès');
                    return db_last_insert_id();
                }
                return false;
    }
