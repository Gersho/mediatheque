<?php

function admin_add_book()
{
    $errors = [];
    $book_data = [];


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

    $genre_enum = [
        'Action',
        'Comedy',
        'Documentary',
        'Drama',
        'Fantasy',
        'Horror',
        'Musical',
        'Mystery',
        'Romance',
        'Science Fiction',
        'Thriller',
        'Western',
    ];

    if (is_post()) {
        foreach ($all_data as $key) {
            if (isset($_POST[$key])) {
                $temp = clean_input($_POST[$key]);
                if ($key === 'title' && !(strlen($temp) > 1 && strlen($temp) < 200)) {
                    $errors['title'] = 'Titre invalide (nombre de caractères)';
                } elseif ($key === 'genre' && !in_array($temp, $genre_enum)) {
                    $errors['genre'] = "Genre invalide";
                } elseif ($key === 'stock' && !($temp >= 1 && filter_var($temp, FILTER_VALIDATE_INT))) {
                    $errors['stock'] = 'Le stock doit être un entier positif';
                } elseif ($key === 'author' && !(strlen($temp) >= 2 && strlen($temp) <= 100)) {
                    $errors['author'] = 'Auteur invalide (nombre de caractères)';
                } elseif (
                    $key === 'isbn' &&
                    ((strlen($temp) !== 10 && strlen($temp) !== 13 && !is_numeric($temp)) ||
                        !check_isbn_unique($temp))
                ) {
                    $errors['isbn'] = 'ISBN invalide (10 ou 13 chiffres) ou déjà utilisé';
                } elseif ($key === 'pages' && !($temp >= 1 && $temp <= 9999) && !filter_var($temp, FILTER_VALIDATE_INT)) {
                    $errors['pages'] = 'Le nombre de pages doit être un entier entre 1 et 9999';
                } elseif ($key === 'published_year' && !($temp >= 1900 && $temp <= date('Y'))) {
                    $errors['published_year'] = "L'année de publication doit être comprise entre 1900 et l'année actuelle";
                } elseif ($key === 'summary' && !(strlen($temp) >= 1 && strlen($temp) <= 3000)) {
                    $errors['summary'] = "Le résumé doit comprendre entre 1 et 3000 caractères";
                }
                $book_data[$key] = $temp;
            } else {
                set_flash("error", "Veuillez remplir tous les champs");
                $errors[$key] = 'Veuillez remplir tous les champs';
            }
        }

        if (empty($errors)) {

            $book_data['type'] = 'Book';
            insert_new_media($book_data, 'insert_new_book');
            redirect('admin/medias');
            exit();
        } else {
            foreach ($errors as $key => $msg) {
                set_flash('error', $msg);
            }
        }
    }

    $data = [
        "entries" => $book_data,
        "action" => 'Ajouter',
        "genre_enum" => $genre_enum,
    ];

    load_view_with_layout("admin/add_book", $data);
}
function admin_add_movie()
{
    $errors = [];
    $movie_data = [];

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

    $genre_enum = [
        'Action',
        'Comedy',
        'Documentary',
        'Drama',
        'Fantasy',
        'Horror',
        'Musical',
        'Mystery',
        'Romance',
        'Science Fiction',
        'Thriller',
        'Western',
    ];

    $certification_enum = [
        'Tous publics',
        '-12',
        '-16',
        '-18',
    ];

    if (is_post()) {
        foreach ($all_data as $key) {
            if (isset($_POST[$key])) {
                $temp = clean_input($_POST[$key]);
                if ($key === 'title' && !(strlen($temp) > 1 && strlen($temp) < 200)) {
                    $errors['title'] = 'Titre invalide (nombre de caractères)';
                } elseif ($key === 'genre' && !in_array($temp, $genre_enum)) {
                    $errors['genre'] = 'Genre invalide';
                } elseif ($key === 'stock' && !($temp >= 1 && filter_var($temp, FILTER_VALIDATE_INT))) {
                    $errors['stock'] = 'Le stock doit être un entier positif';
                } elseif ($key === 'director' && !(strlen($temp) >= 2 && strlen($temp) <= 100)) {
                    $errors['director'] = 'Réalisateur invalide (nombre de caractères)';
                } elseif ($key === 'duration' && !($temp >= 1 && $temp <= 999) && !filter_var($temp, FILTER_VALIDATE_INT)) {
                    $errors['duration'] = 'La durée du film doit être un entier entre 1 et 999';
                } elseif ($key === 'published_year' && !($temp >= 1900 && $temp <= date('Y'))) {
                    $errors['published_year'] = "L'année de publication doit être comprise entre 1900 et l'année actuelle";
                } elseif ($key === 'synopsis' && !(strlen($temp) <= 3000)) {
                    $errors['summary'] = "Synopsis: maximum 3000 caractères";
                } elseif ($key === 'certification' && !in_array($temp, $certification_enum)) {
                    $errors['certification'] = 'Public cible invalide';
                }
                $movie_data[$key] = $temp;
            } else {
                set_flash("error", "Veuillez remplir tous les champs");
            }
        }
        if (empty($errors)) {

            $movie_data['type'] = 'Movie';
            insert_new_media($movie_data, 'insert_new_movie');
            redirect('admin/medias');
            exit();
        } else {
            foreach ($errors as $key => $msg) {
                set_flash('error', $msg);
            }
        }
    }
    $data = [
        "entries" => $movie_data,
        "action" => 'Ajouter',
        "genre_enum" => $genre_enum,
        "certification_enum" => $certification_enum,
    ];


    load_view_with_layout("admin/add_movie", $data);

}

