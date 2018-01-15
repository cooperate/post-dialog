<?php

class Wordpress_Post_Dialog {
	
	public function init(){
		add_action( 'wp_enqueue_scripts', 
			array( $this, 'c4wise_wp_load_dialog_scripts') );
		add_action( 'wp_enqueue_scripts',
			array( $this, 'c4wise_wp_load_dialog_styles') );
		add_shortcode( 'post-dialog-button', 
			array( $this ,'post_dialog_func') );
	}
	
	public function c4wise_wp_load_dialog_scripts(){

		wp_register_script( 'dialog-popup-script', plugins_url( '/js/dialog-script.js', __FILE__ ), array( 'jquery', 'jquery-ui-core' ) );

	}
	
	public function c4wise_wp_load_dialog_styles(){
		
		wp_register_style( 'dialog-style', plugins_url( '/css/dialog-style.css', __FILE__ ), array(), '20120208', 'all' );
		wp_enqueue_style( 'dialog-style' );
		
	}
	
	//[post_dialog]
	public function post_dialog_func( $atts ){
		
		$shortcode_button = "";
		
		$a = shortcode_atts( array(
			'button_image' => 'button image',
			'post_id' => 'some post id',
			'image' => 'post image here',
			'header' => 'post title here',
			'content' => 'post content here',
			'post_footer' => array( 'default_text' => 'post footer info here' ),
			'category' => 'default'
		), $atts );
		
		if ($a['category'] != 'default'){
			$args = array(
				'orderby'          => 'title',
				'order'            => 'DESC',
				'category_name'	   => $a['category'],
				'post_type'        => 'soscp',
				'post_status'      => 'publish'
				);
			$posts_array = get_posts($args);
			foreach($posts_array as $post){
				$shortcode_button = $shortcode_button . $this->generate_post_data($a, true, $post);
			}
		}
		else{
			$shortcode_button = $shortcode_button . $this->generate_post_data($a, false);
		}
		
		wp_enqueue_script( 'dialog-popup-script' );

		return $shortcode_button;
	}
	
	public function generate_post_data(&$a, $is_category, $post = null){
		$post_data;
		
		if ($is_category){
			$post_data =  $post->ID;
		}
		else{
			$post_data = get_post($a['post_id']);
		}
		
		if (!empty($post_data)){
			$a['header'] = apply_filters( 'the_title', $post_data->post_title );
			if (has_post_thumbnail($post_data)){
				$a['image'] = get_the_post_thumbnail_url( $post_data->ID );
			}
			$a['content'] = apply_filters( 'the_content', $post_data->post_content );
			$address = get_post_meta($post_data->ID, 'address', true);
			$contact = get_post_meta($post_data->ID, 'contact', true);
			$website = get_post_meta($post_data->ID, 'website', true);
			if (!empty($address)){
				$a['post_footer']['address'] = $address;
			}
			if (!empty($contact)){
				$a['post_footer']['contact'] = $contact;
			}
			if (!empty($website)){
				$a['post_footer']['website'] = $website;
			}
		}
		$token = wp_generate_password(32, false, false);
		wp_localize_script( 'dialog-popup-script', 'dialog_popup_script_' . $token, $a );
		$shortcode_button = '<div data-token="' . $token . '" class="button-dialog-container"><img src="' . $a['image'] . '" alt="Image not available for ' . $a['header'] . '"></div>';
		
		return $shortcode_button;
	}
}

?>