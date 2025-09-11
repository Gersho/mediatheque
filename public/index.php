<?php

/**
 * Point d'entrée principal de l'application PHP MVC
 * 
 * Ce fichier initialise l'application et lance le système de routing
 */

// Démarrer la session
session_start();

// Charger la configuration
require_once '../config/database.php';

// Charger les fichiers core
require_once CORE_PATH . '/database.php';
require_once CORE_PATH . '/router.php';
require_once CORE_PATH . '/view.php';

// Charger les fichiers utilitaires
require_once INCLUDE_PATH . '/helpers.php';

// Charger les modèles
require_once MODEL_PATH . '/user_model.php';
require_once MODEL_PATH . '/media_model.php';
require_once MODEL_PATH . '/book_model.php';
require_once MODEL_PATH . '/game_model.php';
require_once MODEL_PATH . '/movie_model.php';
require_once MODEL_PATH . '/borrow_model.php';


// Activer l'affichage des erreurs en développement
// À désactiver en production
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check session activity, logout if inactive more than SESSION_TIMEOUT
if (is_logged_in() && isset($_SESSION['LAST_ACTIVITY']) && time() - $_SESSION['LAST_ACTIVITY'] > SESSION_TIMEOUT) {
    logout();
}
$_SESSION['LAST_ACTIVITY'] = time();

// Lancer le système de routing
dispatch();
