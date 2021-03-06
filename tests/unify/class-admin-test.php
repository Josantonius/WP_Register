<?php
/**
 * Register, minify and unify CSS and JavaScript resources.
 *
 * @author    Josantonius <hello@josantonius.com>
 * @package   Josantonius\WP_Register
 * @copyright 2017 - 2018 (c) Josantonius - WP_Register
 * @license   https://opensource.org/licenses/MIT - The MIT License (MIT)
 * @link      https://github.com/Josantonius/WP_Register
 * @since     1.0.4
 */

namespace Josantonius\WP_Register\Test\Unify;

use Josantonius\WP_Register\WP_Register;

/**
 * Tests class for WP_Register library.
 */
final class Admin_Test extends \WP_UnitTestCase {

	/**
	 * WP_Register instance.
	 *
	 * @since 1.0.5
	 *
	 * @var object
	 */
	protected $wp_register;

	/**
	 * Theme url.
	 *
	 * @var string
	 */
	protected $theme_url;

	/**
	 * Set up.
	 */
	public function setUp() {

		$this->wp_register = new WP_Register();

		$this->theme_url  = get_theme_root_uri() . '/tests/';
		$this->theme_path = get_theme_root() . '/tests/';

		set_current_screen( 'admin.php' );
	}

	/**
	 * Check if it is an instance of WP_Register.
	 *
	 * @since 1.0.5
	 */
	public function test_is_instance_of() {

		$this->assertInstanceOf(
			'Josantonius\WP_Register\WP_Register',
			$this->wp_register
		);
	}

	/**
	 * Unify files specifying the same url path for styles and scripts.
	 */
	public function test_unify() {

		$wp_register = $this->wp_register;

		$this->assertTrue(
			$wp_register::unify( 'UniqueID', $this->theme_url . 'min/admin/' )
		);
	}

	/**
	 * Unify files specifying different url paths for styles and scripts.
	 */
	public function test_unify_specifying_different_url_paths() {

		$wp_register = $this->wp_register;

		$this->assertTrue(
			$wp_register::unify(
				'UniqueID', [
					'styles'  => $this->theme_url . 'min/admin/css/',
					'scripts' => $this->theme_url . 'min/admin/js/',
				]
			)
		);
	}

	/**
	 * Unify files specifying the same url path for styles and scripts.
	 */
	public function test_unify_and_minify() {

		$wp_register = $this->wp_register;

		$this->assertTrue(
			$wp_register::unify( 'UniqueID', $this->theme_url . 'min/admin/', true )
		);
	}

	/**
	 * Unify files specifying different url paths for styles and scripts.
	 */
	public function test_unify_and_minify_specifying_different_url_paths() {

		$wp_register = $this->wp_register;

		$this->assertTrue(
			$wp_register::unify(
				'UniqueID', [
					'styles'  => $this->theme_url . 'min/admin/css/',
					'scripts' => $this->theme_url . 'min/admin/js/',

				], true
			)
		);
	}

	/**
	 * Add front-end styles and scripts.
	 */
	public function test_add_frontend_styles_and_scripts() {

		$wp_register = $this->wp_register;

		$this->assertTrue(
			$wp_register::add(
				'style', [
					'name'    => 'EditorStyleAdmin',
					'url'     => $this->theme_url . 'css/editor-style.css',
					'place'   => 'admin',
					'deps'    => [],
					'version' => '1.1.3',
					'media'   => 'all',
				]
			)
		);

		$this->assertTrue(
			$wp_register::add(
				'style', [
					'name'    => 'DefaultStyleAdmin',
					'url'     => $this->theme_url . 'css/style.css',
					'place'   => 'admin',
					'deps'    => [],
					'version' => '1.1.3',
					'media'   => 'all',
				]
			)
		);

		$this->assertTrue(
			$wp_register::add(
				'script', [
					'name'    => 'HTML_scriptAdmin',
					'url'     => $this->theme_url . 'js/html5.js',
					'place'   => 'admin',
					'deps'    => [ 'jquery' ],
					'version' => '1.1.3',
					'footer'  => true,
					'params'  => [ 'date' => date( 'now' ) ],
				]
			)
		);

		$this->assertTrue(
			$wp_register::add(
				'script', [
					'name'    => 'NavigationScriptAdmin',
					'url'     => $this->theme_url . 'js/navigation.js',
					'place'   => 'admin',
					'deps'    => [ 'jquery-effects-core' ],
					'version' => '1.1.3',
					'footer'  => true,
					'params'  => [ 'date' => date( 'now' ) ],
				]
			)
		);
	}

	/**
	 * Check if the admin styles and scripts have been added correctly.
	 */
	public function test_if_frontend_styles_and_scripts_added_correctly() {

		$wp_register = $this->wp_register;

		$this->assertTrue(
			$wp_register::is_added( 'style', 'EditorStyleAdmin' )
		);

		$this->assertTrue(
			$wp_register::is_added( 'style', 'DefaultStyleAdmin' )
		);

		$this->assertTrue(
			$wp_register::is_added( 'script', 'HTML_scriptAdmin' )
		);

		$this->assertTrue(
			$wp_register::is_added( 'script', 'NavigationScriptAdmin' )
		);
	}

