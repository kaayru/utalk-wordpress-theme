<?php
/**
 * UTalk functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package UTalk
 */

if ( ! function_exists( 'utalk_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function utalk_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on UTalk, use a find and replace
	 * to change 'utalk' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'utalk', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 1860, 900 );
	add_image_size( 'post-image', 1860, 900 );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => esc_html__( 'Primary', 'utalk' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	add_theme_support( 'post-formats', array(
		'video',
		'link',
		'quote',
		'gallery',
		'image',
		'audio'
	) );
}
endif;
add_action( 'after_setup_theme', 'utalk_setup' );

if ( ! function_exists( 'utalk_content_width' ) ) :
/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function utalk_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'utalk_content_width', 640 );
}
endif;

add_action( 'after_setup_theme', 'utalk_content_width', 0 );

if ( ! function_exists( 'utalk_widgets_init' ) ) :
/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function utalk_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'utalk' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'utalk' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Footer 1', 'utalk' ),
		'id'            => 'footer-1',
		'description'   => esc_html__( 'Add widgets here.', 'utalk' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Footer 2', 'utalk' ),
		'id'            => 'footer-2',
		'description'   => esc_html__( 'Add widgets here.', 'utalk' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Footer 3', 'utalk' ),
		'id'            => 'footer-3',
		'description'   => esc_html__( 'Add widgets here.', 'utalk' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
endif;
add_action( 'widgets_init', 'utalk_widgets_init' );

if ( ! function_exists( 'utalk_scripts' ) ) :
/**
 * Enqueue scripts and styles.
 */
function utalk_scripts() {
	global $version;

	wp_enqueue_style( 'utalk-color-theme', get_template_directory_uri() . '/css/color-themes/theme' . get_theme_mod('utalk_color_scheme', 1) . '.css', [], $version );

	wp_enqueue_script( 'utalk-libraries', get_template_directory_uri() . '/js/libraries.min.js', array(), $version, true );

	wp_enqueue_script( 'utalk-scripts', get_template_directory_uri() . '/js/script.min.js', array(), $version, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
endif;
add_action( 'wp_enqueue_scripts', 'utalk_scripts' );

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';

/**
 * Load the version file
 */
 if(file_exists(get_template_directory() . '/version.php')) {
	 require get_template_directory() . '/version.php';
}
