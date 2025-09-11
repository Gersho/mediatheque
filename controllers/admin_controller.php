<?php

function admin_add_book()
{
    $errors = [];
    $book_data = [];

    $all_data = get_books_fields();
    $genre_enum = get_books_movies_genres();

    if (is_post()) {
        if (!isset($_POST['csrf_token']) || !verify_csrf_token($_POST['csrf_token'])) {
            set_flash('error', "Token CSRF invalide");
            error_logging(ErrorType::Error, "Tried to add book without valid token");
            redirect('home/profile');
        }

        foreach ($all_data as $key) {
            if (!isset($_POST[$key])) {
                $errors[$key] = "$key n'est pas renseigné";
                continue;
            }
            $temp = trim($_POST[$key]);
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
                ((strlen($temp) !== 10 && strlen($temp) !== 13) || !is_numeric($temp) ||
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
        }

        if (empty($errors)) {

            $book_data['type'] = 'Book';
            insert_new_media($book_data, 'insert_new_book');
            redirect('admin/medias');
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


    $all_data = get_movies_fields();

    $genre_enum = get_books_movies_genres();
    $certification_enum = get_movies_certifications();

    if (is_post()) {
        if (!isset($_POST['csrf_token']) || !verify_csrf_token($_POST['csrf_token'])) {
            set_flash('error', "Token CSRF invalide");
            error_logging(ErrorType::Error, "Tried to add movie without valid token");
            redirect('home/profile');
        }

        foreach ($all_data as $key) {
            if (!isset($_POST[$key])) {
                $errors[$key] = "$key n'est pas renseigné";
                continue;
            }
            $temp = trim($_POST[$key]);
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

            $movie_data['type'] = 'Movie';
            insert_new_media($movie_data, 'insert_new_movie');
            redirect('admin/medias');
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
    $all_data = get_games_fields();
    $genre_enum = get_games_genres();
    $plateform_enum = get_games_plateforms();
    $pegi_enum = get_games_pegis();

    if (is_post()) {
        if (!isset($_POST['csrf_token']) || !verify_csrf_token($_POST['csrf_token'])) {
            set_flash('error', "Token CSRF invalide");
            error_logging(ErrorType::Error, "Tried to add game without valid token");
            redirect('home/profile');
        }

        foreach ($all_data as $key) {
            if (!isset($_POST[$key])) {
                $errors[$key] = "$key n'est pas renseigné";
                continue;
            }
            $temp = trim($_POST[$key]);

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
        }
        if (empty($errors)) {

            $game_data['type'] = 'Game';
            insert_new_media($game_data, 'insert_new_game');
            redirect('admin/medias');
        } else {
            foreach ($errors as $key => $msg) {
                set_flash('error', $msg);
            }
        }
    }

    $data = [
        "entries" => $game_data,
        "action" => 'Ajouter',
        "genre_enum" => $genre_enum,
        "plateform_enum" => $plateform_enum,
        "pegi_enum" => $pegi_enum,
    ];

    load_view_with_layout("admin/add_game", $data);
}
function admin_index()
{
    $data = [
        'title' => 'Admin Medias Dashboard',
        'stylesheets' => [
            'assets/css/admin.css'
        ],
    ];
    load_view_with_layout("admin/index", $data);
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
    if (!isset($_GET['id'])) {
        set_flash('error', "ID média invalide");
        redirect('admin/medias');
    }
    $id = $_GET['id'];
    $book_data = get_book_by_id($id);

    if (!$book_data) {
        set_flash('error', "Média introuvable");
        redirect('admim/medias');
    }

    $errors = [];
    $all_data = get_books_fields();
    $genre_enum = get_books_movies_genres();


    if (is_post()) {
        if (!isset($_POST['csrf_token']) || !verify_csrf_token($_POST['csrf_token'])) {
            set_flash('error', "Token CSRF invalide");
            error_logging(ErrorType::Error, "Tried to edit book without valid token");
            redirect('home/profile');
        }

        foreach ($all_data as $key) {
            if (!isset($_POST[$key])) {
                $errors[$key] = "$key n'est pas renseigné";
                continue;
            }
            // VALIDATION DES CHAMPS PRÉREMPLIS
            $temp = trim($_POST[$key]);
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
                ((strlen($temp) !== 10 && strlen($temp) !== 13) || !is_numeric($temp) ||
                    !check_isbn_unique($temp, $id))
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
        "genre_enum" => $genre_enum,
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

    try {
        $data['current_page'] = get_current_page();
        $limit = 10;
        $data['pages'] = ceil(count_users() / $limit);
        $offset = ($data['current_page'] - 1) * $limit;
        $data['users'] = get_all_users($limit, $offset);
        $data['fields'] = ['id', 'nom', 'email', 'création'];

        load_view_with_layout('admin/users', $data);
    } catch (Exception $e) {
        error_logging(ErrorType::Error, $e->getMessage());
        redirect('admin/users');
    }
}

function admin_edit_movie()
{
    if (!isset($_GET['id'])) {
        set_flash('error', "ID média invalide");
        redirect('admin/medias');
    }

    $id = $_GET['id'];
    $movie_data = get_movie_by_id($id);

    if (!$movie_data) {
        set_flash('error', "Média introuvable");
        redirect('admin/medias');
    }

    $errors = [];
    $all_data = get_movies_fields();
    $genre_enum = get_books_movies_genres();
    $certification_enum = get_movies_certifications();

    if (is_post()) {
        if (!isset($_POST['csrf_token']) || !verify_csrf_token($_POST['csrf_token'])) {
            set_flash('error', "Token CSRF invalide");
            error_logging(ErrorType::Error, "Tried to edit movie without valid token");
            redirect('home/profile');
        }

        foreach ($all_data as $key) {
            if (!isset($_POST[$key])) {
                $errors[$key] = "$key n'est pas renseigné";
                continue;
            }
            $temp = trim($_POST[$key]);
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

        "genre_enum" => $genre_enum,
        "certification_enum" => $certification_enum,

    ];
    load_view_with_layout('admin/add_movie', $data);
}

function admin_edit_game()
{
    if (!isset($_GET['id'])) {
        set_flash('error', "ID média invalide");
        redirect('admin/medias');
    }
    $id = $_GET['id'];
    $game_data = get_game_by_id($id);

    if (!$game_data) {
        set_flash('error', "Média introuvable");
        redirect('admin/medias');
    }

    $errors = [];
    $all_data = get_games_fields();


    $genre_enum = get_games_genres();
    $plateform_enum = get_games_plateforms();
    $pegi_enum = get_games_pegis();

    if (is_post()) {
        if (!isset($_POST['csrf_token']) || !verify_csrf_token($_POST['csrf_token'])) {
            set_flash('error', "Token CSRF invalide");
            error_logging(ErrorType::Error, "Tried to edit game without valid token");
            redirect('home/profile');
        }

        foreach ($all_data as $key) {
            if (!isset($_POST[$key])) {
                $errors[$key] = "$key n'est pas renseigné";
                continue;
            }
            $temp = trim($_POST[$key]);

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
        "genre_enum" => get_games_genres(),
        "plateform_enum" => get_games_plateforms(),
        "pegi_enum" => get_games_pegis(),
    ];


    load_view_with_layout('admin/add_game', $data);
}


function admin_delete_media()
{
    if (is_post() && isset($_POST['id']) && get_media_stock_by_id($_POST['id'])) {

        $id = $_POST['id'];

        // Verification si déjà emprunté par un utilisateur
        if (is_media_already_borrowed($id)) {
            set_flash("error", "Impossible de supprimer ce média car emprunt en cours");
            error_logging(ErrorType::Warning, "Tried to delete borrowed media: " . $id);
        } else {
            delete_media($id);
            set_flash("success", "Média supprimé avec succes");
            error_logging(ErrorType::Info, "Successfull deleted media: " . $id);
        }
    } else {
        set_flash('error', "ID média invalide");
    }
    redirect('admin/medias');
}

function admin_delete_user()
{
    if (is_post() && isset($_POST['id']) && filter_var($_POST['id'], FILTER_VALIDATE_INT)) {
        $redirect_url = $_POST['redirect'] ?? '';
        if (!verify_csrf_token(post('csrf_token', ''))) {
            error_logging(ErrorType::Warning, 'Wrong csrf token');
            redirect($redirect_url);
        }
        try {
            $id = (int) $_POST['id'];
            if (delete_user($id)) {
                set_flash('success', 'Utilisateur supprimé');
                error_logging(ErrorType::Info, "User with id: $id deleted");
            } else {
                set_flash("error", "L'utilisateur a des emprunts");
                error_logging(ErrorType::Error, "Failed to delete user with id: $id");
            }
        } catch (Exception $e) {
            error_logging(ErrorType::Error, '' . $e->getMessage());
        }
    }
    redirect($redirect_url ?? '');
}

function admin_force_return()
{
    if (
        !is_post() || !isset($_POST['user_id']) || !isset($_POST['media_id']) ||
        !filter_var($_POST['user_id'], FILTER_VALIDATE_INT) ||
        !filter_var($_POST['media_id'], FILTER_VALIDATE_INT)
    ) {
        set_flash('error', 'Echec du retour');
        redirect("admin/users");
    }
    $redirect_url = $_POST['redirect'] ?? '';
    $media_id = (int) $_POST['media_id'];
    $user_id = (int) $_POST['user_id'];

    if (!return_media($media_id, $user_id)) {
        set_flash('error', "Une erreur est survenue. Veuillez réessayer.");
    } else {
        set_flash("success", "Le media a été rendu");
    }
    redirect($redirect_url);
}