	/**
	 * If admin style is registered.
	 */
	public function test_if_frontend_styles_and_scripts_was_registered() {

		do_action( 'admin_enqueue_scripts' );

		$this->assertTrue(
			wp_style_is( 'UniqueID', 'registered' )
		);

		$this->assertTrue(
			wp_script_is( 'UniqueID', 'registered' )
		);

		$this->assertTrue(
			wp_script_is( 'jquery', 'registered' )
		);

		$this->assertTrue(
			wp_script_is( 'jquery-effects-core', 'registered' )
		);
	}

	/**
	 * Validate whether unified files have been created.
	 */
	public function test_if_unified_files_was_created() {

		$style_one = 'editor-style.css';
		$style_two = 'style.css';

		$css = sha1( $style_one . $style_two ) . '.css';

		$this->assertTrue(
			file_exists( $this->theme_path . 'min/admin/css/' . $css )
		);

		$file = $this->theme_path . 'min/admin/css/' . $css;

		$content = "body, h1, h2, h3, h4, h5, h6 {font-family: 'Open Sans', sans-serif;}body {font-size: 1.6em;line-height: 1.6;}body, h1, h2, h3, h4, h5, h6 {font-family: 'Open Sans', sans-serif;}body {font-size: 1.6em;line-height: 1.6;}";

		$this->assertTrue(
			file_get_contents( $file ) == $content
		);

		$script_one = 'html5.js';
		$script_two = 'navigation.js';

		$js = sha1( $script_one . $script_two ) . '.js';

		$this->assertTrue(
			file_exists( $this->theme_path . 'min/admin/js/' . $js )
		);

		$file = $this->theme_path . 'min/admin/js/' . $js;

		$content = "function myFunction() {document.getElementById('myCheck').click();}$('p').click(function(){alert('The paragraph was clicked.');});";

		$this->assertTrue(
			file_get_contents( $file ) == $content
		);
	}

	/**
	 * If admin style is enqueued.
	 */
	public function test_if_frontend_styles_and_scripts_are_enqueued() {

		$this->assertTrue(
			wp_style_is( 'UniqueID', 'enqueued' )
		);

		$this->assertTrue(
			wp_script_is( 'UniqueID', 'enqueued' )
		);

		$this->assertTrue(
			wp_script_is( 'jquery', 'enqueued' )
		);

		$this->assertTrue(
			wp_script_is( 'jquery-effects-core', 'enqueued' )
		);
	}

	/**
	 * If admin style is queue.
	 */
	public function test_if_frontend_styles_and_scripts_are_queue() {

		$this->assertTrue(
			wp_style_is( 'UniqueID', 'queue' )
		);

		$this->assertTrue(
			wp_script_is( 'UniqueID', 'queue' )
		);

		$this->assertTrue(
			wp_script_is( 'jquery', 'queue' )
		);

		$this->assertTrue(
			wp_script_is( 'jquery-effects-core', 'queue' )
		);
	}

	/**
	 * If admin style has been printed.
	 */
	public function test_if_frontend_styles_and_script_are_done() {

		do_action( 'wp_print_footer_scripts' );

		$this->assertTrue(
			wp_style_is( 'UniqueID', 'done' )
		);

		$this->assertTrue(
			wp_script_is( 'UniqueID', 'done' )
		);

		$this->assertTrue(
			wp_script_is( 'jquery', 'done' )
		);

		$this->assertTrue(
			wp_script_is( 'jquery-effects-core', 'done' )
		);
	}

	/**
	 * Delete added front-end styles.
	 */
	public function test_remove_added_front_end_styles_and_scripts() {

		$wp_register = $this->wp_register;

		$wp_register::unify( 'UniqueID', false );

		$this->assertTrue(
			$wp_register::remove( 'style', 'UniqueID' )
		);

		wp_deregister_style( 'UniqueID' );

		wp_dequeue_style( 'UniqueID' );

		$this->assertTrue(
			$wp_register::remove( 'script', 'UniqueID' )
		);

		wp_deregister_script( 'UniqueID' );

		wp_dequeue_script( 'UniqueID' );
	}

	/**
	 * Validation after deletion.
	 */
	public function test_validation_after_deletion() {

		$wp_register = $this->wp_register;

		$this->assertFalse(
			wp_style_is( 'UniqueID', 'queue' )
		);

		$this->assertFalse(
			wp_style_is( 'UniqueID', 'enqueued' )
		);

		$this->assertFalse(
			wp_style_is( 'UniqueID', 'registered' )
		);

		$this->assertFalse(
			$wp_register::is_added( 'style', 'UniqueID' )
		);

		$this->assertFalse(
			wp_script_is( 'UniqueID', 'queue' )
		);

		$this->assertFalse(
			wp_script_is( 'UniqueID', 'enqueued' )
		);

		$this->assertFalse(
			wp_script_is( 'UniqueID', 'registered' )
		);

		$this->assertFalse(
			$wp_register::is_added( 'script', 'UniqueID' )
		);
	}
}
