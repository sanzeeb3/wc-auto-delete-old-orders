<?php
/**
 * Plugin Name: WC Auto Delete Old Orders
 * Description: Automatically delete old redundant orders from the database.
 * Version: 1.0.0
 * Author: Sanjeev Aryal
 * Author URI: https://www.sanjeebaryal.com.np
 */

defined( 'ABSPATH' ) || die();

/**
 * Plugin constants.
 *
 * @since 1.0.0
 */
define( 'WC_AUTO_DELETE_OLD_ORDERS_PLUGIN_FILE', __FILE__ );
define( 'WC_AUTO_DELETE_OLD_ORDERS_PLUGIN_PATH', __DIR__ );
define( 'WC_AUTO_DELETE_OLD_ORDERS_VERSION', '1.0.0' );

require_once __DIR__ . '/action-scheduler/action-scheduler.php';
require_once __DIR__ . '/src/Plugin.php';

/**
 * Return the main instance of Plugin Class.
 *
 * @since  1.0.0
 *
 * @return Plugin.
 */
function wc_auto_delete_old_orders() {
	$instance = \WcAutoDeleteOldOrders\Plugin::get_instance();

    $instance->init();

	return $instance;
}

wc_auto_delete_old_orders();
