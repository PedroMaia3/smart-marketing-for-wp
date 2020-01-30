<?php


class TrackingEngageSDK
{
    protected $client_id;
    protected $list_id;
    protected $order_id;
    const OPTION_FLAG = 'order_trigger_';

    public function __construct($client_id, $list_id, $order_id = false)
    {
        $this->list_id = $list_id;
        $this->client_id = $client_id;
        if(!empty($order_id)){ $this->order_id = $order_id; }
    }

    public function getStartUp(){
        $this->setOrder();
        if(!isset($_GET['wc-ajax'])) {
            ?>
            <script>
                (function () {
                        window._egoiaq = window._egoiaq || [];
                        var url = (("https:" == document.location.protocol) ? "https://egoimmerce.e-goi.com/" : "http://egoimmerce.e-goi.com/");
                        var d = document, g = d.createElement('script'), s = d.getElementsByTagName('script')[0];
                        g.type = 'text/javascript';
                        g.defer = true;
                        g.async = true;
                        g.src = url + 'egoimmerce.js';
                        s.parentNode.insertBefore(g, s);
                        window._egoiaq.push(['setClientId', <?php echo $this->client_id ?>]);
                        window._egoiaq.push(['setListId', <?php echo $this->list_id ?>]);
                        <?php if($this->checkSubscriber() !== false){ ?>window._egoiaq.push(['setSubscriber', "<?php echo $this->checkSubscriber(); ?>"]);<?php } ?>

                        window._egoiaq.push(['setTrackerUrl', url + 'collect']);
                        window._egoiaq.push(['trackPageView']);
                    }
                )();
            </script>
            <?php
        }
        if (!class_exists('WooCommerce')) {return false;}
        $this->getProductView();
        $this->getProductsInCart();
    }

    protected function getProductView(){
        if(!is_product()){ return false; }
        $product = wc_get_product( get_the_id() );

        ?>

            <script>

                window._egoiaq.push(['setEcommerceView',
                    "<?php echo $product->get_id(); ?>",
                    "<?php echo $product->get_name(); ?>",
                    "",
                    <?php echo (double) $product->get_price(); ?>
                ]);
                window._egoiaq.push(['trackPageView']);

            </script>

        <?php
    }

    protected function getProductsInCart(){
        if(!empty($this->order_id)){return false;}
        $cart = WC()->cart->get_cart();
        foreach ( $cart as $cart_item ) {
            ?>
            <script>
                window._egoiaq.push(['addEcommerceItem',
                    "<?php echo $cart_item['product_id']; ?>",
                    "<?php echo $cart_item['data']->get_title(); ?>",
                    "",
                    <?php echo (double) $cart_item['data']->get_price(); ?>,
                    <?php echo (int) $cart_item['quantity']; ?>
                ]);
            </script>
            <?php
        }

        if(count($cart) == 0){ return false; }

        ?>

        <script>
            window._egoiaq.push(['trackEcommerceCartUpdate',
                <?php echo (double) WC()->cart->cart_contents_total; ?>]);

            window._egoiaq.push(['trackPageView']);
        </script>

        <?php
        return true;
    }

    public function getOrder(){
        if(empty($this->order_id)){return false;}

        $order = get_option(self::OPTION_FLAG.$this->order_id);
        if(empty($order)){ return false; }

        $this->printOrder($order);

        delete_option(self::OPTION_FLAG.$this->order_id);

        return true;
    }

    public function setOrder(){
        if(empty($this->order_id)){return false;}
        $order = wc_get_order( $this->order_id );
        update_option(self::OPTION_FLAG.$this->order_id, $order);
        return true;
    }

    /**
     * @return bool | string
     */
    private function checkSubscriber(){
        $current_user = wp_get_current_user();
        if ( ! $current_user->exists() ){ return false; }
        return $current_user->user_email;
    }

    private function printOrder($order){

        $order_id  = $order->get_id(); // Get the order ID
        $items = $order->get_items();
        if(!is_array($items)){ $items = []; }

        foreach ($items as $item){

            ?>

            <script>
                window._egoiaq.push(['addEcommerceItem',
                    "<?php echo $item->get_product_id(); ?>",
                    "<?php echo $item->get_name(); ?>",
                    "",
                    <?php echo (double) $item->get_subtotal(); ?>,
                    <?php echo (int) $item->get_quantity(); ?>
                ]);
            </script>

            <?php
        }

        if(count($items)>0){
            ?>
            <script>
                window._egoiaq.push(['trackEcommerceOrder',
                    "<?php echo $order_id; ?>", // (required) Unique Order ID
                    <?php echo (double) $order->get_total(); ?>, // (required) Order Revenue grand total (includes tax, shipping, and subtracted discount)
                    <?php echo (double) $order->get_subtotal(); ?>, // (optional) Order sub total (excludes shipping)
                    <?php echo (double) $order->get_total_tax(); ?>, // (optional) Tax amount
                    <?php echo (double) $order->get_shipping_total(); ?>, // (optional) Shipping amount
                    <?php echo !empty($order->get_total_discount()); ?> // (optional) Discount offered (set to false for unspecified parameter)
                ]);

                window._egoiaq.push(['trackPageView']);
            </script>
            <?php
        }

        return true;

    }

}