function admin_add_game()
{
    $errors = [];
    $game_data = [];



    $all_data = [
        "title",
        "genre",
        "stock",
        "editor",
        "plateform",
        "pegi",
        "description",
        "cover_img",
    ];

    $genre_enum = [
        'FPS',
        'MMO',
        'MOBA',
        'RPG'
    ];

    $plateform_enum = [
        'PC',
        'PlayStation',
        'Xbox',
        'Nintendo',
        'Mobile',
    ];

    $pegi_enum = [
        '3',
        '7',
        '12',
        '16',
        '18',
    ];

    if (is_post()) {
        foreach ($all_data as $key) {
            if (isset($_POST[$key])) {

                $temp = clean_input($_POST[$key]);

                if ($key === 'title' && !(strlen($temp) > 1 && strlen($temp) < 200)) {
                    $errors['title'] = 'Titre invalide (nombre de caractères)';
                } elseif ($key === 'genre' && !in_array($temp, $genre_enum)) {
                    $errors['genre'] = 'Genre invalide';
                } elseif ($key === 'stock' && !($temp >= 1 && filter_var($temp, FILTER_VALIDATE_INT))) {
                    $errors['stock'] = 'Le stock doit être un entier positif';
                } elseif ($key === 'editor' && !(strlen($temp) >= 2 && strlen($temp) <= 100)) {
                    $errors['editor'] = 'Éditeur invalide (nombre de caractères)';
                } elseif ($key === 'plateform' && !in_array($temp, $plateform_enum)) {
                    $errors['plateform'] = "Plateforme invalide";
                } elseif ($key === 'pegi' && !in_array($temp, $pegi_enum)) {
                    $errors['pegi'] = 'Public cible invalide';
                } elseif ($key === 'description' && !(strlen($temp) <= 3000)) {
                    $errors['description'] = "Description: maximum 3000 caractères";
                }
                $game_data[$key] = $temp;
            } else {
                set_flash("error", "Veuillez remplir tous les champs");
            }
        }
        if (empty($errors)) {

            $game_data['type'] = 'Game';
            insert_new_media($game_data, 'insert_new_game');
            redirect('admin/medias');
            exit();
        } else {
            foreach ($errors as $key => $msg) {
                set_flash('error', $msg);
            }
        }
    }

    $data = [
        "entries" => $game_data,
        "action" => 'Ajouter',
        "genres_enum" => $genre_enum,
        "plateform_enum" => $plateform_enum,
        "pegi_enum" => $pegi_enum,
    ];

    load_view_with_layout("admin/add_game", $data);
}
function admin_index()
{
    load_view_with_layout("admin/index");
}
function admin_medias()
{
    $data = [
        'title' => 'Admin Medias Dashboard',
        'stylesheets' => [
            'assets/css/search_bar.css',
            'assets/css/pagination.css',
            'assets/css/admin.css'
        ],
    ];
    $filter_list = ["title", "type", "genre", "available"];
    $filters = [];
    foreach ($filter_list as $filter) {
        if (isset($_GET[$filter])) {
            $clean_input = clean_input($_GET[$filter]);
            if (!empty($clean_input)) {
                $filters[$filter] = $clean_input;
            }
        }
    }
    $medias = get_medias($filters);
    $data = array_merge($data, $medias);

    load_view_with_layout('admin/medias', $data);
}

