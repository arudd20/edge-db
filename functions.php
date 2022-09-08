<?php

/**
 * Timber starter-theme
 * https://github.com/timber/starter-theme
 *
 * @package  WordPress
 * @subpackage  Timber
 * @since   Timber 0.1
 */

/**
 * If you are installing Timber as a Composer dependency in your theme, you'll need this block
 * to load your dependencies and initialize Timber. If you are using Timber via the WordPress.org
 * plug-in, you can safely delete this block.
 */
$composer_autoload = __DIR__ . '/vendor/autoload.php';
if (file_exists($composer_autoload)) {
	require_once $composer_autoload;
	$timber = new Timber\Timber();
}

$BG_IMG_ID = 7;

Routes::map('pilots/', function ($params) {
	//make a custom query based on incoming path and run it...
	// $query = 'posts_per_page=3&post_type='.$params['name'].'&paged='.intval($params['pg']);

	//load up a template which will use that query
	Routes::load('page-pilots.twig', null, $query);
});

Routes::map('pilots/pilot/:pilot', function ($params) {
	//make a custom query based on incoming path and run it...

	//load up a template which will use that query
	Routes::load('page-pilot.php', $params, $query);
});

Routes::map('bonds/', function ($params) {
	//make a custom query based on incoming path and run it...
	// $query = 'posts_per_page=3&post_type='.$params['name'].'&paged='.intval($params['pg']);

	//load up a template which will use that query
	Routes::load('page-bonds.twig', null, $query);
});

Routes::map('bonds/bond/:bond', function ($params) {
	//make a custom query based on incoming path and run it...

	//load up a template which will use that query
	Routes::load('page-bond.php', $params, $query);
});

Routes::map('loans/', function ($params) {
	//make a custom query based on incoming path and run it...
	// $query = 'posts_per_page=3&post_type='.$params['name'].'&paged='.intval($params['pg']);

	//load up a template which will use that query
	Routes::load('page-loans.twig', null, $query);
});

Routes::map('loans/loan/:loan', function ($params) {
	//make a custom query based on incoming path and run it...

	//load up a template which will use that query
	Routes::load('page-loan.php', $params, $query);
});

Routes::map('others/', function ($params) {
	//make a custom query based on incoming path and run it...
	// $query = 'posts_per_page=3&post_type='.$params['name'].'&paged='.intval($params['pg']);

	//load up a template which will use that query
	Routes::load('page-others.twig', null, $query);
});

Routes::map('others/other/:other', function ($params) {
	//make a custom query based on incoming path and run it...

	//load up a template which will use that query
	Routes::load('page-other.php', $params, $query);
});

Routes::map('tifs/', function ($params) {
	//make a custom query based on incoming path and run it...
	// $query = 'posts_per_page=3&post_type='.$params['name'].'&paged='.intval($params['pg']);

	//load up a template which will use that query
	Routes::load('page-tifs.twig', null, $query);
});

Routes::map('tifs/tif/:tif', function ($params) {
	//make a custom query based on incoming path and run it...

	//load up a template which will use that query
	Routes::load('page-tif.php', $params, $query);
});

/**
 * This ensures that Timber is loaded and available as a PHP class.
 * If not, it gives an error message to help direct developers on where to activate
 */
if (!class_exists('Timber')) {

	add_action(
		'admin_notices',
		function () {
			echo '<div class="error"><p>Timber not activated. Make sure you activate the plugin in <a href="' . esc_url(admin_url('plugins.php#timber')) . '">' . esc_url(admin_url('plugins.php')) . '</a></p></div>';
		}
	);

	// add_action(
	// 	'init',
	// 	function() {
	// 		add_rewrite_rule(
	// 			'pilots/([a-zA-Z0-9-]+)[/]?$',
	// 			'index.php?name=$matches[1]',
	// 			'top'
	// 		);
	// 	}
	// );

	// add_filter(
	// 	'query_vars',
	// 	function( $query_vars ) {
	// 		$query_vars[] = 'pilots';
	// 		return $query_vars;
	// 	}
	// );

	// add_action( 'template_include', function( $template ) {
	// 	if ( get_query_var( 'pilots' ) == false || get_query_var( 'pilots' ) == '' ) {
	// 		return $template;
	// 	}

	// 	return get_template_directory() . '/templates/page-pilots.twig';
	// } );

	add_filter(
		'template_include',
		function ($template) {
			return get_stylesheet_directory() . '/static/no-timber.html';
		}
	);
	return;
}

/**
 * Sets the directories (inside your theme) to find .twig files
 */
Timber::$dirname = array('templates', 'views');

