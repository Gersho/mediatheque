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
        set_flash("error", "you must be logged in");
        redirect("auth/login");
    } else {
        $user_id = current_user_id();
    }

    error_logging(ErrorType::Debug, "in media_borrow with USER id " . $user_id);

    //check if media is available
    $media_id = escape($_POST["id"]);
    if (get_media_stock_by_id($media_id) <= 0) {
        set_flash("error", "item is out of stock");
        redirect("home");
    }

    error_logging(ErrorType::Debug, "get_borrow_count_by_user_id " . $user_id . "|| count: " . get_borrow_count_by_user_id($user_id)["COUNT(id)"]);

    //check user has rented less than 3
    if (get_borrow_count_by_user_id($user_id)["COUNT(id)"] >= 3) {
        set_flash("error", "You are already renting the maximum number of medias");
        redirect("home");
    }


    //(TODO optional) check user has no late media


    if (!borrow_media($media_id, $user_id)) {
        //failure
        set_flash("error", "Something went wrong");
        error_logging(ErrorType::Error, "Failed to borrow media" . $media_id . " by user " . $user_id);
        redirect("home");
    }


    //TODO rework this part
    $msg = "OK rent media: " . $media_id;
    $data = [
        'title' => 'Profile',
        'message' => $msg,
        'content' => 'Cette application est un starter kit PHP MVC développé avec une approche procédurale.'
    ];

    load_view_with_layout('home/profile', $data);
}