<?php

namespace WcAutoDeleteOldOrders;

defined( 'ABSPATH' ) || exit; // Exit if accessed directly.

/**
 * Plugin Class.
 *
 * @since 1.0.0
 */
final class Plugin {

	/**
	 * Instance of this class.
	 *
	 * @var object
	 */
	protected static $instance = null;

	/**
	 * Return an instance of this class.
	 *
	 * @return object A single instance of this class.
	 */
	public static function get_instance() {

		// If the single instance hasn't been set, set it now.
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Initialize.
	 */
	public function init() {

		add_action( 'init', [ $this, 'schedule_delete' ] );
		add_action( 'wc_delete_old_orders_process', [ $this, 'process_delete' ] );
	}

	/**
	 * Schedule the delete process.
	 * 
	 * @since 1.0.0
	 */
	public function schedule_delete() {

		if ( false === as_next_scheduled_action( 'wc_delete_old_orders_process' ) ) {
			as_schedule_recurring_action( strtotime( '+ 1 day' ), DAY_IN_SECONDS, 'wc_delete_old_orders_process', array(), 'wc_delete_old_orders' );
		}
	}

	/**
	 * Process Delete.
	 * 
	 * @since 1.0.0
	 */
	public function process_delete() {

		if ( ! function_exists( 'wc_get_orders' ) ) {
			return;
		}

		$args = array(
			'date_created' => '>' . ( time() - 3 * MONTH_IN_SECONDS ),
		);

		$orders = \wc_get_orders( $args );

		foreach ( $orders as $order ) {
			\wp_delete_post( $order->get_id() );
		}
	}
}
