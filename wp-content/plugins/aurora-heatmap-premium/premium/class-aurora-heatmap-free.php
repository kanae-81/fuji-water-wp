<?php
/**
 * Aurora Heatmap Free Class
 *
 * Main class for Free Plan of the Premium Version.
 *
 * @package aurora-heatmap
 * @copyright 2019-2022 R3098 <info@seous.info>
 * @version 1.5.6
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Aurora_Heatmap_Free
 *
 * Free plan on premium version.
 */
class Aurora_Heatmap_Free extends Aurora_Heatmap_Basic {

	const PLAN = 'free';

	const SLUG = 'aurora-heatmap-premium';

	/**
	 * Freemius object
	 *
	 * @var object
	 */
	protected $freemius;

	/**
	 * Singleton object
	 *
	 * @var object
	 */
	private static $self;

	/**
	 * Get instance
	 */
	public static function get_instance() {
		if ( ! self::$self ) {
			self::$self = new self();
		}

		return self::$self;
	}

	/**
	 * Constructor
	 */
	protected function __construct() {
		$this->freemius = aurora_heatmap_fs();
		parent::__construct();
		if ( ! $this->freemius->is_paying_or_trial() ) {
			add_action(
				'admin_init',
				function() {
					if ( filter_input( INPUT_GET, 'aurora-heatmap-delete-account' ) && $this->can_settings() ) {
						// Avoid to display Freemius Notice errors.
						error_reporting( E_ALL ^ E_NOTICE ^ E_USER_NOTICE ); // phpcs:ignore WordPress
						$this->freemius->delete_account_event();
						fs_redirect( $this->freemius->get_activation_url() );
						exit;
					}
				}
			);
		}
	}

	/**
	 * Print plugin notices
	 */
	protected function print_plugin_notices() {
		echo '<div class="notice notice-info"><p>';
		echo _x( 'Due to unlicensed or expired licenses, the premium version features, including <b>premium version plugin updates</b>, are limited.', 'Free Plan', 'aurora-heatmap' ); // phpcs:ignore WordPress.Security.EscapeOutput
		echo '</p><p>';
		// translators: %1$s: URL of Upgrade in this plugin.
		// translators: %2$s: URL of Aurora Heatmap Plugin on the WordPress.org.
		// translators: %3$s: URL of Help in this plugin.
		printf( _x( 'To use the latest version, we recommend the <a href="%1$s">lisense agreement</a> or the <a href="%2$s">free version</a>. See the <a href="%3$s">help</a> for details.', 'Free Plan', 'aurora-heatmap' ), esc_attr( 'options-general.php?page=aurora-heatmap-premium-pricing' ), esc_attr( 'plugin-install.php?s=aurora-heatmap&tab=search&type=term' ), esc_attr( 'options-general.php?page=aurora-heatmap-premium&tab=help' ) ); // phpcs:ignore WordPress.Security.EscapeOutput
		echo '</p></div>';
	}

