<?php
// Contrôleur pour la page d'accueil

/**
 * Page d'accueil
 */
function home_index()
{
    $data = [
        'title' => 'Accueil',
        'stylesheets' => [
            'assets/css/home.css',
            'assets/css/search_bar.css',
            'assets/css/pagination.css'
        ]
    ];
    try {
        $filter_list = ["title", "type", "genre", "available"];
        $filters = [];
        foreach ($filter_list as $filter) {
            if (isset($_GET[$filter])) {
                $clean_input = clean_input($_GET[$filter]);
                if (!empty($clean_input)) {
                    $filters[$filter] = $clean_input;
                }
            }
        }
        $medias = get_medias($filters);
        $data = array_merge($data, $medias);
        load_view_with_layout('home/index', $data);
    } catch (Exception $e) {
        set_flash('error', $e->getMessage());
        redirect();
    }
}

/**
 * Page à propos
 */
function home_about()
{
    $data = [
        'title' => 'À propos',
        'content' => 'Cette application est un starter kit PHP MVC développé avec une approche procédurale.'
    ];

    load_view_with_layout('home/about', $data);
}

/**
 * Page contact
 */
function home_contact()
{
    $data = [
        'title' => 'Contact'
    ];

    if (is_post()) {
        $name = clean_input(post('name'));
        $email = clean_input(post('email'));
        $message = clean_input(post('message'));

        // Validation simple
        if (empty($name) || empty($email) || empty($message)) {
            set_flash('error', 'Tous les champs sont obligatoires.');
        } elseif (!validate_email($email)) {
            set_flash('error', 'Adresse email invalide.');
        } else {
            // Ici vous pourriez envoyer l'email ou sauvegarder en base
            set_flash('success', 'Votre message a été envoyé avec succès !');
            redirect('home/contact');
        }
    }

    load_view_with_layout('home/contact', $data);
}


/**
 * Page profile
 */
function home_profile()
{
    $data = [
        'title' => 'Profile',
        'message' => 'Bienvenue sur votre profil',
        'content' => 'Cette application est un starter kit PHP MVC développé avec une approche procédurale.'
    ];

    load_view_with_layout('home/profile', $data);
}
