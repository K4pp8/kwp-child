<?php

// Importo il css del tema padre
function enqueue_parent_theme_style() {
    wp_enqueue_style( 'parent-style', get_template_directory_uri().'/style.css' );
}
add_action( 'wp_enqueue_scripts', 'enqueue_parent_theme_style' );

//Aggiungo la favicon
function favicon_link() {
    echo '<link rel="shortcut icon" type="image/x-icon" href="/favicon.ico" />' . "\n";
}
add_action( 'wp_head', 'favicon_link' );

//Email client
add_filter('wp_mail_from', 'new_mail_from');
add_filter('wp_mail_from_name', 'new_mail_from_name');
  
function new_mail_from($old) {
   return 'info@ilsitodeltuocliente.com'; // cambia la mail del mittente
}
function new_mail_from_name($old) {
   return 'Il Tuo Cliente'; // cambia il nome visualizzato del mittente
}

//Disabilitare la barra dell'aministrazione per gli utenti loggati
add_filter('show_admin_bar', '__return_false');

// limita a 5 le revisioni
define('WP_POST_REVISIONS', 10); 

// Nascondi aggiornamenti per gli utenti Non-Admin
if ( !current_user_can( 'edit_users' ) ) {
add_filter('pre_site_transient_update_core', create_function('$a', "return null;")); // rimuove notifiche sugli aggiornamenti del core di WordPress
add_filter('pre_site_transient_update_plugins', create_function( '$a', "return null;")); // rimuove notifiche sugli aggiornamenti dei plugins
}

//Disabilita li aggiornamenti automatici
define( 'WP_AUTO_UPDATE_CORE', false );

// Disabilitare i feed rss
function fb_disable_rss_feed() {
    wp_die( __('Feed Rss is not available please return back to the <a href="'. get_bloginfo('url') .'">homepage</a>!') );
}
add_action('do_feed', 'fb_disable_rss_feed', 1);
add_action('do_feed_rdf', 'fb_disable_rss_feed', 1);
add_action('do_feed_rss', 'fb_disable_rss_feed', 1);
add_action('do_feed_rss2', 'fb_disable_rss_feed', 1);
add_action('do_feed_atom', 'fb_disable_rss_feed', 1);

//Customizzazione aministrazione
//scritta footer admin
add_filter( 'admin_footer_text', 'my_admin_footer_text' );
function my_admin_footer_text( $default_text ) {
     return '<span>Creato da <a href="http://www.yourinspirationweb.com/">YIW</a> | CMS basato su <a href="http://www.wordpress.org">WordPress</a></span>';
}
//mini logo in admin
function customized_mini_logo() {
    echo '<style type="text/css">
#header-logo { background-image:url(http://www.sitodelcliente.it/immagini/mini-logo.jpg) !important;
}
    </style>';
}
add_action('admin_head', 'customized_mini_logo');

//Customizzare il login ( se non si vuole usare plugin come login customizer )
/* logo login */
function customized_login_logo() {
    echo '<style type="text/css">
h1 a { 
background-image:url(http://www.sitodelcliente.it/immagini/logo.jpg) !important; 
        height:95px !important; 
        background-size:auto !important; }
body { background-color: #fff !important}
    </style>';
}
add_action('login_head', 'customized_login_logo');

/* cambia il titolo */
add_filter("login_headertitle","customized_login_title");
function customized_login_title($message){
    return "Titolo del Sito del Cliente"; // o alternativamente return get_option('blogname')
}
/* link al sito del cliente */
add_filter("login_headerurl","customized_login_url");
function customized_login_url($url){
return get_bloginfo('url'); 
}







