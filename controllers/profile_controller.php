<?php

function profile_index()
{
    $user_id = null;
    if (!is_logged_in()) {
        set_flash("error", "you must be logged in");
        redirect("auth/login");
    } else {
        $user_id = current_user_id();
    }

    $user_info = get_user_by_id($user_id);
    if (!$user_info) {
        error_logging(ErrorType::Warning, "Unable to find user with id#" . $user_id);
        redirect('errors/404');
    }

    $has_borrowed_current = false;
    try {
        $borrow_current_info = get_current_borrow_list_by_user_id($user_id);
        if (!$borrow_current_info) {
            $borrow_current_info = [];
            $has_borrowed_current = false;
        } else {
            $has_borrowed_current = true;
            foreach ($borrow_current_info as &$elem) {
                $elem["estimated_return"] = get_estimated_return_date($elem['start']);
            }
        }
    } catch (Exception $e) {
        $msg = $e->getMessage();
        set_flash('error', $msg);
        error_logging(ErrorType::Error, $msg);
    }

    $has_borrow_history = false;
    try {

        $current_page = get_current_page();
        $limit = 10;
        $offset = ($current_page - 1) * $limit;
        $borrow_history_info = get_borrow_history_list_by_user_id($user_id, $limit, $offset);


        if (!$borrow_history_info) {
            $borrow_history_info = [];
            $has_borrow_history = false;
        } else {
            $has_borrow_history = true;
        }
    } catch (Exception $e) {
        $msg = $e->getMessage();
        set_flash('error', $msg);
        error_logging(ErrorType::Error, $msg);
    }

    $data = [
        'name' => $user_info["name"],
        'email' => $user_info["email"],
        'created_at' => $user_info["created_at"],
        'has_borrow_current' => $has_borrowed_current,
        'borrow_current_info' => $borrow_current_info,
        'has_borrow_history' => $has_borrow_history,
        'borrow_history_info' => $borrow_history_info,
        'current_page' => $current_page,
        'pages' => ceil(get_borrow_history_count_by_user_id($user_id) / $limit),
        'stylesheets' => [
            'assets/css/media.css',
            'assets/css/user.css',
            'assets/css/profile.css',
            'assets/css/pagination.css',
        ]
    ];
    load_view_with_layout('profile/index', $data);
}
