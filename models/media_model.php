<?php

function insert_new_media(array $data, callable $insert_func)
{
    db_begin_transaction();
    extract($data);
    try {
        $query = "INSERT INTO medias (title, genre, type, stock, cover_path) VALUES (?,?,?,?,?)";
        db_execute($query, [$title, $genre, $type, $stock, $cover_path ?? null]);
        $media_id = db_last_insert_id();
        $insert_func($media_id, $data);
        $cover_path = upload_cover_image();
        if ($cover_path) {
            $query = "UPDATE medias SET cover_path = ? WHERE id = ?";
            db_execute($query, [$cover_path, $media_id]);
        }
        db_commit();
        set_flash('success', 'Média ajouté avec succès');
        return true;
    } catch (Exception $e) {
        if ($e instanceof PDOException) {
            $msg = "Insert Error. Media Type: $type | Media title: $title | Type: PDOException | Message: " . $e->getMessage();
        } else {
            $msg = $e->getMessage();
        }
        set_flash('error', $msg);
        error_logging(ErrorType::Error, $msg);
        db_rollback();
    }
    return false;
}

function get_current_page(): int
{
    $current_page = $_GET['page'] ?? 1;
    if (!filter_var($current_page, FILTER_VALIDATE_INT)) {
        throw new Exception('Numéro de page invalide');
    }
    $current_page = (int) $current_page;
    if ($current_page <= 0) {
        throw new Exception('Numéro de page invalide');
    }
    return $current_page;
}

function get_filter_conditions_and_params(array $filters): array
{
    $conditions = [];
    $params = [];

    foreach ($filters as $filter => $value) {
        if ($filter === 'title') {
            $params[] = "%$value%";
            $conditions[] = "$filter LIKE ?";
        } else if ($filter === 'available') {
            $conditions[] = 'stock > 0';
        } else {
            $params[] = $value;
            $conditions[] = "$filter = ?";
        }
    }

    return [$conditions, $params];
}

function get_medias(array $filters = []): array
{
    [$conditions, $params] = get_filter_conditions_and_params($filters);
    $current_page = get_current_page();
    $per_page = 12;
    $count = get_media_count($conditions, $params);
    $nb_pages = ceil($count / $per_page);
    $nb_pages = $nb_pages === 0.0 ? 1 : $nb_pages;

    if ($current_page > $nb_pages) {
        throw new Exception('Numéro de page invalide');
    }
    $offset = ($current_page - 1) * $per_page;
    $sql = "SELECT * FROM medias";
    if ($conditions) {
        $sql .= " WHERE " . implode(" AND ", $conditions);
    }
    $sql .= " ORDER BY id DESC LIMIT $per_page OFFSET $offset;";
    $medias = db_select($sql, $params);
    return [
        "medias" => $medias,
        "pages" => $nb_pages,
        "current_page" => $current_page
    ];
}

function get_media_count(array $conditions, array $params): int
{
    $sql = 'SELECT COUNT(id) FROM medias';
    if ($conditions) {
        $sql .= " WHERE " . implode(" AND ", $conditions);
    }
    $stmt = db_connect()->prepare($sql);
    $stmt->execute($params);
    return $stmt->fetch(PDO::FETCH_NUM)[0];
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

function get_media_cover_path(?string $path): string
{
    if ($path === null || !file_exists(ROOT_PATH . "/$path")) {
        return BASE_URL . '/assets/images/no-cover.png';
    }
    return UPLOAD_URL . "/$path";
}

function get_genre_values(): array
{
    $sql = "SHOW COLUMNS FROM medias WHERE field = 'genre'";
    $type = db_select_one($sql)['Type'];
    preg_match_all("/'([^']*)'/", $type, $matches);
    return $matches[1];
}
