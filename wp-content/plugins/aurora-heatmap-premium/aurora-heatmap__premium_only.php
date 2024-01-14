<?php // phpcs:ignore WordPress.Files.FileName.NotHypenedLowercase
/**
 * Aurora Heatmap Freemius SDK Integration
 *
 * @package aurora-heatmap
 * @copyright 2019-2022 R3098 <info@seous.info>
 * @version 1.5.6
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'aurora_heatmap_fs' ) ) {
	/**
	 * Create a helper function for easy SDK access.
	 */
	function aurora_heatmap_fs() {
		global $aurora_heatmap_fs;

		if ( ! isset( $aurora_heatmap_fs ) ) {
			// Include Freemius SDK.
			require_once __DIR__ . '/premium/freemius/start.php';

			$aurora_heatmap_fs = fs_dynamic_init(
				array(
					'id'                  => '4533',
					'slug'                => 'aurora-heatmap',
					'type'                => 'plugin',
					'public_key'          => 'pk_5f10aeda0c7e7deb9b4217a4f732c',
					'is_premium'          => true,
					'premium_suffix'      => 'Premium',
					// If your plugin is a serviceware, set this option to false.
					'has_premium_version' => true,
					'has_addons'          => false,
					'has_paid_plans'      => true,
					'menu'                => array(
						'slug'    => 'aurora-heatmap-premium',
						'contact' => true,
						'support' => false,
						'parent'  => array(
							'slug' => 'options-general.php',
						),
					),
				)
			);

			// Translators: JSON Object format to freemius override_i18n.
			// Translators: See https://github.com/Freemius/wordpress-sdk/blob/master/includes/i18n.php
			// Translators: Example for '{"hey-x": "Hello %s,"}'.
			$override = _x( '{}', 'freemius-override-i18n', 'aurora-heatmap' );
			// Json decode to PHP assoc array.
			$override = json_decode( $override, true );

			if ( $override ) {
				$aurora_heatmap_fs->override_i18n( $override );
			}
		}

		return $aurora_heatmap_fs;
	}

	// Init Freemius.
	aurora_heatmap_fs();
	// Signal that SDK was initiated.
	do_action( 'aurora_heatmap_fs_loaded' );
}

global $aurora_heatmap_fs;

if ( $aurora_heatmap_fs->is_on() ) {
	$aurora_heatmap_fs->add_action( 'after_uninstall', 'aurora_heatmap_uninstall' );
} else {
	register_uninstall_hook( AURORA_HEATMAP, 'aurora_heatmap_uninstall' );
}

require_once __DIR__ . '/premium/class-aurora-heatmap-free.php';

if ( $aurora_heatmap_fs->is_plan_or_trial( 'standard' ) ) {
	// Standard plan.
	require_once __DIR__ . '/premium/class-ts51-histogram.php';
	require_once __DIR__ . '/premium/class-aurora-heatmap-standard.php';

	register_activation_hook( AURORA_HEATMAP, 'Aurora_Heatmap_Standard::activation' );
	register_deactivation_hook( AURORA_HEATMAP, 'Aurora_Heatmap_Standard::deactivation' );
	add_action(
		'init',
		function() {
			Aurora_Heatmap_Standard::get_instance();
		}
	);
} else {
	// Free plan.
	register_activation_hook( AURORA_HEATMAP, 'Aurora_Heatmap_Free::activation' );
	register_deactivation_hook( AURORA_HEATMAP, 'Aurora_Heatmap_Free::deactivation' );
	add_action(
		'init',
		function() {
			Aurora_Heatmap_Free::get_instance();
		}
	);
}

/* vim: set ts=4 sw=4 sts=4 noet: */
