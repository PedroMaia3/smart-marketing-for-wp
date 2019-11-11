<?php

if ( ! defined( 'ABSPATH' ) ) {
    die();
}
$dir = plugin_dir_path(__FILE__) . 'capture/';
include_once $dir . '/functions.php';
require_once plugin_dir_path(__FILE__) . 'egoi-for-wp-common.php';
$page = array(
    'home' => !isset($_GET['sub']),
    'campaign-rss' => $_GET['sub'] == 'campaign-rss',
    'rss-feed' => $_GET['sub'] == 'rss-feed',
);
if(isset($_POST['action'])){
    $edit = isset($_GET['edit']) ? true : false;
    $result = $this->createFeed($_POST, $edit);

    if ($result) {

        echo get_notification(__('Success', 'egoi-for-wp'), __('RSS Feed saved!', 'egoi-for-wp'));

    }
}

if (isset($_GET['del'])) {
    delete_option($_GET['del']);
}

?>


<div class="smsnf">
    <div class="smsnf-modal-bg"></div>
    <!-- Header -->
    <header>
        <div class="wrapper-loader-egoi">
            <h1>Smart Marketing > <b><?php _e( 'RSS Feed', 'egoi-for-wp' ); ?></b></h1>
            <?=getLoader('egoi-loader',false)?>
        </div>
        <nav>
            <ul>
                <li><a class="home <?= $page['home'] ?'-select':'' ?>" href="?page=egoi-4-wp-rssfeed"><?= $home ?></a></li>
                <li><a class="<?= $page['rss-feed'] ?'-select':'' ?>" href="?page=egoi-4-wp-rssfeed&sub=rss-feed&add=1"><? _e('Rss Feed', 'egoi-for-wp'); ?></a></li>
                <li><a class="<?= $page['campaign-rss'] ?'-select':'' ?>" href="?page=egoi-4-wp-rssfeed&sub=campaign-rss"><? _e('Campaign Rss', 'egoi-for-wp'); ?></a></li>
            </ul>
        </nav>
    </header>
    <!-- / Header -->
    <!-- Content -->
    <main style="grid-template-columns: 1fr !important;">
        <!-- Content -->
        <section class="smsnf-content">

            <?php

            if(isset($_GET['sub']) && $_GET['sub'] == 'rss-feed'){
                require_once plugin_dir_path(__FILE__) . 'rssfeed/feed-rss.php';
            }else if(isset($_GET['sub']) && $_GET['sub'] == 'campaign-rss'){
                require_once plugin_dir_path(__FILE__) . 'rssfeed/campaign-rss.php';
            }else{
                require_once plugin_dir_path(__FILE__) . 'rssfeed/home.php';
            }

            ?>
        </section>
        <!-- / Content -->
    </main>
</div>

<?php $js_dir = plugins_url().'/smart-marketing-for-wp/admin/js/egoi-for-wp-rssfeed.js'; ?>
<script src="<?=$js_dir?>"></script>