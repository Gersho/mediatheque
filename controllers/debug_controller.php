<?php

function debug_index()
{

    if (is_post()) {
        if (isset($_POST["movies"])) {
            $response = file_get_contents("https://api.imdbapi.dev/titles?types=MOVIE&startYear=1900&sortBy=SORT_BY_USER_RATING_COUNT&sortOrder=DESC");
            if ($response) {
                $response = json_decode($response, true);
                $movies = $response["titles"];
                foreach ($movies as $movie) {
                    $response = file_get_contents("https://api.imdbapi.dev/titles/" . $movie["id"]);
                    if ($response) {
                        $movie = json_decode($response, true);
                        $data["type"] = "Movie";
                        $data["title"] = $movie["primaryTitle"];
                        $data["published_year"] = $movie["startYear"];
                        $data["duration"] = $movie["runtimeSeconds"] / 60;
                        $data["genre"] = $movie["genres"][0];

                        $array = ['Tous publics', '-12', '-16', '-18'];
                        $rand = $array[array_rand($array)];
                        $data["certification"] = $rand;
                        $data["director"] = $movie["directors"][0]['displayName'];
                        $data["synopsis"] = $movie["plot"];
                        $data["stock"] = rand(1, 20);
                        try {
                            $data["cover_img"] = upload_cover_from_url($movie["primaryImage"]["url"]);
                            insert_new_media($data, 'insert_new_movie');
                        } catch (Exception $e) {
                            error_logging(ErrorType::Error, $e->getMessage());
                        }
                    }
                }
            }
        } else if (isset($_POST['games'])) {
            $response = file_get_contents('https://api.imdbapi.dev/titles?types=VIDEO_GAME&startYear=1900&sortBy=SORT_BY_USER_RATING_COUNT&sortOrder=DESC');
            if ($response) {
                $response = json_decode($response, true);
                $games = $response["titles"];
                foreach ($games as $game) {
                    $data["type"] = "Game";
                    $data["title"] = $game["primaryTitle"];
                    $data["genre"] = $game["genres"][0];
                    $array = ['PC', 'PlayStation', 'Xbox', 'Nintendo', 'Mobile'];
                    $rand = $array[array_rand($array)];
                    $data["plateform"] = $rand;

                    $array = ['3', '7', '12', '16', '18'];
                    $rand = $array[array_rand($array)];
                    $data["pegi"] = $rand;

                    $data["description"] = $game["plot"];
                    $data["stock"] = rand(1, 20);

                    $array = ['Rockstar Games', 'Bungie', 'From Software', 'Bandai Namco', 'Bethesda'];
                    $rand = $array[array_rand($array)];
                    $data["editor"] = $rand;
                    try {
                        $data["cover_img"] = upload_cover_from_url($game["primaryImage"]["url"]);
                        insert_new_media($data, 'insert_new_game');
                    } catch (Exception $e) {
                        error_logging(ErrorType::Error, $e->getMessage());
                    }
                }
            }
        } else if (isset($_POST['books'])) {
        } elseif (isset($_POST['clean'])) {
            $sql = 'DELETE FROM medias';
            try {
                db_execute($sql);
                set_flash('success', 'Database cleaned');
            } catch (Exception $e) {
                set_flash('error', $e->getMessage());
            }
        }
    }
    load_view_with_layout('admin/database');
}
