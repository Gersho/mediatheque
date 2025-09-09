<?php


function get_borrow_count_by_user_id(int $user_id)
{
    $query = "SELECT COUNT(id) FROM borrowed WHERE user_id = ? AND return_date is NULL";
    return db_select_one($query, [$user_id])["COUNT(id)"];
}

function get_media_stock_by_id(int $media_id)
{
    $query = "SELECT stock FROM medias WHERE id = ?";
    return db_select_one($query, [$media_id])["stock"];
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
function is_media_already_borrowed_by_user(int $media_id, int $user_id)
{
    $query = "SELECT id FROM borrowed WHERE user_id = ? AND media_id = ? AND return_date is NULL";
    $ret = db_select_one($query, [$user_id, $media_id]);
    return (bool) $ret;

}
// Incrémente le stock 1 par 1 dans la table medias
function increment_media_stock(int $media_id) {
    $query = "UPDATE medias SET stock = stock + 1 WHERE id = ?";
    return db_execute($query, [$media_id]);
}
// MAJ de la table borrowed sans rien changer car MAJ automatique de la valeur DATE DE RETOUR
// au moment de l'update de la table ???
function return_borrowed_media($media_id, $user_id)
{
    $query = "UPDATE borrowed SET return_date = NOW() WHERE media_id = ? AND user_id = ?";
    db_execute($query, [$media_id, $user_id]); 
}

// Fonction qui gere les deux updates des deux tables MAJ
// dans le cadre d'un retour média
// Si probleme, on rollback
function return_media(int $media_id, int $user_id)
{
    db_begin_transaction();
    try {
        return_borrowed_media($media_id, $user_id);
        increment_media_stock($media_id);
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