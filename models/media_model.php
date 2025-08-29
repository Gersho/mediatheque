<?php
// TODO filter for real

function insert_new_media($type) 
{

    $query = "INSERT INTO medias (type) VALUES (?)";
    if (db_execute($query, [$type]))
        {
            return db_last_insert_id();
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
        SELECT *, 
        COALESCE(medias.id, b.id, m.id, g.id) AS id,
        COALESCE(b.title, m.title, g.title) AS title,
        COALESCE(b.genre, m.genre, g.genre) AS genre,
        COALESCE(b.published_year, m.published_year) AS published_year,
        COALESCE(b.stock, m.stock, g.stock) AS stock FROM medias 
        LEFT JOIN movies m ON m.id = medias.id
        LEFT JOIN books b ON b.id = medias.id
        LEFT JOIN games g ON g.id = medias.id
        WHERE m.id IS NOT NULL OR g.id IS NOT NULL OR b.id IS NOT NULL
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
        return url("game/display?id=$id");
    } else if ($type === 'Movie') {
        return url("movie/display?id=$id");
    } else {
        return url("book/display?id=$id");
    }
}
