<?php

function media_borrow()
{
    if (!is_post() || !isset($_POST["id"]) || !filter_var($_POST["id"], FILTER_VALIDATE_INT)) {
        redirect('errors/404');
    }

    if (!is_logged_in()) {
        set_flash("error", "Veuillez vous connecter");
        redirect("auth/login");
    }
    $media_id = (int) ($_POST["id"]);
    $user_id = current_user_id();

    // Verification du CSRF
    if (!verify_csrf_token($_POST['csrf_token'])) {
        set_flash('error', "Token CSRF invalide");
        error_logging(ErrorType::Error, "Invalid CSRF token while borrowing media: " . $_POST['id'] . 'by user: ' . $user_id);
        redirect('error/403');
    }

    //check if media is available
    $ret = get_media_stock_by_id($media_id);
    if (!$ret || $ret <= 0) {
        set_flash("error", "Ce média n'est pas disponible");
        redirect("home");
    }

    //check user has rented less than 3
    if (get_borrow_count_by_user_id($user_id) >= 3) {
        set_flash("error", "Vous avez déja atteint la limite de 3 emprunts simultanés");
        redirect("home");
    }

    //(TODO optional) check user has no late media


    if (!borrow_media($media_id, $user_id)) {
        //failure
        set_flash("error", "Quelque chose n'a pas fonctionné");
        error_logging(ErrorType::Error, "Failed to borrow media" . $media_id . " by user " . $user_id);
        redirect("home");
    }
    redirect("profile");
}

function media_return()
{
    if (!is_post() || !isset($_POST["id"]) || !filter_var($_POST["id"], FILTER_VALIDATE_INT)) {
        redirect('errors/404');
    }

    if (!isset($_POST['csrf_token']) || !verify_csrf_token($_POST['csrf_token'])) {
        set_flash('error', "Token CSRF invalide");
        error_logging(ErrorType::Error, "Tried to add book without valid token");
        redirect('home/profile');
    }

    $media_id = (int) $_POST['id'];

    if (!is_logged_in()) {
        set_flash("error", "you must be logged in");
        redirect("auth/login");
    }

    $user_id = current_user_id();

    if (!return_media($media_id, $user_id)) {
        //failure
        set_flash("error", "Quelque chose s'est mal passé");
        redirect("home");
    }

    set_flash("success", "Le media a bien été rendu");
    redirect("profile");
}