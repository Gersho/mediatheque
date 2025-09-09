<?php

function media_borrow()
{

    // $_POST["id"] is media id
    if (!is_post() || !isset($_POST["id"])) {
        redirect('errors/404');
    }

    error_logging(ErrorType::Debug, "in media_borrow with MEDIA id " . $_POST["id"]);

    $user_id = null;
    if (!is_logged_in()) {
        set_flash("error", "Veuillez vous connecter");
        redirect("auth/login");
    } else {
        $user_id = current_user_id();
    }

    error_logging(ErrorType::Debug, "in media_borrow with USER id " . $user_id);

    //check if media is available
    $media_id = intval(escape($_POST["id"]));
    $ret = get_media_stock_by_id($media_id);
    if (!$ret || $ret <= 0) {
        set_flash("error", "Ce média n'est pas disponible");
        redirect("home");
    }

    error_logging(ErrorType::Debug, "get_borrow_count_by_user_id " . $user_id . "|| count: " . get_borrow_count_by_user_id($user_id));

    //check media already borrowed by this user
    if (is_media_already_borrowed_by_user($media_id, $user_id)) {
        set_flash("error", "Vous avez déjà emprunté ce média");
        redirect("home");
    }

    //check user has rented less than 3
    if (get_borrow_count_by_user_id($user_id) >= 3) {
        set_flash("error", "Vous avez atteint le maximum d'emprunts par utilisateur (3)");
        redirect("home");
    }

    //(TODO optional) check user has no late media


    if (!borrow_media($media_id, $user_id)) {
        //failure
        set_flash("error", "Quelque chose n'a pas fonctionné");
        error_logging(ErrorType::Error, "Failed to borrow media" . $media_id . " by user " . $user_id);
        redirect("home");
    }


    //TODO rework this part
    $msg = "Média emprunté avec succès " . $media_id;
    $data = [
        'title' => 'Profile',
        'message' => $msg,
        'content' => "Merci d'avoir emprunté chez nous"
    ];

    load_view_with_layout('home/profile', $data);
}

function media_return()
{

    // TODO: REMPLACER LES GET PAR POST

    // $_POST["id"] is media id
    if (!is_post() || !isset($_POST["id"])) {
        redirect('errors/404');
    }

    error_logging(ErrorType::Debug, "in media_borrow with MEDIA id " . $_POST["id"]);
    $media_id = $_POST['id'];
    $user_id = null;
    if (!is_logged_in()) {
        set_flash("error", "you must be logged in");
        redirect("auth/login");
    } else {
        $user_id = current_user_id();
    }

    error_logging(ErrorType::Debug, "in media_borrow with USER id " . $user_id);

    //check if media is already borrowed by user
    if (!is_media_already_borrowed_by_user($media_id, $user_id)) {
        set_flash("error", "Vous ne pouvez pas rendre ce média : " . $media_id);
        redirect('home/profile');
    }


    if (!return_media($media_id, $user_id)) {
        //failure
        set_flash("error", "Quelque chose s'est mal passé");
        error_logging(ErrorType::Error, "Failed to borrow media" . $media_id . " by user " . $user_id);
        redirect("home");
    }


    //TODO rework this part
    $msg = "Le média a bien été rendu: " . $media_id;
    $data = [
        'title' => 'Profile',
        'message' => $msg,
        'content' => 'Merci pour votre retour'
    ];

    load_view_with_layout('home/profile', $data);

}