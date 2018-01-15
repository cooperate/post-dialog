<?php
/**
 * Use shortcodes to display a "gallery" for posts.
 * The shortcode can filter by post_id or category. 
 * ex. [post-dialog-button category="news"] would include every post from category news.
 *
 * @wordpress-plugin
 * Plugin Name:       C4Wise Wordpress Post Dialog
 * Description:       A dialog for viewing posts on a single page.
 * Version:           1.0.0
 * Author:            Brett Cizmar
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 */
 
defined( 'WPINC' ) || die;
 
include_once 'c4wise-wp-post-dialog-frontend.php';
 
add_action( 'plugins_loaded', 'wc_input_start' );
/**
 * Start the plugin.
 */
function wc_input_start() {
	$frontend = new Wordpress_Post_Dialog();
    $frontend->init();
}