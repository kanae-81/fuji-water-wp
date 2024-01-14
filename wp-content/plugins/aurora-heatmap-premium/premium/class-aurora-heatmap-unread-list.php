<?php
/**
 * Aurora Heatmap Unread List Class
 *
 * @package aurora-heatmap
 * @copyright 2019-2022 R3098 <info@seous.info>
 * @version 1.5.6
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'WP_List_Table' ) ) {
	require_once ABSPATH . 'wp-admin/includes/class-wp-list-table.php';
}

/**
 * Aurora_Heatmap_Unread_List
 */
class Aurora_Heatmap_Unread_List extends WP_List_Table {

	/**
	 * Aurora_Heatmap object
	 *
	 * @var object
	 */
	private $heatmap;

	/**
	 * Graph data
	 *
	 * @var array
	 */
	private $graph;

	/**
	 * Constructor
	 *
	 * @param object $heatmap Aurora_Heatmap object.
	 */
	public function __construct( $heatmap ) {
		parent::__construct( array( 'ajax' => false ) );
		$this->heatmap = $heatmap;
	}

	/**
	 * Get table classes
	 *
	 * Remove fixed class.
	 */
	public function get_table_classes() {
		return array_diff( parent::get_table_classes(), array( 'fixed' ) );
	}

	/**
	 * Get columns
	 *
	 * @return array
	 */
	public function get_columns() {
		return array(
			'page'   => _x( 'Page', 'List_Table', 'aurora-heatmap' ),
			'pc'     => __( 'PC', 'aurora-heatmap' ),
			'mobile' => __( 'Mobile', 'aurora-heatmap' ),
		);
	}

	/**
	 * Get sortable columns
	 */
	public function get_sortable_columns() {
		$orderby = filter_input( INPUT_GET, 'orderby' );

		return array(
			'page'   => array( 'page', false ),
			'pc'     => array( 'pc', ( $orderby && 'pc' !== $orderby ) ),
			'mobile' => array( 'mobile', true ),
		);
	}

	/**
	 * Prepare items
	 */
	public function prepare_items() {
		global $wpdb;
		$this->_column_headers = array( $this->get_columns(), array(), $this->get_sortable_columns() );

		$orderby = filter_input( INPUT_GET, 'orderby' );
		if ( ! $orderby ) {
			$orderby = 'pc';
		}

		$order = strtolower( filter_input( INPUT_GET, 'order' ) );
		if ( ! in_array( $order, array( 'asc', 'desc' ), true ) ) {
			$order = 'desc';
		}

		$param = array(
			'search'  => filter_input( INPUT_GET, 's' ),
			'pagenum' => $this->get_pagenum(),
			'orderby' => $orderby,
			'order'   => $order,
		);

		if ( $param['search'] ) {
			$r            = preg_split( '/\s+/', $param['search'] );
			$search_title = array();
			$search_url   = array();
			foreach ( $r as $word ) {
				$search_title[] = $wpdb->esc_like( $word );
				$search_url[]   = $wpdb->esc_like(
					preg_replace_callback(
						'/[^\x21-\x7E]+/',
						function( $matches ) {
							return rawurlencode( $matches[0] );
						},
						$word
					)
				);
			}
			$param['search_title'] = '%' . implode( '%', $search_title ) . '%';
			$param['search_url']   = '%' . implode( '%', $search_url ) . '%';
		}

		$ret = $this->heatmap->get_unread_items( $param );

		$total_items = $ret['total'];
		$this->items = $ret['items'];
		$this->graph = $ret['graph'];

		$heatmap = $this->heatmap;

		$this->set_pagination_args(
			array(
				'total_items' => $total_items,
				'per_page'    => $heatmap::LIST_PER_PAGE,
				'total_pages' => ceil( $total_items / $heatmap::LIST_PER_PAGE ),
			)
		);
	}

	/**
	 * Column default
	 *
	 * @param stdClass $item        Item.
	 * @param string   $column_name Column name.
	 */
	public function column_default( $item, $column_name ) {
		return $column_name;
	}

