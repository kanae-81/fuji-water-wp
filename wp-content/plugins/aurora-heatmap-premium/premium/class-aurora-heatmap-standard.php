<?php
/**
 * Aurora Heatmap Standard Class
 *
 * Main class for Standard Plan of the Premium Version.
 *
 * @package aurora-heatmap
 * @copyright 2019-2022 R3098 <info@seous.info>
 * @version 1.5.6
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Aurora_Heatmap_Standard
 *
 * Standard plan on premium version.
 */
class Aurora_Heatmap_Standard extends Aurora_Heatmap_Free {

	const PLAN = 'standard';

	const CLICK_PC         = 0x10;
	const CLICK_MOBILE     = 0x11;
	const BREAKAWAY_PC     = 0x20;
	const BREAKAWAY_MOBILE = 0x21;
	const ATTENTION_PC     = 0x30;
	const ATTENTION_MOBILE = 0x31;

	const EVENT_NAMES = array(
		'click_pc'         => self::CLICK_PC,
		'click_mobile'     => self::CLICK_MOBILE,
		'breakaway_pc'     => self::BREAKAWAY_PC,
		'breakaway_mobile' => self::BREAKAWAY_MOBILE,
		'attention_pc'     => self::ATTENTION_PC,
		'attention_mobile' => self::ATTENTION_MOBILE,
	);

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
		parent::__construct();

