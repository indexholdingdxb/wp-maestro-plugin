<?php
/* Plugin Name: Maestro 
Plugin URI: https://indexholding.ae/ 
Description: Using API fetch all speakers information 
Version: 1.0 
Author: Kamran Khalid 
Author URI: https://indexholding.ae/
License: GPLv2 or later */

define('MAESTRO__PLUGIN_DIR', plugin_dir_path(__FILE__));

register_activation_hook(__FILE__, array('Maestro', 'plugin_activation'));
register_deactivation_hook(__FILE__, array('Maestro', 'plugin_deactivation'));


function maestro_enqueue_styles()
{

	//wp_register_style( 'bootstrap-style', plugins_url('css/bootstrap.min.css', __FILE__ ));
	//wp_enqueue_style( 'bootstrap-style');

	//wp_register_style( 'modal-style', '//cdn.rawgit.com/noelboss/featherlight/1.7.13/release/featherlight.min.css');
	//wp_enqueue_style( 'modal-style');

	//wp_register_style( 'plugin-style', plugins_url('css/style.css', __FILE__ ));
	//wp_enqueue_style( 'plugin-style');


}
add_action('wp_enqueue_scripts', 'maestro_enqueue_styles');

function installer()
{
	include('installer.php');
}
register_activation_hook(__file__, 'installer');

add_action('admin_menu', 'maestro_api_menu');
function maestro_api_menu()
{
	$page_title = 'Maestro Api Settings';
	$menu_title = 'Maestro Settings';
	$capability = 'manage_options';
	$menu_slug  = 'maestro-api-setting';
	$function   = 'create_maestro_api_setting';
	$icon_url   = 'dashicons-media-code';
	$position   = 4;
	add_menu_page($page_title, $menu_title, $capability, $menu_slug, $function, $icon_url, $position);
	add_submenu_page($menu_slug, 'Add Session Roles', 'Add Session Roles', 'manage_options', 'add-maestro-seesion-rolse', 'create_maestro_session_roles');
}

/** --------Setting up plugin Featues------------ */
require_once(MAESTRO__PLUGIN_DIR . 'db.class.php');
require_once(MAESTRO__PLUGIN_DIR . 'components/AgendaComponent.php');
require_once(MAESTRO__PLUGIN_DIR . 'components/SpeakerComponent.php');
require_once(MAESTRO__PLUGIN_DIR . 'components/ExhibitorProductsComponent.php');
require_once(MAESTRO__PLUGIN_DIR . 'components/AbstractComponent.php');
require_once(MAESTRO__PLUGIN_DIR . 'components/ExhibitorComponent.php');

// Defining ShortCodes
add_shortcode('speakers', 'getAllSpeakers');
add_shortcode('abstracts', 'getAllAbstracts');
add_shortcode('agenda', 'getAllSessions');
add_shortcode('exhibitors', 'getAllExhibitors');
add_shortcode('products', 'getAllProducts');

// Adding librarites for view
function maestro_enqueue_scripts()
{
	//wp_register_script( 'bootstrap-script', plugins_url('js/bootstrap.min.js', __FILE__ ), array('jquery') );
	//wp_enqueue_script ( 'bootstrap-script' );

	//wp_register_script( 'modal-script', '//cdn.rawgit.com/noelboss/featherlight/1.7.13/release/featherlight.min.js', array('jquery') );
	//wp_enqueue_script ( 'modal-script' );

	wp_register_script('paginga-script', plugins_url('js/paginga.jquery.js', __FILE__), array('jquery'));
	wp_enqueue_script('paginga-script');

	wp_register_script('maestro-script', plugins_url('js/script.js', __FILE__), array('jquery'));
	wp_enqueue_script('maestro-script');
}
add_action('wp_enqueue_scripts', 'maestro_enqueue_scripts');

// Display speakers info
function getAllSpeakers($atts)
{

	$db = new maestroDB();
	$speaker = new SpeakerComponent();

	$data = $db->showSpeakers($atts);
	$HTML = $speaker->index($data);

	return ($HTML);
}

// Display exhibitor products
function getAllProducts($atts)
{
	$db = new maestroDB();
	$exhibitor_products = new ExhibitorProductsComponent();

	$data = $db->showExhibitorProducts($atts);
	$HTML = $exhibitor_products->index($data);

	return ($HTML);
}

// Display abstracts info
function getAllAbstracts($atts)
{
	$db = new maestroDB();
	$abstract_view = new AbstractComponent();
	$HTML = '';
	$data = $db->showAbstracts($atts);
	$HTML = $abstract_view->index($data);

	return ($HTML);
}

// Display sessions data
function getAllSessions($atts)
{
	$db = new maestroDB();
	$speakerRoleseData = $db->fetchRoles();
	$agenda = new AgendaComponent($speakerRoleseData[0], $speakerRoleseData[1]);

	$data = $db->getSessions($atts);
	$HTML = $agenda->index($data, $atts);

	return ($HTML);
}

// Display exhibitors data
function getAllExhibitors($atts)
{
	$db = new maestroDB();
	$exhibitors = new ExhibitorComponent();

	$data = $db->getExhibitors($atts);
	$HTML = $exhibitors->index($data, $atts);

	return ($HTML);
}

// Creating web form for setting
function create_maestro_api_setting()
{
	$db = new maestroDB();
	if (isset($_POST['create_maestro_api'])) {
		$db->insertDB($_POST);
	}

	require_once(MAESTRO__PLUGIN_DIR . 'views/form.php');
}

// Create speaker rolese order
function create_maestro_session_roles()
{
	$db = new maestroDB();
	if (isset($_POST['create_speaker_role'])) {
		$db->insertSpakerRolesDB($_POST);
	}

	if (isset($_GET['action'])) {
		$action = $_GET['action'];
	}

	if ($action == 'delete') {
		$id = $_GET['id'];
		$db->deleteRec($id);
	}

	$gridData = $db->showRecords();

	$data = $db->getSessions();
	$rolese = $data['roles'];

	require_once(MAESTRO__PLUGIN_DIR . 'views/speaker-roles-form.php');
}