	/**
	 * Get databox
	 *
	 * @param stdClass $item    Item.
	 * @param array    $columns Columns.
	 * @return string
	 */
	private function get_databox( $item, $columns ) {
		$str = '<div class="ahm-heatmap-databox">';
		foreach ( $columns as $key => $v ) {
			if ( $item->{$key} ) {
				$url  = $this->heatmap->get_heatmap_url( $item, $key );
				$str .= sprintf( '<a class="ahm-heatmap-databox-column ahm-view" href="%s" data-url="%s" data-width="%d" title="%s">%s <span class="dashicons dashicons-external"></span></a>', esc_attr( $url ), esc_attr( $url ), $this->heatmap::VIEW_WIDTH[ $this->heatmap::EVENT_NAMES[ $key ] & 15 ], esc_attr( $v ), esc_html( number_format( $item->{$key} ) ) );
			} else {
				$str .= sprintf( '<span class="ahm-cell-blank" title="%s">&mdash; </span>', esc_attr( $v ) );
			}
		}
		return $str . '</div>';
	}

	/**
	 * Column PC
	 *
	 * @param stdClass $item Item.
	 */
	public function column_pc( $item ) {
		return $this->get_svg_html( $item->id, 32 );
	}

	/**
	 * Column Mobile
	 *
	 * @param stdClass $item Item.
	 */
	public function column_mobile( $item ) {
		return $this->get_svg_html( $item->id, 33 );
	}

	/**
	 * Column Page
	 *
	 * @param stdClass $item Item.
	 */
	public function column_page( $item ) {
		static $columns;
		if ( ! $columns ) {
			$columns = array(
				__( 'PC', 'aurora-heatmap' )     => array(
					'click_pc'     => __( 'Click', 'aurora-heatmap' ),
					'breakaway_pc' => __( 'Breakaway', 'aurora-heatmap' ),
					'attention_pc' => __( 'Attention', 'aurora-heatmap' ),
				),
				__( 'Mobile', 'aurora-heatmap' ) => array(
					'click_mobile'     => __( 'Click', 'aurora-heatmap' ),
					'breakaway_mobile' => __( 'Breakaway', 'aurora-heatmap' ),
					'attention_mobile' => __( 'Attention', 'aurora-heatmap' ),
				),
			);
		}
		$thead1 = '';
		$thead2 = '';
		$tbody  = '';
		foreach ( $columns as $access => $events ) {
			$thead1 .= '<div class="ahm-c2">' . esc_html( $access ) . '</div>';
			foreach ( $events as $key => $name ) {
				$thead2 .= '<div class="ahm-c6">' . esc_html( $name ) . '</div>';
				$tbody  .= '<div class="ahm-c6">';
				if ( $item->{$key} ) {
					$url    = $this->heatmap->get_heatmap_url( $item, $key );
					$tbody .= sprintf( '<a class="ahm-view" href="%s" data-url="%s" data-width="%d">%s <span class="dashicons dashicons-external"></span></a>', esc_attr( $url ), esc_attr( $url ), $this->heatmap::VIEW_WIDTH[ $this->heatmap::EVENT_NAMES[ $key ] & 15 ], esc_html( number_format( $item->{$key} ) ) );
				} else {
					$tbody .= '<span class="ahm-cell-blank">&mdash; </span>';
				}
				$tbody .= '</div>';
			}
		}
		return '<div class="ahm-unread-list-page" tabindex="0"><div class="ahm-unread-list-page-inner"><strong>' . esc_html( $item->title ) . '</strong><br><a href="' . esc_attr( $item->url ) . '" target="_blank">' . esc_html( urldecode( $item->url ) ) . '</a></div><div class="ahm-unread-list-page-hover"><div class="ahm-pt">' . $thead1 . $thead2 . $tbody . '</div></div></div>';
	}