function admin_edit_book()
{
    $id = $_GET['id'];
    $errors = [];
    //todo check if exist
    $book_data = get_book_by_id($id);

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

    $genre_enum = [
        'Action',
        'Comedy',
        'Documentary',
        'Drama',
        'Fantasy',
        'Horror',
        'Musical',
        'Mystery',
        'Romance',
        'Science Fiction',
        'Thriller',
        'Western',
    ];

    if (is_post()) {
        foreach ($all_data as $key) {
            if (!isset($_POST[$key])) {
                $errors[$key] = "$key n'est pas renseigné";
                continue;
            }
            // VALIDATION DES CHAMPS PRÉREMPLIS SAUF ISBN UNIQUE
            $temp = clean_input($_POST[$key]);
            if ($key === 'title' && !(strlen($temp) > 1 && strlen($temp) < 200)) {
                $errors['title'] = 'Titre invalide (nombre de caractères)';
            } elseif ($key === 'genre' && !in_array($temp, $genre_enum)) {
                $errors['genre'] = "Genre invalide";
            } elseif ($key === 'stock' && !($temp >= 1 && filter_var($temp, FILTER_VALIDATE_INT))) {
                $errors['stock'] = 'Le stock doit être un entier positif';
            } elseif ($key === 'author' && !(strlen($temp) >= 2 && strlen($temp) <= 100)) {
                $errors['author'] = 'Auteur invalide (nombre de caractères)';
            } elseif (
                $key === 'isbn' &&
                ((strlen($temp) !== 10 && strlen($temp) !== 13 && !is_numeric($temp)))
            ) {
                $errors['isbn'] = 'ISBN invalide (10 ou 13 chiffres) ou déjà utilisé';
            } elseif ($key === 'pages' && !($temp >= 1 && $temp <= 9999) && !filter_var($temp, FILTER_VALIDATE_INT)) {
                $errors['pages'] = 'Le nombre de pages doit être un entier entre 1 et 9999';
            } elseif ($key === 'published_year' && !($temp >= 1900 && $temp <= date('Y'))) {
                $errors['published_year'] = "L'année de publication doit être comprise entre 1900 et l'année actuelle";
            } elseif ($key === 'summary' && !(strlen($temp) >= 1 && strlen($temp) <= 3000)) {
                $errors['summary'] = "Le résumé doit comprendre entre 1 et 3000 caractères";
            }
            $book_data[$key] = $temp;
        }
        if (empty($errors)) {
            if (update_media($book_data, 'update_book')) {
                redirect(path: 'admin/medias');
            }
        } else {
            foreach ($errors as $key => $msg) {
                set_flash('error', $msg);
            }
        }
    }
    $data = [
        "action" => 'Modifier',
        "entries" => $book_data,
        "genres_enum" => $genre_enum,
    ];
    load_view_with_layout('admin/add_book', $data);
}

function admin_users()
{
    $data = [
        'stylesheets' => [
            'assets/css/pagination.css',
            'assets/css/user.css',
        ]
    ];

    $data['current_page'] = get_current_page();
    $limit = 10;
    $data['pages'] = ceil(count_users() / $limit);
    $offset = ($data['current_page'] - 1) * $limit;
    $users = get_all_users($limit, $offset);
    $data['users'] = $users;
    $data['fields'] = ['id', 'nom', 'email', 'création'];

    load_view_with_layout('admin/users', $data);
}

