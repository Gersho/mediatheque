<?php

function insert_new_media(array $data, callable $insert_func)
{
    db_begin_transaction();
    extract($data);
    try {
        $query = "INSERT INTO medias (title, genre, type, stock, cover_img) VALUES (?,?,?,?,?)";
        db_execute($query, [$title, $genre, $type, $stock, $cover_img ?? null]);
        $media_id = db_last_insert_id();
        $insert_func($media_id, $data);
        $cover_img = upload_cover_image();
        if ($cover_img) {
            $query = "UPDATE medias SET cover_img = ? WHERE id = ?";
            db_execute($query, [$cover_img, $media_id]);
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

function update_media(array $data, callable $update_func)
{
    db_begin_transaction();

    try {
        // Récupérer les champs obligatoires avec fallback
        $id = $data['id'] ?? null;
        $title = $data['title'] ?? '';
        $type = $data['type'] ?? '';
        $genre = $data['genre'] ?? '';
        $stock = $data['stock'] ?? 1;

        // Gestion image : si pas de nouvel upload, garder l’ancien
        $cover_img = upload_cover_image();
        if (!$cover_img && isset($data['cover_img'])) {
            $cover_img = $data['cover_img'];
        }

        // Mise à jour de la table "medias"
        $query = "UPDATE medias SET 
            title = ?,
            genre = ?,
            cover_img = ?,
            stock = ?
            WHERE id = ?";

        db_execute($query, [$title, $genre, $cover_img, $stock, $id]);
        db_execute($query, [$title, $genre, $cover_img, $stock, $id]);
        // Vérification callback
        if (is_callable($update_func)) {
            $update_func($id, $data);
        }

        db_commit();
        set_flash('success', 'Média modifié avec succès');
        return true;
    } catch (Exception $e) {
        db_rollback();
        if ($e instanceof PDOException) {
            $msg = "Insert Error. Media Type: $type | Media title: $title | Type: PDOException | Message: " . $e->getMessage();
        } else {
            $msg = $e->getMessage();
        }
        set_flash('error', $msg);
        error_logging(ErrorType::Error, $msg);

        return false;
    }
}
/**
 * Return the current page number from $_GET['page'] or default 1
 * @throws Exception If the $_GET['page'] value is not a positive Int
 * @return int
 */
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

/**
 * Build SQL WHERE conditions for medias table and parameter bindings from filter values.
 *
 * Special cases:
 *   - 'title': Uses a LIKE condition with wildcards (%value%).
 *   - 'available': Adds a stock check ("stock > 0") without parameters.
 *   - Others: Uses "=" comparison with bound parameter.
 *
 * Example:
 *   list($conditions, $params) = build_conditions_and_params([
 *       'title' => 'marvel',
 *       'category' => 'Fiction',
 *       'available' => true
 *   ]);
 *
 * Result:
 *   $conditions = ['title LIKE ?', 'category = ?', 'stock > 0']
 *   $params     = ['%marvel%', 'Fiction']
 *
 * @param array $filters Associative array of filters
 * @return array [array $conditions, array $params]
 */
function build_conditions_and_params(array $filters): array
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

/**
 * Retrieve paginated medias from the database with optional filters.
 *
 * This function builds SQL conditions from the given filters,
 * calculates pagination details (current page, total pages),
 * and returns the matching medias for the current page.
 *
 * Pagination:
 *   - Uses MAX_MEDIA_PER_PAGE as the number of items per page.
 *   - Throws an Exception if the requested page number is invalid.
 *
 * Filtering:
 *   - Filters are converted into SQL conditions via build_conditions_and_params().
 *   - Supports special cases (e.g., title LIKE, available → stock > 0).
 *
 * @param array $filters Associative array of filters
 * @return array [$medias: array, $pages: int, $current_page: int]
 * 
 */
function get_medias(array $filters = []): array
{
    // Build WHERE conditions and bound params from filters
    [$conditions, $params] = build_conditions_and_params($filters);

    // Determine pagination values
    $current_page = get_current_page();
    $per_page = MAX_MEDIA_PER_PAGE;
    $count = get_media_count($conditions, $params);
    $nb_pages = ceil($count / $per_page);

    // Always have at least one page (even if no results)
    $nb_pages = $nb_pages === 0.0 ? 1 : $nb_pages;

    // Prevent accessing a page number that doesn't exist
    if ($current_page > $nb_pages) {
        throw new Exception('Numéro de page invalide');
    }

    // Calculate offset for SQL LIMIT
    $offset = ($current_page - 1) * $per_page;

    // Build final query with filters and pagination
    $sql = "SELECT * FROM medias";
    if ($conditions) {
        $sql .= " WHERE " . implode(" AND ", $conditions);
    }
    $sql .= " ORDER BY id DESC LIMIT $per_page OFFSET $offset;";

    // Execute query
    $medias = db_select($sql, $params);

    // Return medias with pagination metadata
    return [
        "medias" => $medias,
        "pages" => $nb_pages,
        "current_page" => $current_page
    ];
}


/**
 * Get the total number of rows in the `medias` table.
 *
 * Optionally, you can pass SQL WHERE conditions and bound parameters 
 * to filter the query results.
 *
 * Example:
 *   get_media_count(['genre = ?', 'type = ?'], ['Action', 'Movie']);
 *
 * @param array $conditions Array of SQL conditions (without "WHERE"), combined with AND.
 * @param array $params     Array of parameters used in $conditions.
 *
 * @return int The number of matching rows.
 */
function get_media_count(array $conditions = [], array $params = []): int
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

/**
 * Check if the cover exist and return the URL to the image
 * or the default URL image
 * @param ?string $path 
 * @return string image URL
 */
function get_media_cover_img(?string $path): string
{
    if ($path === null || !file_exists(UPLOAD_PATH . "/$path")) {
        return BASE_URL . '/assets/images/no-cover.png';
    }
    return UPLOAD_URL . "/$path";
}

/**
 * Make a database query to get the enum values from medias table
 * @return array
 */
function get_genre_values(): array
{
    $sql = "SHOW COLUMNS FROM medias WHERE field = 'genre'";
    $type = db_select_one($sql)['Type'];
    preg_match_all("/'([^']*)'/", $type, $matches);
    return $matches[1];
}
