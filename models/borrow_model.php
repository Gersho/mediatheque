<?php


function get_borrow_count_by_user_id(int $user_id)
{
    $query = "SELECT COUNT(id) FROM borrowed WHERE user_id = ? AND return_date is NULL";
    return db_select_one($query, [$user_id]);
}

function get_media_stock_by_id(int $media_id)
{
    $query = "SELECT stock FROM medias WHERE id = ?";
    return db_select_one($query, [$media_id]);
}

function decrement_media_stock(int $media_id)
{
    $query = "UPDATE medias SET stock = stock - 1 WHERE id = ?";
    return db_execute($query, [$media_id]);
}

function add_borrowed_media(int $media_id, int $user_id)
{
    $query = "INSERT INTO borrowed (media_id, user_id) VALUES (?,?)";
    db_execute($query, [$media_id, $user_id]);
}

function borrow_media(int $media_id, int $user_id)
{
    db_begin_transaction();
    try {
        decrement_media_stock($media_id);
        add_borrowed_media($media_id, $user_id);
        db_commit();
        return true;
    } catch (Exception $e) {
        $msg = $e->getMessage();
        set_flash('error', $msg);
        error_logging(ErrorType::Error, $msg);
        db_rollback();
    }
    return false;
}