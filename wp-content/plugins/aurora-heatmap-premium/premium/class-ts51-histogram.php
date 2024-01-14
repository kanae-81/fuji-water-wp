<?php
/**
 * Ts51 Histogram Class
 *
 * Generic histogram utility class.
 *
 * @package Ts51
 * @version 0.1.8
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Ts51_Histogram class
 *
 * @since 0.1.0
 */
class Ts51_Histogram {


	/**
	 * Histogram raw data
	 *
	 * @var array
	 */
	private $data;

	/**
	 * Constructor
	 *
	 * @since 0.1.0
	 * @param array $data Optional. Histogram data. Default array().
	 */
	public function __construct( $data = array() ) {
		$this->data = array();
		$next_index = null;
		foreach ( $data as $i => $v ) {
			if ( ! is_int( $i ) ) {
				continue;
			} elseif ( is_null( $next_index ) && $i ) {
				array_push( $this->data, ...array_fill( 0, $i, 0 ) );
			} elseif ( $next_index < $i ) {
				array_push( $this->data, ...array_fill( 0, $i - $next_index, 0 ) );
			}
			$this->data[] = $v;
			$next_index   = ++$i;
		}
	}

	/**
	 * To cumulative histogram
	 *
	 * @since 0.1.0
	 * @return $this
	 */
	public function cumulative() {
		$results = array();
		$sum     = 0;
		foreach ( $this->data as $i => $v ) {
			$results[] = ( $sum += $v );
		}
		$this->data = $results;
		return $this;
	}

	/**
	 * To reverse cumulative histogram
	 *
	 * @since 0.1.0
	 * @return $this
	 */
	public function reverse_cumulative() {
		$results = array();
		$sum     = array_sum( $this->data );
		foreach ( $this->data as $i => $v ) {
			$results[] = ( $sum -= $v );
		}
		$this->data = $results;
		return $this;
	}

	/**
	 * Normalize
	 *
	 * Adjust to 0.0 ~ 1.0
	 *
	 * @since 0.1.0
	 * @param int $precision Optional. Precision. Default 4.
	 * @return $this
	 */
	public function normalize( $precision = 4 ) {
		$max = count( $this->data ) ? max( $this->data ) : 0;
		if ( $max ) {
			foreach ( $this->data as $i => &$v ) {
				$v = round( $v / $max, $precision );
			}
		} else {
			$this->data = array_fill( 0, count( $this->data ), 0 );
		}
		return $this;
	}

	/**
	 * Reverse
	 *
	 * @since 0.1.0
	 * @return $this
	 */
	public function reverse() {
		$this->data = array_reverse( $this->data );
		return $this;
	}

	/**
	 * Generate gauss array for apply kernel function
	 *
	 * @since 0.1.0
	 * @param float $bandwidth Bandwidth, smoothing parameter.
	 * @param float $threshold Optional. Threshold. Default 0.001.
	 * @return array
	 */
	public function gauss( $bandwidth, $threshold = 0.001 ) {
		$kernel = array();
		$a      = M_SQRT1_2 / M_SQRTPI / $bandwidth;
		$x      = 0;
		$v      = 1;
		while ( $v >= $threshold ) {
			$g             = $v * $a;
			$kernel[ $x ]  = $g;
			$kernel[ -$x ] = $g;
			++$x;
			$v = exp( - $x * $x / 2 / $bandwidth / $bandwidth );
		}
		ksort( $kernel, SORT_NUMERIC );
		return $kernel;
	}

	/**
	 * Smoothing histogram
	 *
	 * Using gauss function as kernel function.
	 *
	 * @since 0.1.0
	 * @param float $bandwidth Bandwidth, smoothing parameter.
	 * @return $this
	 */
	public function smooth( $bandwidth ) {
		return $this->apply_kernel( $this->gauss( $bandwidth ) );
	}

	/**
	 * Apply kernel function
	 *
	 * @since 0.1.0
	 * @param array $kernel Kernel function array.
	 * @return $this
	 */
	public function apply_kernel( $kernel ) {
		$count   = count( $this->data );
		$w       = key( $kernel );
		$results = array_fill( 0, $count - $w, 0 );
		$i       = $w;
		while ( $i ) {
			$results[ $i++ ] = 0;
		}

		foreach ( $this->data as $i => $v ) {
			if ( 0 === $v ) {
				continue;
			}
			foreach ( $kernel as $x => $y ) {
				$results[ $i + $x ] += $v * $y;
			}
		}

		$this->data = array_slice( $results, 0, $count );
		return $this;
	}

	/**
	 * Fold bins
	 *
	 * @since 0.1.3
	 * @param int $bins bins.
	 * @return $this
	 */
	public function fold_bins( $bins ) {
		$this->data = array_chunk( $this->data, $bins );
		foreach ( $this->data as &$v ) {
			$v = array_sum( $v );
		}
		return $this;
	}

	/**
	 * Unfold bins
	 *
	 * @since 0.1.3
	 * @param int $bins bins.
	 * @return $this
	 */
	public function unfold_bins( $bins ) {
		$count     = count( $this->data ) * $bins;
		$results   = array_fill( 0, $count, 0 );
		$bins_half = floor( $bins / 2 );
		foreach ( $this->data as $i => $v ) {
			$results[ $i * $bins + $bins_half ] = $v;
		}
		$this->data = $results;
		return $this;
	}

	/**
	 * Return array data
	 *
	 * @since 0.1.0
	 * @return array
	 */
	public function to_array() {
		return $this->data;
	}

	/**
	 * Return vertical histogram string
	 *
	 * Using unicode Block Elements U+2588 ~ U+258F.
	 *
	 * @since 0.1.5
	 * @param int $cols Optional. Console columns. Default 80.
	 * @return string
	 */
	public function dump( $cols = 80 ) {
		$bar       = array( '█', '▉', '▊', '▋', '▌', '▍', '▎', '▏' );
		$count_len = strlen( strval( count( $this->data ) ) );
		$max       = max( $this->data );
		$max_len   = strlen( strval( $cols * 8 ) );
		$format    = "%{$count_len}d=%{$max_len}d:%s%s" . PHP_EOL;
		$width     = ( $cols - 3 - $count_len - $max_len ) * 8 / $max;
		$result    = '';
		foreach ( $this->data as $i => $v ) {
			$v       = intval( round( $v * $width ) );
			$e       = $v % 8;
			$b       = intdiv( $v, 8 );
			$result .= sprintf( $format, $i, $v, str_repeat( $bar[0], $b ), $e ? $bar[ $e ] : '' );
		}
		return $result;
	}
}

/* vim: set ts=4 sw=4 sts=4 noet: */
