<?php
/**
 * Aurora Heatmap Weekly Email Class
 *
 * @package aurora-heatmap
 * @copyright 2019-2022 R3098 <info@seous.info>
 * @version 1.5.6
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Aurora_Heatmap_Weekly_Email
 */
class Aurora_Heatmap_Weekly_Email {

	/**
	 * StdClass Email object.
	 *
	 * @var object $email
	 */
	protected $email;

	/**
	 * Content-Type
	 *
	 * @var string $type plain or html.
	 */
	protected $type = 'plain';

	/**
	 * Constructor
	 *
	 * @param array  $data Weekly data sources.
	 * @param string $type Content-Type. plain or html.
	 */
	public function __construct( $data, $type = 'plain' ) {
		$this->email = (object) array(
			'to'          => array(),
			'subject'     => '',
			'message'     => '',
			'headers'     => array(),
			'attachments' => array(),
			'sending'     => true,
			'data'        => array(),
		);

		$this->type = $type;
		$user_query = new WP_User_Query( array( 'role' => 'Administrator' ) );
		if ( is_array( $user_query->results ) ) {
			foreach ( $user_query->results as $user ) {
				$this->email->to[] = $user->get( 'user_email' );
			}
		}

		$this->email->headers[] = "Content-Type: text/{$type}; charset=UTF-8";

		$this->apply_template( 'ahm-email', $data );
	}

	/**
	 * Preview
	 */
	public function preview() {
		$email = $this->email;
		$p     = array(
			'message' => $email->message,
			'type'    => 'text/' . $this->type,
		);
		?>
		<div>
			<b>To:</b> <?php echo esc_html( is_array( $email->to ) ? implode( ', ', $email->to ) : $email->to ); ?><br>
			<b>Subject:</b> <?php echo esc_html( $email->subject ); ?><br>
			<?php echo nl2br( esc_html( implode( "\n", $email->headers ) ) ); ?>
		</div>
		<div id="ahm-email-preview"></div>
		<script>
		(function() {
			var div = document.getElementById( 'ahm-email-preview' );
			var e = document.createElement( 'iframe' );
			var p = <?php echo wp_json_encode( $p ); ?>;
			function resize() {
				e.style.height = ( 1 + e.contentDocument.documentElement.offsetHeight ) + 'px';
			}
			e.sandbox = 'allow-same-origin allow-top-navigation-by-user-activation';
			e.style.width = '100%';
			e.style.backgroundColor = '#fff';
			e.src = URL.createObjectURL( new Blob( [ p.message ], { type: p.type } ) );
			div.appendChild( e );
			setTimeout( function resolver() {
				if ( e.contentDocument.readyState === 'complete' ) {
					Array.prototype.forEach.call(
						e.contentDocument.querySelectorAll( 'a[href]:not([target])' ),
						function ( e ) {
							e.target = '_top';
						}
					);
					e.contentWindow.addEventListener( 'resize', resize );
					resize();
				} else {
					setTimeout( resolver, 100 );
				}
			}, 500 );
		})();
		</script>
		<?php
	}

	/**
	 * Apply template
	 *
	 * @param string $slug Temaplate slug.
	 * @param mixed  $data Formatting data.
	 */
	protected function apply_template( $slug, $data = null ) {
		$this->email->data = $data;
		$file              = "$slug-{$this->type}.php";
		$path              = locate_template( array( 'templates/' . $file, $file ) );

		set_query_var( 'ahm_email', $this->email );
		ob_start();
		if ( $path ) {
			load_template( $path, false );
		} else {
			load_template( dirname( __DIR__ ) . '/templates/' . $file, false );
		}
		$this->email->message = ob_get_clean();
	}

	/**
	 * Send email
	 */
	public function send() {
		$email = $this->email;
		if ( ! $email->sending ) {
			return;
		}
		if ( ! is_array( $email->to ) ) {
			$email->to = array( $email->to );
		}
		foreach ( $email->to as $to ) {
			wp_mail( $to, $email->subject, $email->message, $email->headers, $email->attachments );
		}
	}
}
/* vim: set ts=4 sw=4 sts=4 noet : */
