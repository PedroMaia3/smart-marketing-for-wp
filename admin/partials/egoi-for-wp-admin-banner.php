<?php
if ( ! defined( 'ABSPATH' ) ) {
	die();
}

add_thickbox();

?>

<div class="egoi-box" style="background-color: transparent; padding: 0;width:250px;">
	<?php
		require_once dirname( __DIR__ ) . '/partials/egoi-for-wp-admin-alert.php';
	if ( ! empty( $alert ) ) {
		echo $alert;
	}
	?>

	<embed>
		<div class="pub-body">
			<div class="pub-wrap-rate pub-clearfix" style="min-width: 250px; padding: 10px">
				<div class="pub-left" style="width: 100%;">
					<img alt="E-goi" src="<?php echo plugin_dir_url( __FILE__ ) . '../img/pub'; ?>/e-goi.png">
					<h2><?php _e( 'WooCommerce SMS', 'egoi-for-wp' ); ?></h2>
					<p><?php _e( 'Send SMS notifications to your buyers and admins for each change to the order status in your WooCommerce store. Increase your conversions and better communicate with your customers.', 'egoi-for-wp' ); ?></p>
					<div style="margin: 40px 0 10px 0;">
						<a class="button-custom-egoi" href=" https://pt.wordpress.org/plugins/sms-orders-alertnotifications-for-woocommerce/" target="blank">DOWNLOAD »</a>
					</div>
				</div>
				<div class="pub-right">
					<img alt="Rating" src="<?php echo plugin_dir_url( __FILE__ ) . '../img'; ?>/addon-sms-notification.png" width="200px">
				</div>
			</div>
		</div>
	</embed>
</div>