/**
 * By default, Timber does NOT autoescape values. Want to enable Twig's autoescape?
 * No prob! Just set this value to true
 */
Timber::$autoescape = false;


/**
 * We're going to configure our theme inside of a subclass of Timber\Site
 * You can move this to its own file and include here via php's include("MySite.php")
 */
class StarterSite extends Timber\Site
{
	/** Add timber support. */
	public function __construct()
	{
		add_action('after_setup_theme', array($this, 'theme_supports'));
		add_filter('timber/context', array($this, 'add_to_context'));
		add_filter('timber/twig', array($this, 'add_to_twig'));
		add_action('init', array($this, 'register_post_types'));
		add_action('init', array($this, 'register_taxonomies'));
		parent::__construct();
	}

	public function register_menus()
	{
		register_nav_menus(
			array(
				'primary' => 'Primary Menu',
				'footer' => 'Footer Menu'
			)
		);
	}

	/** This is where you can register custom post types. */
	public function register_post_types()
	{
	}
	/** This is where you can register custom taxonomies. */
	public function register_taxonomies()
	{
	}

	/** This is where you add some context
	 *
	 * @param string $context context['this'] Being the Twig's {{ this }}.
	 */




	public function add_to_context($context)
	{
		// get data from custom DB tables
		global $wpdb;
		$context['edge_bonds'] =  json_encode(
			$wpdb->get_results(
				$wpdb->prepare(
					"SELECT * FROM edge_bonds"
				)
			)
		);

		$context['edge_loan_program'] =  json_encode(
			$wpdb->get_results(
				$wpdb->prepare(
					"SELECT * FROM edge_loan_program"
				)
			)
		);

		$context['edge_others'] =  json_encode(
			$wpdb->get_results(
				$wpdb->prepare(
					"SELECT * FROM edge_others"
				)
			)
		);

		$context['edge_pilot_program'] =  json_encode(
			$wpdb->get_results(
				$wpdb->prepare(
					"SELECT * FROM edge_pilot_program"
				)
			)
		);

		$context['edge_tifs'] =  json_encode(
			$wpdb->get_results(
				$wpdb->prepare(
					"SELECT * FROM edge_tifs"
				)
			)
		);

		$wpdb->flush();

		$context['foo']   = 'bar';
		$context['stuff'] = 'I am a value set in your functions.php file';
		$context['notes'] = 'These values are available everytime you call Timber::context();';
		$context['menuPrimary']  = new Timber\Menu('primary');
		$context['menuTopNav']  = new Timber\Menu('top-nav');
		$context['menuFooter']  = new Timber\Menu('footer');
		$context['site']  = $this;

		$context['custom_logo_url'] = wp_get_attachment_image_url(get_theme_mod('custom_logo'), 'full');
		$context['heading_bg_url'] = wp_get_attachment_image_url(7, 'full');

		$context['bridge_ftr_bg_url'] = wp_get_attachment_image_url(6, 'full');
		$context['repeat_ftr_bg_url'] = wp_get_attachment_image_url(5, 'full');

		$context['edge_logo_white'] = wp_get_attachment_image_url(13, 'full');
		$context['gmac_logo'] = wp_get_attachment_image_url(11, 'full');
		$context['ipom_logo'] = wp_get_attachment_image_url(12, 'full');

		$context['params'] = json_encode(TimberURLHelper::get_params());

		return $context;
	}

	public function theme_supports()
	{
		// Add default posts and comments RSS feed links to head.
		add_theme_support('automatic-feed-links');

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support('title-tag');

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support('post-thumbnails');

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support(
			'html5',
			array(
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
			)
		);

		/*
		 * Enable support for Post Formats.
		 *
		 * See: https://codex.wordpress.org/Post_Formats
		 */
		add_theme_support(
			'post-formats',
			array(
				'aside',
				'image',
				'video',
				'quote',
				'link',
				'gallery',
				'audio',
			)
		);

		add_theme_support('menus');

		$defaults = array(
			'unlink-homepage-logo' => true,
		);

		add_theme_support('custom-logo', $defaults);
	}

	/** This Would return 'foo bar!'.
	 *
	 * @param string $text being 'foo', then returned 'foo bar!'.
	 */
	public function myfoo($text)
	{
		$text .= ' bar!';
		return $text;
	}

	/** This is where you can add your own functions to twig.
	 *
	 * @param string $twig get extension.
	 */
	public function add_to_twig($twig)
	{
		$twig->addExtension(new Twig\Extension\StringLoaderExtension());
		$twig->addFilter(new Twig\TwigFilter('myfoo', array($this, 'myfoo')));
		return $twig;
	}
}

new StarterSite();