function admin_edit_movie()
{
    //TODO validation id from GET 
    $id = $_GET['id'];
    $errors = [];
    //todo check if exist
    $movie_data = get_movie_by_id($id);


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

    $genre_enum = [
        'Action',
        'Comedy',
        'Documentary',
        'Drama',
        'Fantasy',
        'Horror',
        'Musical',
        'Mystery',
        'Romance',
        'Science Fiction',
        'Thriller',
        'Western',
    ];

    $certification_enum = [
        'Tous publics',
        '-12',
        '-16',
        '-18',
    ];

    if (is_post()) {
        foreach ($all_data as $key) {
            if (!isset($_POST[$key])) {
                $errors[$key] = "$key n'est pas renseigné";
                continue;
            }
            $temp = clean_input($_POST[$key]);
            if ($key === 'title' && !(strlen($temp) > 1 && strlen($temp) < 200)) {
                $errors['title'] = 'Titre invalide (nombre de caractères)';
            } elseif ($key === 'genre' && !in_array($temp, $genre_enum)) {
                $errors['genre'] = 'Genre invalide';
            } elseif ($key === 'stock' && !($temp >= 1 && filter_var($temp, FILTER_VALIDATE_INT))) {
                $errors['stock'] = 'Le stock doit être un entier positif';
            } elseif ($key === 'director' && !(strlen($temp) >= 2 && strlen($temp) <= 100)) {
                $errors['director'] = 'Réalisateur invalide (nombre de caractères)';
            } elseif ($key === 'duration' && !($temp >= 1 && $temp <= 999) && !filter_var($temp, FILTER_VALIDATE_INT)) {
                $errors['duration'] = 'La durée du film doit être un entier entre 1 et 999';
            } elseif ($key === 'published_year' && !($temp >= 1900 && $temp <= date('Y'))) {
                $errors['published_year'] = "L'année de publication doit être comprise entre 1900 et l'année actuelle";
            } elseif ($key === 'synopsis' && !(strlen($temp) <= 3000)) {
                $errors['summary'] = "Synopsis: maximum 3000 caractères";
            } elseif ($key === 'certification' && !in_array($temp, $certification_enum)) {
                $errors['certification'] = 'Public cible invalide';
            }
            $movie_data[$key] = $temp;

        }
        if (empty($errors)) {
            if (update_media($movie_data, 'update_movie')) {
                redirect(path: 'admin/medias');
            }
        } else {
            foreach ($errors as $key => $msg) {
                set_flash('error', $msg);
            }
        }
    }
    $data = [
        "action" => 'Modifier',
        "entries" => $movie_data,
        "genres_enum" => $genre_enum,
        "certification_enum" => $certification_enum,
    ];
    load_view_with_layout('admin/add_movie', $data);
}

function admin_edit_game()
{
    //TODO validation id from GET 
    $id = $_GET['id'];
    $errors = [];
    //todo check if exist
    $game_data = get_game_by_id($id);

    $all_data = [
        "title",
        "genre",
        "stock",
        "editor",
        "plateform",
        "pegi",
        "description",
    ];

    $genre_enum = [
        'FPS',
        'MMO',
        'MOBA',
        'RPG'
    ];

    $plateform_enum = [
        'PC',
        'Playstation',
        'Xbox',
        'Nintendo',
        'Mobile',
    ];

    $pegi_enum = [
        '3',
        '7',
        '12',
        '16',
        '18',
    ];

    if (is_post()) {
        foreach ($all_data as $key) {
            if (!isset($_POST[$key])) {
                $errors[$key] = "$key n'est pas renseigné";
                continue;
            }
            $game_data[$key] = clean_input($_POST[$key]);
            if ($key === 'title' && !(strlen($game_data[$key]) > 1 && strlen($game_data[$key]) < 200)) {
                $errors['title'] = 'Titre invalide (nombre de caractères)';
            } elseif ($key === 'genre' && !in_array($game_data[$key], $genre_enum)) {
                $errors['genre'] = 'Genre invalide';
            } elseif ($key === 'stock' && !($game_data[$key] >= 1 && filter_var($game_data[$key], FILTER_VALIDATE_INT))) {
                $errors['stock'] = 'Le stock doit être un entier positif';
            } elseif ($key === 'editor' && !(strlen($game_data[$key]) >= 2 && strlen($game_data[$key]) <= 100)) {
                $errors['editor'] = 'Éditeur invalide (nombre de caractères)';
            } elseif ($key === 'plateform' && !in_array($game_data[$key], $plateform_enum)) {
                $errors['plateform'] = "Plateforme invalide";
            } elseif ($key === 'pegi' && !in_array($game_data[$key], $pegi_enum)) {
                $errors['pegi'] = 'Public cible invalide';
            } elseif ($key === 'description' && !(strlen($game_data[$key]) <= 3000)) {
                $errors['description'] = "Description: maximum 3000 caractères";
            }
        }
        if (empty($errors)) {
            if (update_media($game_data, 'update_game')) {
                redirect(path: 'admin/medias');
            }
        } else {
            foreach ($errors as $key => $msg) {
                set_flash('error', $msg);
            }
        }
    }
    $data = [
        "action" => 'Modifier',
        "entries" => $game_data,
        "genres_enum" => $genre_enum,
        "plateform_enum" => $plateform_enum,
        "pegi_enum" => $pegi_enum,
    ];
    load_view_with_layout('admin/add_game', $data);
}


function admin_delete_media()
{
    $id = $_GET['id'];

    // check if not borrowed
    delete_media_from_db($id);
}