	/**
	 * Get svg and html
	 *
	 * @param int $id       Page id.
	 * @param int $event_id Event id.
	 * @return string
	 */
	public function get_svg_html( $id, $event_id ) {
		$data = array();
		if ( isset( $this->graph[ $id ][ $event_id ] ) ) {
			$data = $this->graph[ $id ][ $event_id ];
		}
		ksort( $data );
		$svg    = '';
		$points = array();

		$svg .= '<svg height="60" width="200" style="float: left;">';
		$svg .= '<style>';
		$svg .= '.r { opacity: 0; transition: .2s; } .r:only-child { opacity: 0.25; } .r:hover { opacity: 1; } ';
		$svg .= '</style>';
		$svg .= '<g shape-rendering="crispEdges">';

		// Inner x-axis.
		$svg .= '<line stroke="#CCC8" x1="2" x2="200" y1="4" y2="4" />';
		$svg .= '<line stroke="#CCC8" x1="2" x2="200" y1="16" y2="16" />';
		$svg .= '<line stroke="#CCC8" x1="2" x2="200" y1="28" y2="28" />';
		$svg .= '<line stroke="#CCC8" x1="2" x2="200" y1="40" y2="40" />';

		// Bar.
		foreach ( $data as $k => $v ) {
			if ( ! $v ) {
				continue;
			}

			$x    = $k * 32 + 7;
			$h    = intval( 48 * $v[2] );
			$y    = 52 - $h;
			$svg .= "<rect x='{$x}' y='{$y}' width='27' height='{$h}' fill='#ADFF2F80' />";
			$h    = intval( 48 * $v[1] );
			$y    = 52 - $h;
			$svg .= "<rect x='{$x}' y='{$y}' width='27' height='{$h}' fill='#CDAD00A0' />";
			$h    = intval( 48 * $v[0] );
			$y    = 52 - $h;
			$svg .= "<rect x='{$x}' y='{$y}' width='27' height='{$h}' fill='#FF6347C0' />";
			$h    = intval( 48 * $v[3] );

			$points[] = ( $x + 14 ) . ',' . ( 52 - $h );
		}

		// Outer x-axis and y-axis.
		$svg .= '<line stroke="#0003" x1="0" x2="2" y1="16" y2="16" />';
		$svg .= '<line stroke="#0003" x1="0" x2="2" y1="28" y2="28" />';
		$svg .= '<line stroke="#0003" x1="0" x2="2" y1="40" y2="40" />';
		$svg .= '<line stroke="#0003" x1="36" x2="36" y1="52" y2="54" />';
		$svg .= '<line stroke="#0003" x1="68" x2="68" y1="52" y2="54" />';
		$svg .= '<line stroke="#0003" x1="100" x2="100" y1="52" y2="54" />';
		$svg .= '<line stroke="#0003" x1="132" x2="132" y1="52" y2="54" />';
		$svg .= '<line stroke="#0003" x1="164" x2="164" y1="52" y2="54" />';
		$svg .= '<polyline stroke="#0006" fill="none" points="2,4 2,52 200,52" />';
		$svg .= '</g>';

		// Line graph.
		$svg .= '<polyline stroke="#900" stroke-width="3" stroke-opacity="0.75" stroke-linecap="round" fill="none" points="' . implode( ' ', $points ) . '" />';

		// Pointer of the line graph.
		$svg .= '<g>';

		foreach ( $data as $k => $v ) {
			if ( ! $v ) {
				continue;
			}
			$y    = 52 - intval( 48 * $v[3] );
			$x    = $k * 32 + 21;
			$svg .= "<circle cx='{$x}' cy='{$y}' r='5' fill='#900' class='r'>";
			// translators: %1$s: from %2$s: to %3$d: percentage %4$.1f: about %5$d total %6$d: height.
			$svg .= '<title>' . sprintf( __( "From %1\$s to %2\$s.\n%3\$d%% (about %4\$.1f of %5\$d, average height is %6\$d px)", 'aurora-heatmap' ), $v['from'], $v['to'], 100 * $v[3], $v['about'], $v['total'], $v['height'] ) . '</title>';
			$svg .= '</circle>';
		}

		$svg .= '</g>';
		$svg .= '</svg>';

		if ( isset( $k ) && 5 === $k && $v ) {
			$svg .= ' <span class="ahm-ratio ' . esc_attr( $v['class'] ) . '">' . intval( 100 * $v[3] ) . '</span>';
		} else {
			$svg .= ' <span class="ahm-ratio na">&mdash;</span>';
		}

		return $svg;
	}
}

/* vim: set ts=4 sw=4 sts=4 noet: */

