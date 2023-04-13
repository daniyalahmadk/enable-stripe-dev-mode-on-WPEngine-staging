<?php
/**
 * 
 *  Save Settings
 * 
 * */
class ENSTRDWPE_WPEngineStaging {
	private $wpengine_staging_options;

	public function __construct() {
		add_action( 'admin_menu', array( $this, 'wpengine_staging_add_plugin_page' ) );
		add_action( 'admin_init', array( $this, 'wpengine_staging_page_init' ) );
	}

	public function wpengine_staging_add_plugin_page() {
		add_management_page(
			'WPEngine Stripe Dev Mode', // page_title
			'WPEngine Stripe Dev Mode', // menu_title
			'manage_options', // capability
			'wpengine-staging', // menu_slug
			array( $this, 'wpengine_staging_create_admin_page' ) // function
		);
	}

	public function wpengine_staging_create_admin_page() {
		$this->wpengine_staging_options = get_option( 'wpengine_staging_option_name' ); ?>

		<div class="wrap">
			<h2>WPEngine Stripe Dev Mode</h2>
			<p></p>
			<?php settings_errors(); ?>

			<form method="post" action="options.php">
				<?php
					settings_fields( 'wpengine_staging_option_group' );
					do_settings_sections( 'wpengine-staging-admin' );
					submit_button();
				?>
			</form>
		</div>
	<?php }

	public function wpengine_staging_page_init() {
		register_setting(
			'wpengine_staging_option_group', // option_group
			'wpengine_staging_option_name', // option_name
			array( $this, 'wpengine_staging_sanitize' ) // sanitize_callback
		);

		add_settings_section(
			'wpengine_staging_setting_section', // id
			'Settings', // title
			array( $this, 'wpengine_staging_section_info' ), // callback
			'wpengine-staging-admin' // page
		);

		add_settings_field(
			'staging_development_environment_name_0', // id
			'Staging/Development Environment Name', // title
			array( $this, 'staging_development_environment_name_0_callback' ), // callback
			'wpengine-staging-admin', // page
			'wpengine_staging_setting_section' // section
		);
	}

	public function wpengine_staging_sanitize($input) {
		$sanitary_values = array();
		if ( isset( $input['staging_development_environment_name_0'] ) ) {
			$sanitary_values['staging_development_environment_name_0'] = sanitize_text_field( $input['staging_development_environment_name_0'] );
		}

		return $sanitary_values;
	}

	public function wpengine_staging_section_info() {
		
	}

	public function staging_development_environment_name_0_callback() {
		printf(
			'<input class="regular-text" type="text" name="wpengine_staging_option_name[staging_development_environment_name_0]" id="staging_development_environment_name_0" value="%s">',
			isset( $this->wpengine_staging_options['staging_development_environment_name_0'] ) ? esc_attr( $this->wpengine_staging_options['staging_development_environment_name_0']) : ''
		);
	}

}
if ( is_admin() )
	$wpengine_staging = new ENSTRDWPE_WPEngineStaging();