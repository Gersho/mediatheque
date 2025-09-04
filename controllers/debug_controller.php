<?php

function debug_index()
{

    if (is_post()) {
        var_dump($_POST);
        if (isset($_POST["movies"])) {
            $response = file_get_contents("https://api.imdbapi.dev/titles?types=MOVIE&startYear=1900&sortBy=SORT_BY_USER_RATING_COUNT&sortOrder=DESC");
            if ($response) {
                $response = json_decode($response, true);
                $movies = $response["titles"];
                foreach ($movies as $movie) {
                    $data["type"] = "Movie";
                    $data["title"] = $movie["primaryTitle"];
                    $data["published_year"] = $movie["startYear"];
                    $data["duration"] = $movie["runtimeSeconds"] / 60;
                    $data["genre"] = $movie["genres"][0];
                    $data["certification"] = "-12";
                    $data["director"] = "dunno";
                    $data["synopsis"] = $movie["plot"];
                    $data["stock"] = 1;
                    try {
                        $data["cover_img"] = upload_cover_from_url($movie["primaryImage"]["url"]);
                        insert_new_media($data, 'insert_new_movie');
                    } catch (Exception $e) {
                        error_logging(ErrorType::Error, $e->getMessage());
                    }
                }
            }
        } else if (isset($_POST['games'])) {
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
    load_view_with_layout('debug/index');
}