	/**
	 * Print additional help
	 */
	protected function print_additional_help() {
		$t = function( $text, $domain = 'default' ) {
			return esc_html__( $text, $domain ); // phpcs:ignore WordPress.WP.I18n
		};

		echo '<h3>';
		echo esc_html_x( 'About the free plan', 'Free Plan', 'aurora-heatmap' );
		echo '</h3><p>';
		echo esc_html_x( 'The license has expired, but the free plan can still be used.', 'Free Plan', 'aurora-heatmap' );
		echo '</p><p>';
		echo esc_html_x( 'However, it is not possible to update to the latest version of the premium version, so we recommend that you replace the WordPress.org plugin directory with the free version.', 'Free Plan', 'aurora-heatmap' );
		echo '</p><p>';
		echo esc_html_x( 'It is also possible to take over the current data.', 'Free Plan', 'aurora-heatmap' );
		echo '</p><h3>';
		echo esc_html_x( 'Migrate data to the free version', 'Free Plan', 'aurora-heatmap' );
		echo '</h3><ol><li>';
		echo _x( '<b>Stop</b> the premium version plugin.', 'Free Plan', 'aurora-heatmap' ); // phpcs:ignore WordPress.Security.EscapeOutput
		echo '</li><li>';
		echo _x( '<b>Install</b> / <b>activate</b> <a href="plugin-install.php?s=aurora-heatmap&amp;tab=search&amp;type=term">the free version</a> plugin.', 'Free Plan', 'aurora-heatmap' ); // phpcs:ignore WordPress.Security.EscapeOutput
		echo '</li><li>';
		echo _x( '<b>Delete</b> the premium version plugin.', 'Free Plan', 'aurora-heatmap' ); // phpcs:ignore WordPress.Security.EscapeOutput
		echo '</li></ol>';

		if ( ! $this->freemius->is_paying_or_trial() ) {
			echo '<h3>';
			echo esc_html_x( 'If you can\'t receive authentication email', 'Free Plan', 'aurora-heatmap' );
			echo '</h3><p>';
			// translators: %s: Your Profile.
			printf( _x( 'Change the email address of <a href="profile.php">%s</a> and restart the user registration with the following button.', 'Free Plan', 'aurora-heatmap' ), $t( 'Your Profile' ) ); // phpcs:ignore WordPress.Security.EscapeOutput
			echo '</p><div><a href="options-general.php?page=aurora-heatmap-premium&amp;aurora-heatmap-delete-account=1" class="button button-primary">';
			echo esc_html_x( 'Restart the user registration', 'Free Plan', 'aurora-heatmap' );
			echo '</a></div>';
		}
	}

	/**
	 * Get admin tabs
	 *
	 * @return array
	 */
	protected function get_admin_tabs() {
		$admin_tabs = parent::get_admin_tabs();

		$admin_tabs['help']['name'] = __( 'Help', 'aurora-heatmap' );

		return $admin_tabs;
	}

	/**
	 * Default option values
	 *
	 * @return array
	 */
	protected function get_default_options() {
		return array(
			'activated_ver'             => null,
			'period'                    => 1,
			'accuracy'                  => 2,
			'report_non_singular'       => 1,
			'drawing_points'            => 3000,
			'count_bar'                 => 1,
			'keep_url_query'            => 0,
			'keep_url_hash'             => 0,
			'ajax_delay_time'           => 3000,
			'weekly_email_content_type' => 'html',
		);
	}

	/**
	 * Force option values
	 *
	 * @return array
	 */
	protected function get_force_options() {
		return array(
			'url_query_include'    => array(),  // Keep simplicity.
			'url_query_exclude'    => array(),  // Keep simplicity.
			'content_end_marker'   => 0,        // For advanced features.
			'unread_threshold'     => 25,       // For advanced features.
			'unread_minimum'       => 2,        // For advanced features.
			'unread_warning'       => 60,       // For advanced features.
			'weekly_email_sending' => 0,        // For advanced features.
		);
	}

	/**
	 * Delete old events and not used pages.
	 *
	 * @param int $months months of retention period.
	 */
	protected function delete_old_data( $months = 1 ) {
		global $wpdb;

		// In the case of 1 month, keep breakaway data for 2 months.
		if ( 1 === $months ) {
			// phpcs:ignore WordPress.DB.DirectDatabaseQuery
			$wpdb->query( "DELETE FROM {$wpdb->prefix}ahm_events WHERE insert_at < SUBDATE( NOW(), INTERVAL IF ( event IN (32, 33), 2, 1 ) MONTH )" );
		} else {
			// phpcs:ignore WordPress.DB.DirectDatabaseQuery
			$wpdb->query( $wpdb->prepare( "DELETE FROM {$wpdb->prefix}ahm_events WHERE insert_at < ADDDATE( NOW(), INTERVAL - %d MONTH )", $months ) );
		}
		$this->cleanup_pages();
	}
}

/* vim: set ts=4 sw=4 sts=4 noet: */