		add_filter( 'ahm_scripts', array( &$this, 'ahm_scripts_filter' ) );
		add_shortcode( 'ahm_scripts', array( &$this, 'ahm_scripts_shortcode' ) );
		if ( $this->options['content_end_marker'] ) {
			add_filter( 'the_content', array( &$this, 'content_end_marker' ) );
		}
	}

	/**
	 * Setup Aurora Heatmap
	 */
	public function setup() {
		parent::setup();

		global $wpdb;
		require_once ABSPATH . 'wp-admin/includes/upgrade.php';
		$charset_collate = $wpdb->get_charset_collate();

		dbDelta(
			"CREATE TABLE {$wpdb->prefix}ahm_norm (
			i            int(8) UNSIGNED NOT NULL,
			v            double          NOT NULL,
			d1           double          NOT NULL,
			d2           double          NOT NULL,
			d3           double          NOT NULL,
			d4           double          NOT NULL,
			PRIMARY KEY  (i)
			) {$charset_collate}"
		);

		dbDelta(
			"CREATE TABLE {$wpdb->prefix}ahm_unread (
			id           int(8)     UNSIGNED NOT NULL,
			event        tinyint(3) UNSIGNED NOT NULL,
			rank         int(8)     UNSIGNED NOT NULL,
			PRIMARY KEY  (id, event)
			) {$charset_collate}"
		);

		$v = array(
			3.67096619931286E-051,
			3.47843284602974E-050,
			3.22298575774487E-049,
			2.92015252810108E-048,
			2.58717592540239E-047,
			2.24140623269366E-046,
			1.89884852122924E-045,
			1.57302697148055E-044,
			1.27426314550685E-043,
			1.00939282671681E-042,
			7.81880730565805E-042,
			5.92244602045211E-041,
			4.38675271307426E-040,
			3.1773701446895E-039,
			2.25048589341508E-038,
			1.5587262888812E-037,
			1.05572255808867E-036,
			6.99225823301256E-036,
			4.52870695615878E-035,
			2.86827981883687E-034,
			1.7764821120777E-033,
			1.07595404604104E-032,
			6.37267491568614E-032,
			3.69102185890373E-031,
			2.09059542173855E-030,
			1.15796031856865E-029,
			6.27219439321715E-029,
			3.32238081981657E-028,
			1.72101783947984E-027,
			8.71825291966597E-027,
			4.31900631780926E-026,
			2.09242903757845E-025,
			9.91362512256013E-025,
			4.5933710556131E-024,
			2.08137521949325E-023,
			9.22341352493945E-023,
			3.99722120572628E-022,
			1.69415350248815E-021,
			7.02228424044164E-021,
			2.84667740846024E-020,
			1.12858840595384E-019,
			4.37596479930902E-019,
			1.65942086996477E-018,
			6.15442559085044E-018,
			2.23239319728806E-017,
			7.91972631464256E-017,
			2.74795939239821E-016,
			9.32557577168129E-016,
			3.0953587719587E-015,
			0.0000000000000100489656565263,
			0.0000000000000319089167291092,
			0.0000000000000991034274954759,
			0.000000000000301062798111747,
			0.000000000000894588955877,
			0.00000000000260012696563819,
			0.00000000000739225777801793,
			0.0000000000205578890939952,
			0.0000000000559250757594264,
			0.000000000148822822176231,
			0.000000000387414734667566,
			0.000000000986587645037701,
			0.00000000245786506180803,
			0.00000000599037140106353,
			0.0000000142834798939228,
			0.0000000333204484854288,
			0.0000000760496051648873,
			0.00000016982674071476,
			0.000000371067407963335,
			0.0000007933281519756,
			0.00000165967514437146,
			0.00000339767312473005,
			0.00000680687659933405,
			0.0000133457490159063,
			0.0000256088164740415,
			0.0000480963440176028,
			0.000088417285200804,
			0.000159108590157534,
			0.000280293276816178,
			0.000483424142383778,
			0.000816352312828564,
			0.0013498980316301,
			0.00218596145491325,
			0.00346697380304066,
			0.00538614595406668,
			0.00819753592459612,
			0.0122244726550447,
			0.0178644205628166,
			0.0255880595216386,
			0.0359303191129258,
			0.0494714680336481,
			0.0668072012688581,
			0.0885079914374021,
			0.115069670221708,
			0.146859056375896,
			0.184060125346759,
			0.226627352376868,
			0.274253117750073,
			0.32635522028792,
			0.382088577811047,
			0.440382307629757,
			0.5,
			0.559617692370242,
			0.617911422188953,
			0.67364477971208,
			0.725746882249927,
			0.773372647623132,
			0.815939874653241,
			0.853140943624104,
			0.884930329778292,
			0.911492008562598,
			0.933192798731142,
			0.950528531966352,
			0.964069680887074,
			0.974411940478361,
			0.982135579437183,
			0.987775527344955,
			0.991802464075404,
			0.994613854045933,
			0.996533026196959,
			0.997814038545087,
			0.99865010196837,
			0.999183647687171,
			0.999516575857616,
			0.999719706723184,
			0.999840891409842,
			0.999911582714799,
			0.999951903655982,
			0.999974391183526,
			0.999986654250984,
			0.999993193123401,
			0.999996602326875,
			0.999998340324856,
			0.999999206671848,
			0.999999628932592,
			0.999999830173259,
			0.999999923950395,
			0.999999966679551,
			0.99999998571652,
			0.999999994009629,
			0.999999997542135,
			0.999999999013412,
			0.999999999612585,
			0.999999999851177,
			0.999999999944075,
			0.999999999979442,
			0.999999999992608,
			0.9999999999974,
			0.999999999999105,
			0.999999999999699,
			0.999999999999901,
			0.999999999999968,
			0.99999999999999,
			0.999999999999997,
			0.999999999999999,
		);

		$v = $v + array_fill( 0, 201, 1 );
		$s = array();
		foreach ( $v as $i => $n ) {
			$s[] = sprintf(
				'( %d, %.13E, %.13E, %.13E, %.13E, %.13E )',
				$i,
				$n,
				$v[ min( 200, $i + 25 ) ] - $n,
				$v[ min( 200, $i + 50 ) ] - $n,
				$v[ min( 200, $i + 75 ) ] - $n,
				$v[ min( 200, $i + 100 ) ] - $n
			);
		}

		$s = implode( ',', $s );

		$wpdb->query( "INSERT INTO {$wpdb->prefix}ahm_norm ( i, v, d1, d2, d3, d4 ) values {$s} ON DUPLICATE KEY UPDATE i = VALUES(i), v = VALUES(v), d1 = VALUES(d1), d2 = VALUES(d2), d3 = VALUES(d3), d4 = values(d4)" ); // phpcs:ignore WordPress.DB

		$this->update_unread();

		if ( ! $this->options['last_weekly_process'] ) {
			$this->options['last_weekly_process'] = $this->get_current_yearweek();
		}
	}

	/**
	 * Shortcode [ahm_scripts]
	 *
	 * @param array $attr jquery=auto (default) ... always insert jquery.
	 *                    jquery=include|yes|true ... always insert jquery.
	 *                    jquery=exclude|no|false ... not insert jqeury.
	 * @return string
	 */
	public function ahm_scripts_shortcode( $attr = array() ) {
		return $this->ahm_scripts_filter( '', $attr );
	}

	/**
	 * Filter ahm_scripts
	 *
	 * @param string $content Content html with html head.
	 * @param array  $attr    Attributes.
	 *                        jquery=auto (default) ... insert if jquery not found.
	 *                        jquery=include|yes|true ... insert jquery.
	 *                        jquery=exclude|no|false ... not insert jquery.
	 * @return string
	 */
	public function ahm_scripts_filter( $content = '', $attr = array() ) {
		// Check attributes.
		$attr = shortcode_atts( array( 'jquery' => 'auto' ), $attr );
		if ( in_array( $attr['jquery'], array( 'include', 'yes', 'true' ), true ) ) {
			$attr['jquery'] = 'include';
		} elseif ( in_array( $attr['jquery'], array( 'exclude', 'no', 'false' ), true ) ) {
			$attr['jquery'] = 'include';
		} else {
			$attr['jquery'] = 'auto';
		}

		$head = '';
		$foot = '';

		if ( ! ( $content && preg_match( '/\shref\s*=\s*(["\'])aurora-heatmap-css\1/', $content ) ) ) {
			// phpcs:ignore WordPress.WP.EnqueuedResources.NonEnqueuedStylesheet
			$head .= '<link rel=\'stylesheet\' id=\'aurora-heatmap-css\' href=\'' . esc_attr( plugins_url( 'style.css', __DIR__ ) ) . '\' media=\'all\' />' . PHP_EOL;
		}

		if ( ! $content ) {
			$ins       =& $head;
			$is_jquery = 'exclude' === $atts['jquery'];
		} else {
			$is_jquery = preg_match( '/\ssrc\s*=\s*(["\'])(?:[^"]*\/)?jquery(?:[.-]\d+)*(?:\.min)?\.js\1/', $content, $mj, PREG_OFFSET_CAPTURE );
			$is_head   = preg_match( '/<\/head>\s*(?:<!--[\s\S]*-->\s*)*<body(?:\s|>)/', $content, $mh, PREG_OFFSET_CAPTURE );
			if ( ! $is_jquery ) {
				$ins =& $head;
			} elseif ( ! $is_head || $mh[0][1] < $mj[0][1] ) {
				$ins =& $foot;
			} else {
				$ins =& $head;
			}
		}

		if ( $this->user ) {
			$user = wp_get_current_user();
			wp_set_current_user( $this->user->ID );
		}

		$q  = $this->enqueue_report( true );
		$q .= $this->enqueue_view( true );

		if ( $this->user ) {
			wp_set_current_user( $user->ID );
		}

		if ( $q && ! $is_jquery ) {
			// phpcs:ignore WordPress.WP.EnqueuedResources.NonEnqueuedScript
			$ins .= '<script src=\'' . esc_attr( site_url( $GLOBALS['wp_scripts']->registered['jquery-core']->src ) ) . '\'></script>' . PHP_EOL;
		}

		$ins .= $q;

		// Shortcode or got no content.
		if ( ! $content ) {
			return rtrim( $head );
		}

		// Insert to head.
		if ( $is_head ) {
			$content = preg_replace( '/(<\/head>\s*(?:<!--[\s\S]*-->\s*)*<body(?:\s|>))/', $head . '$1', $content, 1 );
		} elseif ( false !== strpos( '</head>' ) ) {
			// Fallback 1. search </head>.
			$content = preg_replace( '/(<\/head>)/', $foot . '$1', $content, 1 );
		} else {
			// Fallback 2. move to footer.
			$foot = $head . $foot;
		}

		// Insert to footer.
		if ( preg_match( '/(<\/body>\s*(?:<!--[\s\S]*-->\s*)*<\/html(?:\s|>))/', $content ) ) {
			$content = preg_replace( '/(<\/body>\s*(?:<!--[\s\S]*-->\s*)*<\/html(?:\s|>))/', $foot . '$1', $content, 1 );
		} elseif ( false !== strpos( '</body>', $content ) ) {
			// Fallback 1. search </body>.
			$content = preg_replace( '/(<\/body>)/', $foot . '$1', $content, 1 );
		} else {
			// Fallback 2. append to content.
			$content .= $foot;
		}

		return $content;
	}

	/**
	 * Add content end marker
	 *
	 * Filter hook for the_content
	 *
	 * @param string $content Content.
	 * @return string
	 */
	public function content_end_marker( $content ) {
		$marker = '';
		if ( is_main_query() ) {
			$marker = PHP_EOL . '<div class="ahm-content-end-marker"></div>';
		}
		return $content . $marker;
	}

	/**
	 * Print plugin notices
	 */
	protected function print_plugin_notices() {
		// Do nothing.
	}

	/**
	 * Print additional help
	 */
	protected function print_additional_help() {
		// Do nothing.
	}

	/**
	 * Make URL filter
	 *
	 * @param bool $use_options Use filtering options or not.
	 * @return callable
	 */
	protected function make_url_filter( $use_options = false ) {
		global $wp;
		$query_filter    = null;
		$fragment_filter = null;
		if ( $use_options ) {
			if ( $this->options['keep_url_query'] ) {
				$exclude      = array_flip( array_diff( $this->options['url_query_exclude'], $wp->public_query_vars ) );
				$query_filter = function( $query ) use ( $exclude ) {
					return array_diff_key( $query, $exclude );
				};
			} else {
				$include      = array_flip( array_merge( $this->options['url_query_include'], $wp->public_query_vars ) );
				$query_filter = function( $query ) use ( $include ) {
					return array_intersect_key( $query, $include );
				};
			}
			if ( ! $this->options['keep_url_hash'] ) {
				$fragment_filter = function() {
					return '';
				};
			}
		}
		return function( $url ) use ( $query_filter, $fragment_filter ) {
			return $this->rebuild_url( $url, $query_filter, $fragment_filter );
		};
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
			'url_query_include'         => array(),
			'url_query_exclude'         => array(),
			'ajax_delay_time'           => 3000,
			'content_end_marker'        => 1,
			'unread_threshold'          => 25,
			'unread_minimum'            => 2,
			'unread_warning'            => 60,
			'weekly_email_sending'      => 1,
			'weekly_email_content_type' => 'html',
			'last_weekly_process'       => 0,
		);
	}

	/**
	 * Force option values
	 *
	 * @return array
	 */
	protected function get_force_options() {
		return array();
	}

	/**
	 * Option checker
	 *
	 * @param array $new_options New options.
	 * @param array $old         Old options, otherwise skip the trigger on change.
	 */
	public function option_checker( $new_options, $old = null ) {
		$default_options = $this->get_default_options();
		$force_options   = $this->get_force_options();

		// Merge.
		$options = array_merge( $default_options, $new_options, $force_options );

		// Validate.
		if ( $options['activated_ver'] ) {
			$options['activated_ver'] = (string) $options['activated_ver'];
		} elseif ( isset( $old['activated_ver'] ) ) {
			$options['activated_ver'] = $old['activated_ver'];
		}

		$options['period'] = min( 6, max( 1, intval( $options['period'] ) ) );

		$options['accuracy'] = min( 2, max( 1, intval( $options['accuracy'] ) ) );

		$options['report_non_singular'] = intval( (bool) $options['report_non_singular'] );

		$options['drawing_points'] = max( 0, intval( $options['drawing_points'] ) );

		$options['count_bar'] = intval( (bool) $options['count_bar'] );

		$options['keep_url_query'] = intval( (bool) $options['keep_url_query'] );

		$options['keep_url_hash'] = intval( (bool) $options['keep_url_hash'] );

		$options['ajax_delay_time'] = max( 0, intval( $options['ajax_delay_time'] ) );

		$options['url_query_include'] = (array) $options['url_query_include'];

		$options['url_query_exclude'] = (array) $options['url_query_exclude'];

		$options['content_end_marker'] = intval( (bool) $options['content_end_marker'] );

		$options['unread_threshold'] = min( 100, max( 0, intval( $options['unread_threshold'] ) ) );

		$options['unread_minimum'] = max( 0, intval( $options['unread_minimum'] ) );

		$options['unread_warning'] = min( 100, max( 0, intval( $options['unread_warning'] ) ) );

		$options['weekly_email_sending'] = intval( (bool) $options['weekly_email_sending'] );

		$options['weekly_email_content_type'] = (string) $options['weekly_email_content_type'];

		$options['last_weekly_process'] = (int) $options['last_weekly_process'];

		// Trigger on change.
		if ( $old ) {
			$backup_options = $this->options;
			$this->options  = $options;
			$old            = array_merge( $default_options, $old, $force_options );
			if (
				$options['keep_url_query'] !== $old['keep_url_query'] ||
				$options['keep_url_hash'] !== $old['keep_url_hash'] ||
				$options['url_query_include'] !== $old['url_query_include'] ||
				$options['url_query_exclude'] !== $old['url_query_exclude']
			) {
				$this->update_url2();
			}
			if ( $options['weekly_email_sending'] !== $old['weekly_email_sending'] ) {
				$backup_options['last_weekly_process'] = $this->get_current_yearweek();
			}
			$this->update_unread();
			$this->options = $backup_options;
		}

		// Checked options.
		return $options;
	}

	/**
	 * Save options
	 */
	protected function save_options() {
		$i                 = filter_input( INPUT_POST, 'url_query_include' );
		$url_query_include = ( null !== $i ) ? preg_split( '/[\\s,]+/', $i ) : null;
		$i                 = filter_input( INPUT_POST, 'url_query_exclude' );
		$url_query_exclude = ( null !== $i ) ? preg_split( '/[\\s,]+/', $i ) : null;

		$options = array(
			'period'                    => filter_input( INPUT_POST, 'period', FILTER_VALIDATE_INT ),
			'accuracy'                  => filter_input( INPUT_POST, 'accuracy', FILTER_VALIDATE_INT ),
			'report_non_singular'       => filter_input( INPUT_POST, 'report_non_singular', FILTER_VALIDATE_INT ),
			'drawing_points'            => filter_input( INPUT_POST, 'drawing_points', FILTER_VALIDATE_INT ),
			'count_bar'                 => filter_input( INPUT_POST, 'count_bar', FILTER_VALIDATE_INT ),
			'keep_url_query'            => filter_input( INPUT_POST, 'keep_url_query', FILTER_VALIDATE_BOOLEAN ),
			'keep_url_hash'             => filter_input( INPUT_POST, 'keep_url_hash', FILTER_VALIDATE_BOOLEAN ),
			'ajax_delay_time'           => filter_input( INPUT_POST, 'ajax_delay_time', FILTER_VALIDATE_INT ),
			'url_query_include'         => $url_query_include,
			'url_query_exclude'         => $url_query_exclude,
			'content_end_marker'        => filter_input( INPUT_POST, 'content_end_marker', FILTER_VALIDATE_INT ),
			'unread_threshold'          => filter_input( INPUT_POST, 'unread_threshold', FILTER_VALIDATE_INT ),
			'unread_minimum'            => filter_input( INPUT_POST, 'unread_minimum', FILTER_VALIDATE_INT ),
			'unread_warning'            => filter_input( INPUT_POST, 'unread_warning', FILTER_VALIDATE_INT ),
			'weekly_email_sending'      => filter_input( INPUT_POST, 'weekly_email_sending', FILTER_VALIDATE_BOOLEAN ),
			'weekly_email_content_type' => filter_input( INPUT_POST, 'weekly_email_content_type' ),
		);

		$this->options->save( $options );
	}

	/**
	 * Get admin tabs
	 *
	 * @return array
	 */
	protected function get_admin_tabs() {
		$admin_tabs = parent::get_admin_tabs();

		$admin_tabs['unread']['can_use'] = $this->can_view();

		return $admin_tabs;
	}

	/**
	 * Print tab content
	 *
	 * @param string $active_tab Active tab.
	 */
	protected function print_tab_content( $active_tab ) {
		if ( 'unread' === $active_tab && $this->can_view() ) {
			include_once __DIR__ . '/class-aurora-heatmap-unread-list.php';
			$table = new Aurora_Heatmap_Unread_List( $this );
			$page  = filter_input( INPUT_GET, 'page' );
			if ( ! $page ) {
				$page = filter_input( INPUT_POST, 'page' );
			}
			echo '<fieldset id="ahm-description">';
			echo '<legend id="ahm-legend">';
			esc_html_e( 'Unread detection', 'aurora-heatmap' );
			echo '</legend>';
			echo '<p>';
			esc_html_e( 'Detect pages that are not read enough (pages with a high unread rate). It can be used as a clue for content improvement.', 'aurora-heatmap' );
			echo '</p><p>';
			esc_html_e( 'Unread ratio for 6 weeks up to last week. This week is calculated on the next Monday.', 'aurora-heatmap' );
			echo '</p>';
			echo '<p><span class="ahm-unread-legend" style="background-color: rgba(173, 255, 47, 50%)"></span> ';
			esc_html_e( 'Rate where only 75% of the content was read. (Yellow-green)', 'aurora-heatmap' );
			echo '<br><span class="ahm-unread-legend" style="background-color: rgba(205, 173, 0, 75%)"></span> ';
			esc_html_e( 'Rate where only 50% of the content was read. (Orange)', 'aurora-heatmap' );
			echo '<br><span class="ahm-unread-legend" style="background-color: rgba(255, 99, 71, 100%)"></span> ';
			esc_html_e( 'Rate where only 25% of the content was read. (Red)', 'aurora-heatmap' );
			echo '</p>';
			echo '</fieldset>';
			echo '<form method="POST" id="ahm-unread-form">';
			echo '<input type="hidden" name="page" value="' . esc_attr( $page ) . '">';
			echo '<input type="hidden" name="tab" value="' . esc_attr( $active_tab ) . '">';
			$table->prepare_items();
			$table->search_box( __( 'Search page', 'aurora-heatmap' ), 'search_page' );
			$table->display();
			echo '</form>';
		} elseif ( 'settings' === $active_tab && $this->can_view() && 'preview_email_plain' === filter_input( INPUT_GET, 'section' ) ) {
			include_once __DIR__ . '/class-aurora-heatmap-weekly-email.php';
			$email = new Aurora_Heatmap_Weekly_Email( $this->get_weekly_data(), 'plain' );
			$email->preview();
		} elseif ( 'settings' === $active_tab && $this->can_view() && 'preview_email_html' === filter_input( INPUT_GET, 'section' ) ) {
			include_once __DIR__ . '/class-aurora-heatmap-weekly-email.php';
			$email = new Aurora_Heatmap_Weekly_Email( $this->get_weekly_data(), 'html' );
			$email->preview();
		} else {
			parent::print_tab_content( $active_tab );
		}
	}

	/**
	 * Get content height
	 *
	 * @param int $page_id  Target URL id.
	 * @param int $event_id Event_id.
	 * @return int
	 */
	protected function get_content_height( $page_id, $event_id ) {
		global $wpdb;

		if ( $event_id < 32 ) {
			return parent::get_content_height( $page_id, $event_id );
		}
		if ( $this::BREAKAWAY_PC === $event_id || $this::ATTENTION_PC === $event_id ) {
			$event_id_in1 = $this::BREAKAWAY_PC;
			$event_id_in2 = $this::ATTENTION_PC;
		} elseif ( $this::BREAKAWAY_MOBILE === $event_id || $this::ATTENTION_MOBILE === $event_id ) {
			$event_id_in1 = $this::BREAKAWAY_MOBILE;
			$event_id_in2 = $this::ATTENTION_MOBILE;
		}
		// phpcs:ignore WordPress.DB.DirectDatabaseQuery
		return $wpdb->get_var(
			$wpdb->prepare(
				"SELECT MAX( height - x ) FROM {$wpdb->prefix}ahm_events
				WHERE event IN ( %d, %d ) AND page_id2 = %d AND height BETWEEN x AND x + ( SELECT AVG( height - x ) + 2 * STD( height - x ) AS max FROM {$wpdb->prefix}ahm_events WHERE event IN ( %d, %d ) AND page_id2 = %d AND x <= height )",
				$event_id_in1,
				$event_id_in2,
				$page_id,
				$event_id_in1,
				$event_id_in2,
				$page_id
			)
		);
	}

	/**
	 * Update ahm_unread table
	 */
	protected function update_unread() {
		global $wpdb;

		$tz    = static::wp_timezone();
		$weeks = array();
		foreach ( range( -6, -1 ) as $i ) {
			$weeks[] = (int) ( new DateTime( sprintf( '%d week', $i ), $tz ) )->format( 'oW' );
		}

		$yw       = $weeks[0];
		$yw       = new DateTime( substr( $yw, 0, 4 ) . 'W' . substr( $yw, 4, 2 ), $tz );
		$yw_begin = $yw->format( 'Y-m-d' );
		$yw_end   = $yw->add( new DateInterval( 'P6W' ) )->format( 'Y-m-d' );
		$yw_keys  = array_reverse( $weeks );

		$sql = "SELECT event, id,
			MAX( CASE WHEN yw = %d THEN rate ELSE -1 END ) AS p1,
			MAX( CASE WHEN yw = %d THEN rate ELSE -1 END ) AS p2,
			MAX( CASE WHEN yw = %d THEN rate ELSE -1 END ) AS p3,
			MAX( CASE WHEN yw = %d THEN rate ELSE -1 END ) AS p4,
			MAX( CASE WHEN yw = %d THEN rate ELSE -1 END ) AS p5,
			MAX( CASE WHEN yw = %d THEN rate ELSE -1 END ) AS p6
			FROM
				(SELECT id, event, yw,
				SUM( c * ( ix_n.v - iz_n.v ) ) / SUM( c * iz_n.d4 ) AS rate
				FROM (
					SELECT
						t2.page_id2 as id,
						t2.event,
						YEARWEEK( t2.insert_at, 3 ) AS yw,
						IF( mh < t2.y, 0, 100 - ( 100 * t2.y DIV mh ) ) AS i,
						COUNT(*) AS c
					FROM {$wpdb->prefix}ahm_events AS t2
					INNER JOIN (
						SELECT page_id2, event & 47 AS ev, YEARWEEK( insert_at, 3 ) AS yw,
						IFNULL(
							AVG( IF( x BETWEEN 1 AND height, height - x, NULL ) ),
							IFNULL(
								(
									SELECT AVG( j2.height - j2.x )
									FROM {$wpdb->prefix}ahm_events AS j2
									INNER JOIN (
										SELECT page_id2, event,
											STR_TO_DATE( CONCAT( j1.insert_at, ' MONDAY' ), '%X%V %W' ) AS insert_from
										FROM {$wpdb->prefix}ahm_events AS j1
										WHERE j1.page_id2 = page_id2 AND j1.event = event
										  AND STR_TO_DATE( CONCAT( insert_at, ' MONDAY' ), '%X%V %W' ) < j1.insert_at AND x
										ORDER BY insert_at LIMIT 1
									) AS j3 USING( page_id2, event )
									WHERE j3.insert_from <= j2.insert_at AND DATE_ADD( j3.insert_from, INTERVAL 7 DAY )
								),
								AVG( height )
							)
						) AS mh
						FROM {$wpdb->prefix}ahm_events
						WHERE 32 <= event AND %s <= insert_at AND insert_at < %s
						GROUP BY page_id2, ev, yw
						HAVING SUM( event < 48 ) >= %d
					) AS t1 ON t2.page_id2 = t1.page_id2 AND t2.event = t1.ev AND YEARWEEK( t2.insert_at, 3 ) = t1.yw
					WHERE t2.event IN ( 32, 33 )
					GROUP BY t2.page_id2, t2.event, yw, i
				) as t3
				INNER JOIN {$wpdb->prefix}ahm_norm AS ix_n ON t3.i + %d = ix_n.i
				INNER JOIN {$wpdb->prefix}ahm_norm AS iz_n ON t3.i = iz_n.i
				GROUP BY id, event, yw
			) AS t4
			GROUP BY t4.id, t4.event
			ORDER BY event, p1 DESC, p2 DESC, p3 DESC, p4 DESC, p5 DESC, p6 DESC";

		$args   = array( $sql );
		$args   = array_merge( $args, $yw_keys );
		$args[] = $yw_begin;
		$args[] = $yw_end;
		$args[] = $this->options['unread_minimum'];
		$args[] = $this->options['unread_threshold'];

		$results = $wpdb->get_results( $wpdb->prepare( ...$args ) ); // phpcs:ignore WordPress.DB
		$event   = 0;
		$rank    = 0;
		$args    = array();
		foreach ( $results as $row ) {
			if ( $row->event !== $event ) {
				$event = $row->event;
				$rank  = 1;
			}
			$args[] = $row->id;
			$args[] = $event;
			$args[] = $rank++;
		}
		$wpdb->query( "TRUNCATE TABLE {$wpdb->prefix}ahm_unread" ); // phpcs:ignore WordPress.DB.DirectDatabaseQuery
		if ( $args ) {
			$placeholder = implode( ',', array_fill( 0, count( $args ) / 3, '(%d,%d,%d)' ) );
			$wpdb->query( $wpdb->prepare( "INSERT INTO {$wpdb->prefix}ahm_unread (id, event, rank) values {$placeholder}", $args ) ); // phpcs:ignore WordPress.DB
		}

		set_transient( 'ahm_unread_islive', $weeks, 600 );

		return $weeks;
	}

	/**
	 * Get unread items for Aurora_Heatmap_Unread_List
	 *
	 * @param array $param parameters. keys are event, search, pagenum, orderby, order.
	 */
	public function get_unread_items( $param ) {
		global $wpdb;

		$weeks = get_transient( 'ahm_unread_islive' );

		if ( ! is_array( $weeks ) ) {
			$weeks = $this->update_unread();
		}

		$param['order']   = strtolower( $param['order'] );
		$param['orderby'] = strtolower( $param['orderby'] );

		if ( ! in_array( $param['order'], array( 'desc', 'asc' ), true ) ) {
			$param['order'] = 'asc';
		}

		if ( ! in_array( $param['orderby'], array( 'page', 'pc', 'mobile' ), true ) ) {
			$param['orderby'] = 'page';
		}

		$ro = array(
			'asc'  => 'desc',
			'desc' => 'asc',
		);

		if ( 'page' === $param['orderby'] ) {
			$orderby_order = "p.url2 {$param['order']}";
		} elseif ( 'pc' === $param['orderby'] ) {
			$orderby_order = "isnull_r_p {$ro[ $param['order'] ]}, r_p.rank {$ro[ $param['order'] ]}";
		} elseif ( 'mobile' === $param['orderby'] ) {
			$orderby_order = "isnull_r_m {$ro[ $param['order'] ]}, r_m.rank {$ro[ $param['order'] ]}";
		}

		$where_and = '';
		if ( $param['search'] ) {
			$where_and = " AND p.id IN ( SELECT DISTINCT page_id2 FROM {$wpdb->prefix}ahm_events WHERE page_id IN ( SELECT id FROM {$wpdb->prefix}ahm_pages WHERE title LIKE %s OR url LIKE %s ) ) ";
		}

		$sql = "SELECT COUNT(*)
				FROM {$wpdb->prefix}ahm_pages AS p
				LEFT JOIN {$wpdb->prefix}ahm_unread AS r_p ON p.id = r_p.id AND 32 = r_p.event
				LEFT JOIN {$wpdb->prefix}ahm_unread AS r_m ON p.id = r_m.id AND 33 = r_m.event
				WHERE ( r_p.rank OR r_m.rank ) {$where_and}";

		$args = array( $sql );
		if ( $param['search'] ) {
			$args[] = $param['search_title'];
			$args[] = $param['search_url'];
			$total  = $wpdb->get_var( $wpdb->prepare( ...$args ) ); // phpcs:ignore WordPress.DB
		} else {
			$total = $wpdb->get_var( $sql ); // phpcs:ignore WordPress.DB
		}

		$total_pages      = ceil( $total / $this::LIST_PER_PAGE );
		$param['pagenum'] = min( $param['pagenum'], $total_pages );

		$sql = "SELECT st.*, ISNULL(r_p.rank) AS isnull_r_p, ISNULL(r_m.rank) AS isnull_r_m, p.url2 AS url, p.title
				FROM {$wpdb->prefix}ahm_pages AS p
				LEFT JOIN {$wpdb->prefix}ahm_unread AS r_p ON p.id = r_p.id AND 32 = r_p.event
				LEFT JOIN {$wpdb->prefix}ahm_unread AS r_m ON p.id = r_m.id AND 33 = r_m.event
				LEFT JOIN (
					SELECT page_id2 as id,
						COUNT( event = 16 OR NULL ) AS click_pc,
						COUNT( event = 32 OR NULL ) AS breakaway_pc,
						COUNT( event = 48 OR NULL ) AS attention_pc,
						COUNT( event = 17 OR NULL ) AS click_mobile,
						COUNT( event = 33 OR NULL ) AS breakaway_mobile,
						COUNT( event = 49 OR NULL ) AS attention_mobile
					FROM {$wpdb->prefix}ahm_events
					GROUP BY page_id2
				) AS st ON p.id = st.id
				WHERE ( r_p.rank OR r_m.rank ) {$where_and}
				ORDER BY {$orderby_order}, isnull_r_p ASC, r_p.rank DESC, isnull_r_m ASC, r_m.rank DESC, p.url ASC
				LIMIT %d OFFSET %d";

		$args = array( $sql );
		if ( $param['search'] ) {
			$args[] = $param['search_title'];
			$args[] = $param['search_url'];
		}
		$args[] = $this::LIST_PER_PAGE;
		$args[] = $this::LIST_PER_PAGE * ( max( $param['pagenum'], 1 ) - 1 );

		$items = $wpdb->get_results( $wpdb->prepare( ...$args ) ); // phpcs:ignore WordPress.DB
		if ( ! $items ) {
			return array(
				'total' => 0,
				'items' => array(),
				'graph' => array(),
			);
		}

		$keys = array();
		foreach ( $items as $i => $r ) {
			$keys[] = $r->id;
		}

		$tz       = static::wp_timezone();
		$yw       = $weeks[0];
		$yw       = new DateTime( substr( $yw, 0, 4 ) . 'W' . substr( $yw, 4, 2 ), $tz );
		$yw_begin = $yw->format( 'Y-m-d' );
		$yw_end   = $yw->add( new DateInterval( 'P6W' ) )->format( 'Y-m-d' );

		$placeholder = implode( ',', array_fill( 0, count( $items ), '%d' ) );

		$sql = "SELECT id, event, yw,
			SUM(c * ( ix_n.v - iz_n.v ) ) AS zx,
			SUM(c * iz_n.d1 ) AS z1,
			SUM(c * iz_n.d2 ) AS z2,
			SUM(c * iz_n.d3 ) AS z3,
			SUM(c * iz_n.d4 ) AS z4,
			SUM(c) AS c,
			height
			FROM (
				SELECT
					t2.page_id2 as id,
					t2.event,
					YEARWEEK( t2.insert_at, 3 ) AS yw,
					mh AS height,
					IF( mh < t2.y, 0, 100 - ( 100 * t2.y DIV mh ) ) AS i,
					COUNT(*) AS c
				FROM {$wpdb->prefix}ahm_events AS t2
				INNER JOIN (
					SELECT page_id2, event & 47 AS ev, YEARWEEK( insert_at, 3 ) AS yw,
					IFNULL(
						AVG( IF( x BETWEEN 1 AND height, height - x, NULL ) ),
						IFNULL(
							(
								SELECT AVG( j2.height - j2.x )
								FROM {$wpdb->prefix}ahm_events AS j2
								INNER JOIN (
									SELECT page_id2, event,
										STR_TO_DATE( CONCAT( j1.insert_at, ' MONDAY' ), '%X%V %W' ) AS insert_from
									FROM {$wpdb->prefix}ahm_events AS j1
									WHERE j1.page_id2 = page_id2 AND j1.event = event
										AND STR_TO_DATE( CONCAT( insert_at, ' MONDAY' ), '%X%V %W' ) < j1.insert_at AND x
									ORDER BY insert_at LIMIT 1
								) AS j3 USING( page_id2, event )
								WHERE j3.insert_from <= j2.insert_at AND DATE_ADD( j3.insert_from, INTERVAL 7 DAY )
							),
							AVG( height )
						)
					) AS mh
					FROM {$wpdb->prefix}ahm_events
					WHERE page_id2 IN ({$placeholder}) AND 32 <= event AND %s <= insert_at AND insert_at < %s
					GROUP BY page_id2, ev, yw
					HAVING SUM( event < 48 ) >= %d
				) AS t1 ON t2.page_id2 = t1.page_id2 AND t2.event = t1.ev AND YEARWEEK( t2.insert_at, 3 ) = t1.yw
				WHERE t2.event IN ( 32, 33 )
				GROUP BY t2.page_id2, t2.event, yw, i
			) AS t3
			INNER JOIN {$wpdb->prefix}ahm_norm AS ix_n ON t3.i + %d = ix_n.i
			INNER JOIN {$wpdb->prefix}ahm_norm AS iz_n ON t3.i = iz_n.i
			GROUP BY id, event, yw";

		$args   = array_slice( $keys, 0 );
		$args[] = $yw_begin;
		$args[] = $yw_end;
		$args[] = $this->options['unread_minimum'];
		$args[] = $this->options['unread_threshold'];

		$results = $wpdb->get_results( $wpdb->prepare( $sql, $args ) ); // phpcs:ignore WordPress.DB

		$w_index = array_flip( $weeks );

		$graph = array();

		foreach ( $results as $r ) {
			$yw_date = $this->yearweek2date( $r->yw, $tz );
			$ratio   = $r->zx / $r->z4;
			$data    = array(
				$r->z1 / $r->z4,
				$r->z2 / $r->z4,
				$r->z3 / $r->z4,
				$ratio,
				'ratio'  => $ratio,
				'from'   => $yw_date['from'],
				'to'     => $yw_date['to'],
				'about'  => $ratio * $r->c,
				'total'  => $r->c,
				'class'  => $this->options['unread_warning'] <= 100 * $ratio ? 'warning' : 'normal',
				'height' => $r->height,
			);
			if ( ! isset( $graph[ $r->id ] ) ) {
				$graph[ $r->id ] = array();
			}
			if ( ! isset( $graph[ $r->id ][ $r->event ] ) ) {
				$graph[ $r->id ][ $r->event ] = array();
			}
			$graph[ $r->id ][ $r->event ][ $w_index[ $r->yw ] ] = $data;
		}

		return array(
			'total' => $total,
			'items' => $items,
			'graph' => $graph,
		);
	}

	/**
	 * Convert yearweek to date format
	 *
	 * @param int          $yearweek Yearweek.
	 * @param DateTimeZone $tz       Timezone.
	 * @return array
	 */
	public function yearweek2date( $yearweek, $tz ) {
		$str    = strval( $yearweek );
		$date   = new DateTime( substr( $str, 0, 4 ) . 'W' . substr( $str, 4, 2 ), $tz );
		$format = _x( 'M jS, Y', 'Date Format', 'aurora-heatmap' );
		$short  = _x( 'M jS', 'Date Format', 'aurora-heatmap' );
		$from   = $date->format( $format );
		$from_y = $date->format( 'Y' );
		$date   = $date->add( new DateInterval( 'P6D' ) );
		$to_y   = $date->format( 'Y' );
		$to     = $date->format( $from_y === $to_y ? $short : $format );

		return array(
			'from' => $from,
			'to'   => $to,
		);
	}

	/**
	 * Get heatmap data
	 *
	 * @param int $url_id    target URL id.
	 * @param int $event_id event_id.
	 * @return array
	 */
	protected function get_heatmap_data( $url_id, $event_id ) {
		switch ( $event_id ) {
			case $this::CLICK_PC:
			case $this::CLICK_MOBILE:
				return $this->get_click_heatmap( $url_id, $event_id );
			case $this::BREAKAWAY_PC:
			case $this::BREAKAWAY_MOBILE:
				return $this->get_breakaway_heatmap( $url_id, $event_id );
			case $this::ATTENTION_PC:
			case $this::ATTENTION_MOBILE:
				return $this->get_attention_heatmap( $url_id, $event_id );
			default:
				return array();
		}
	}

	/**
	 * Get breakaway heatmap
	 *
	 * @param int $url_id   target URL id.
	 * @param int $event_id event_id.
	 * @return array
	 */
	protected function get_breakaway_heatmap( $url_id, $event_id ) {
		$counts = $this->get_vertical_statistics( $url_id, $event_id, 40 );
		$counts = new Ts51_Histogram( $counts );
		$colors = clone $counts;
		$colors = $colors->unfold_bins( 4 )->smooth( 10 )->reverse_cumulative()->normalize();
		return array(
			'counts' => $counts->to_array(),
			'ratios' => $counts->reverse_cumulative()->normalize()->to_array(),
			'colors' => array_chunk( $colors->to_array(), 4 ),
		);
	}

	/**
	 * Get attention heatmap
	 *
	 * @param int $url_id   target URL.
	 * @param int $event_id event_id.
	 * @return array
	 */
	protected function get_attention_heatmap( $url_id, $event_id ) {
		$counts = $this->get_vertical_statistics( $url_id, $event_id, 10 );
		$counts = new Ts51_Histogram( $counts );
		$colors = clone $counts;
		$colors = $colors->smooth( 4.5 )->normalize();
		return array(
			'counts' => $counts->fold_bins( 4 )->to_array(),
			'colors' => array_chunk( $colors->to_array(), 4 ),
		);
	}

	/**
	 * Get weekly data sources.
	 *
	 * @return array
	 */
	protected function get_weekly_data() {
		$data = array(
			'slug' => $this::SLUG,
		);

		$targets = array(
			static::BREAKAWAY_PC     => array(
				'orderby' => 'pc',
				'order'   => 'desc',
				'search'  => '',
				'pagenum' => 1,
			),
			static::BREAKAWAY_MOBILE => array(
				'orderby' => 'mobile',
				'order'   => 'desc',
				'search'  => '',
				'pagenum' => 1,
			),
		);

		$tz               = static::wp_timezone();
		$data['the_week'] = $this->yearweek2date( (int) ( new DateTime( '-1 week', $tz ) )->format( 'oW' ), $tz );

		$unread = array();

		foreach ( $targets as $key => $param ) {
			$ret   = $this->get_unread_items( $param );
			$items = array();
			foreach ( $ret['items'] as $i => $item ) {
				if ( 10 <= $i ) {
					break;
				}
				if ( isset( $ret['graph'][ $item->id ][ $key ][5]['class'] ) && 'warning' === $ret['graph'][ $item->id ][ $key ][5]['class'] ) {
					$last           = $ret['graph'][ $item->id ][ $key ][5];
					$last['id']     = $item->id;
					$last['url']    = $item->url;
					$last['title']  = $item->title;
					$items[]        = $last;
					$unread['from'] = $last['from'];
					$unread['to']   = $last['to'];
				}
			}
			$unread[ $param['orderby'] ] = $items;
		}

		$data['unread'] = $unread;

		return $data;
	}

	/**
	 * Get current yearweek
	 *
	 * Monday 0:00 to 4:00 will be last yearweek.
	 *
	 * @return integet For example, the 3rd week of 2021 will be 202103.
	 */
	protected function get_current_yearweek() {
		$now = new DateTime( 'now', static::wp_timezone() );
		return (int) $now->sub( new DateInterval( 'PT4H' ) )->format( 'oW' );
	}

	/**
	 * Daily cron
	 */
	public function aurora_heatmap_cron_daily() {
		parent::aurora_heatmap_cron_daily();
		$this->update_unread();

		// Weekly processing.
		$yearweek = $this->get_current_yearweek();
		if ( $this->options['last_weekly_process'] < $yearweek ) {
			if ( $this->options['weekly_email_sending'] ) {
				$this->send_weekly_email();
			}
			$this->options['last_weekly_process'] = $yearweek;
		}
	}

	/**
	 * Send weekly email
	 */
	protected function send_weekly_email() {
		include_once __DIR__ . '/class-aurora-heatmap-weekly-email.php';
		$email = new Aurora_Heatmap_Weekly_Email( $this->get_weekly_data(), $this->options['weekly_email_content_type'] );
		$email->send();
	}

	/**
	 * Delete data for Aurora_Heatmap_List
	 *
	 * @param array $pageid   Array of pageid.
	 */
	public function delete_data( $pageid ) {
		global $wpdb;
		$in = implode( ',', array_fill( 0, count( $pageid ), '%d' ) );
		$wpdb->query( $wpdb->prepare( "DELETE r FROM {$wpdb->prefix}ahm_unread AS r WHERE EXISTS ( SELECT * FROM {$wpdb->prefix}ahm_events WHERE page_id = r.id AND page_id2 IN ({$in}) )", $pageid ) ); // phpcs:ignore WordPress.DB
		parent::delete_data( $pageid );
	}

	/**
	 * Delete all data
	 */
	protected function delete_all() {
		global $wpdb;
		$wpdb->query( "TRUNCATE TABLE {$wpdb->prefix}ahm_unread" ); // phpcs:ignore WordPress.DB.DirectDatabaseQuery
		parent::delete_all();
	}

}

/* vim: set ts=4 sw=4 sts=4 noet: */
