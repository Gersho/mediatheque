<?php
// Fonctions utilitaires

/**
 * Sécurise l'affichage d'une chaîne de caractères (protection XSS)
 */
function escape($string)
{
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}

/**
 * Affiche une chaîne sécurisée (échappée)
 */
function e($string)
{
    echo escape($string);
}

/**
 * Retourne une chaîne sécurisée sans l'afficher
 */
function esc($string)
{
    return escape($string);
}

/**
 * Génère une URL absolue
 */
function url($path = '')
{
    $base_url = rtrim(BASE_URL, '/');
    $path = ltrim($path, '/');
    return $base_url . '/' . $path;
}

/**
 * Redirection HTTP
 */
function redirect($path = '')
{
    $url = url($path);
    header("Location: $url");
    exit;
}

/**
 * Génère un token CSRF
 */
function csrf_token()
{
    if (!isset($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

/**
 * Vérifie un token CSRF
 */
function verify_csrf_token($token)
{
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}

/**
 * Définit un message flash
 */
function set_flash($type, $message)
{
    $_SESSION['flash_messages'][$type][] = $message;
}

/**
 * Récupère et supprime les messages flash
 */
function get_flash_messages($type = null)
{
    if (!isset($_SESSION['flash_messages'])) {
        return [];
    }

    if ($type) {
        $messages = $_SESSION['flash_messages'][$type] ?? [];
        unset($_SESSION['flash_messages'][$type]);
        return $messages;
    }

    $messages = $_SESSION['flash_messages'];
    unset($_SESSION['flash_messages']);
    return $messages;
}

/**
 * Vérifie s'il y a des messages flash
 */
function has_flash_messages($type = null)
{
    if (!isset($_SESSION['flash_messages'])) {
        return false;
    }

    if ($type) {
        return !empty($_SESSION['flash_messages'][$type]);
    }

    return !empty($_SESSION['flash_messages']);
}

/**
 * Nettoie une chaîne de caractères
 */
function clean_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

/**
 * Valide une adresse email
 */
function validate_email($email)
{
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

/**
 * Génère un mot de passe sécurisé
 */
function generate_password($length = 12)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!@#$%^&*()';
    $password = '';
    for ($i = 0; $i < $length; $i++) {
        $password .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $password;
}

/**
 * Hache un mot de passe
 */
function hash_password($password)
{
    return password_hash($password, PASSWORD_DEFAULT);
}

/**
 * Vérifie un mot de passe
 */
function verify_password($password, $hash)
{
    return password_verify($password, $hash);
}

/**
 * Formate une date
 */
function format_date($date, $format = 'd/m/Y H:i')
{
    return date($format, strtotime($date));
}

/**
 * Vérifie si une requête est en POST
 */
function is_post()
{
    return $_SERVER['REQUEST_METHOD'] === 'POST';
}

/**
 * Vérifie si une requête est en GET
 */
function is_get()
{
    return $_SERVER['REQUEST_METHOD'] === 'GET';
}

/**
 * Retourne la valeur d'un paramètre POST
 */
function post($key, $default = null)
{
    return $_POST[$key] ?? $default;
}

/**
 * Retourne la valeur d'un paramètre GET
 */
function get($key, $default = null)
{
    return $_GET[$key] ?? $default;
}

/**
 * Vérifie si un utilisateur est connecté
 */
function is_logged_in()
{
    return isset($_SESSION['user_id']);
}

/**
 * Retourne l'ID de l'utilisateur connecté
 */
function current_user_id()
{
    return $_SESSION['user_id'] ?? null;
}

/**
 * Déconnecte l'utilisateur
 */
function logout()
{
    session_destroy();
    redirect('auth/login');
}

/**
 * Formate un nombre
 */
function format_number($number, $decimals = 2)
{
    return number_format($number, $decimals, ',', ' ');
}

/**
 * Génère un slug à partir d'une chaîne
 */
function generate_slug($string)
{
    $string = strtolower($string);
    $string = preg_replace('/[^a-z0-9\s-]/', '', $string);
    $string = preg_replace('/[\s-]+/', '-', $string);
    return trim($string, '-');
}



/**
 *  custom functions starting from here
 */

enum ErrorType: string
{
    case Warning = "Warning";
    case Error = "Error";
    case Info = "Info";
    case Debug = "Debug";
}

function error_logging(ErrorType $type, string $message)
{
    $log_file = LOG_PATH . '/app.log';
    if (!file_exists("$log_file")) {
        if (!is_dir(LOG_PATH)) {
            mkdir(LOG_PATH, 0644, true);
        }
        touch($log_file);
    }
    $date = date('Y-m-d H:i:s');
    error_log("[$date] [$type->value] $message\n", 3, $log_file);
}

function validate_upload($file): array
{
    $errorMessages = [
        UPLOAD_ERR_INI_SIZE => "Le fichier téléchargé dépasse la directive upload_max_filesize dans php.ini",
        UPLOAD_ERR_FORM_SIZE => "Le fichier téléchargé dépasse la directive MAX_FILE_SIZE spécifiée dans le formulaire HTML",
        UPLOAD_ERR_PARTIAL => "Le fichier n'a été que partiellement téléchargé",
        UPLOAD_ERR_NO_TMP_DIR => "Dossier temporaire manquant",
        UPLOAD_ERR_CANT_WRITE => "Échec de l'écriture du fichier sur le disque",
        UPLOAD_ERR_EXTENSION => "Une extension PHP a interrompu le téléchargement du fichier",
    ];
    if ($file["error"] !== UPLOAD_ERR_OK) {
        throw new Exception($errorMessages[$file["error"]]);
    }
    if (!is_uploaded_file($file['tmp_name'])) {
        throw new Exception("Le fichier upload ne vient pas d'une requête POST");
    }
    if ($file["size"] > UPLOAD_MAX_SIZE) {
        throw new Exception("Le fichier est trop volumineux. Taille max: " . UPLOAD_MAX_SIZE / 1000000 . 'mo.');
    }

    $file_info = getimagesize($_FILES["cover"]["tmp_name"]);
    if ($file_info === false) {
        throw new Exception("Le fichier upload n'est pas une image");
    }

    $file_extension = explode("/", $file["type"])[1];
    $file_mime_type = explode("/", $file_info["mime"])[1];
    $allowed_types = ["jpeg", "jpg", "png", "gif"];

    if (!in_array($file_extension, $allowed_types) || !in_array($file_mime_type, $allowed_types)) {
        throw new Exception("Type de fichier non valide (formats acceptés : jpg, png, gif).");
    }
    $file_info["ext"] = $file_mime_type;
    return $file_info;
}

function create_image_from_file(string $path, string $mime_type): GdImage
{
    $image = match ($mime_type) {
        'image/jpeg', 'image/jpg' => imagecreatefromjpeg($path),
        'image/png' => imagecreatefrompng($path),
        'image/gif' => imagecreatefromgif($path),
        default => false,
    };
    if (!$image) {
        throw new Exception("Echec de la création de l'image");
    }
    return $image;
}

function save_image(GdImage $image, string $destination, string $mime_type)
{
    $success = match ($mime_type) {
        'image/jpeg', 'image/jpg' => imagejpeg($image, $destination),
        'image/png' => imagepng($image, $destination),
        'image/gif' => imagegif($image, $destination),
        default => false,
    };
    if (!$success) {
        throw new Exception("Echec de la sauvegarde de l'image");
    }
}

function resize_image(array $file, array $file_info): GdImage
{
    $new_width = 300;
    $new_height = 400;
    $dest = imagecreatetruecolor($new_width, $new_height);
    $source = create_image_from_file($file['tmp_name'], $file_info['mime']);
    if (!imagecopyresampled($dest, $source, 0, 0, 0, 0, $new_width, $new_height, $file_info[0], $file_info[1])) {
        throw new Exception("Echec du resize de l'image");
    }
    imagedestroy($source);
    return $dest;
}

function upload_cover_image(): string|null
{
    if (!isset($_FILES["cover"]) || $_FILES["cover"]["error"] === UPLOAD_ERR_NO_FILE) {
        return null;
    }
    $file = $_FILES["cover"];
    $file_info = validate_upload($file);
    $image = resize_image($file, $file_info);
    $filename = uniqid() . '.' . $file_info['ext'];
    $file_path = "uploads/covers/$filename";
    $destination = UPLOAD_PATH . '/' . $filename;
    save_image($image, $destination, $file_info['mime']);
    imagedestroy($image);
    return $file_path;
}

function get_page_url(int $page): string
{
    $uri = explode('?', $_SERVER['REQUEST_URI'])[0];
    $get = $_GET;
    if (isset($get['page']) && $page == 1) {
        unset($get['page']);
    } else {
        $get['page'] = $page;
    }
    $query = http_build_query($get);
    if (!empty($query)) {
        $uri .= "?$query";
    }
    return $uri;
}

function dd(mixed $value)
{
    echo "<pre><code>";
    print_r($value);
    echo "</code></pre>";
    die();
}

function upload_cover_from_url(string $url): ?string
{
    if (empty($url)) {
        return null;
    }

    // Download image content
    $image_content = @file_get_contents($url);
    if ($image_content === false) {
        throw new Exception("Impossible de télécharger l'image depuis l'URL: $url");
    }

    // Create temporary file
    $tmp_file = tempnam(sys_get_temp_dir(), 'cover_');
    file_put_contents($tmp_file, $image_content);

    // Validate image type
    $file_info = getimagesize($tmp_file);
    if ($file_info === false) {
        unlink($tmp_file);
        throw new Exception("Le fichier téléchargé n'est pas une image valide");
    }

    $file_mime_type = $file_info["mime"];
    $allowed_types = ["image/jpeg", "image/png", "image/gif"];
    if (!in_array($file_mime_type, $allowed_types)) {
        unlink($tmp_file);
        throw new Exception("Type de fichier non valide (formats acceptés : jpg, png, gif).");
    }

    // Resize image
    $image = resize_image(
        ["tmp_name" => $tmp_file], // mimic $_FILES
        $file_info
    );

    // Generate unique filename
    $ext = match ($file_mime_type) {
        "image/jpeg" => "jpg",
        "image/png" => "png",
        "image/gif" => "gif",
    };
    $filename = uniqid() . '.' . $ext;
    $file_path = "uploads/covers/$filename";
    $destination = UPLOAD_PATH . '/' . $filename;

    // Save image
    save_image($image, $destination, $file_mime_type);

    // Clean up
    imagedestroy($image);
    unlink($tmp_file);

    return $file_path;
}

