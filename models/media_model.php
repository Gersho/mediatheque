<?php

function insert_new_media(array $data, callable $insert_func)
{
    db_begin_transaction();
    extract($data);
    try {
        $query = "INSERT INTO medias (title, genre, type, stock) VALUES (?,?,?,?)";
        db_execute($query, [$title, $genre, $type, $stock]);
        $insert_func(db_last_insert_id(), $data);
        db_commit();
        set_flash('success', 'Média ajouté avec succès');
        return true;
    } catch (PDOException $e) {
        $msg = "Insert Error. Media Type: $type | Media title: $title | Type: PDOException | Message: " . $e->getMessage();
        set_flash('error', $msg);
        error_logging(ErrorType::Error, $msg);
        db_rollback();
    }
    return false;
}



function get_filtered_medias(): array
{
    $default = ['medias' => [], 'current_page' => 1, 'pages' => 1];
    $current_page = $_GET['page'] ?? 1;
    if (!filter_var($current_page, FILTER_VALIDATE_INT)) {
        set_flash('error', 'Numéro de page invalide');
        return $default;
    }
    $current_page = (int) $current_page;
    if ($current_page <= 0) {
        set_flash('error', 'Numéro de page invalide');
        return $default;
    }
    $per_page = 10;
    $count = get_media_count();
    $nb_pages = ceil($count / $per_page);
    if ($current_page > $nb_pages) {
        set_flash('error', 'Numéro de page invalide');
        return $default;
    }
    $offset = ($current_page - 1) * $per_page;
    $sql = "
        SELECT * FROM medias
        LIMIT $per_page OFFSET $offset";
    $medias = db_select($sql);
    return [
        "medias" => $medias,
        "pages" => $nb_pages,
        "current_page" => $current_page
    ];
}

function get_media_count(): int
{
    $sql = 'SELECT COUNT(id) FROM medias';
    return db_connect()->query($sql)->fetch(PDO::FETCH_NUM)[0];
}

function get_media_url(int $id, string $type)
{
    if ($type === 'Game') {
        return url("game/show?id=$id");
    } else if ($type === 'Movie') {
        return url("movie/show?id=$id");
    } else {
        return url("book/show?id=$id");
    }
}
