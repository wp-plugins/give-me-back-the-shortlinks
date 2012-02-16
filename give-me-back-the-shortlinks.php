<?php
/*
Plugin Name: Give me BACK the Shortlinks!
Plugin URI: http://web.freeall.org
Description: Give Me Back the Page & Custom Shortlinks! A very simple plugin for will add the shortlinks button under the content title also for Pages & Custom Post Types. Wordpress's default is shortlinking only the posts, but don't ask me why...
Version: 1.0
Author: Asaf Chertkoff
Author URI: http://web.freeall.org
License: GPL2
*/
if( !function_exists( 'my_theme_cpt_shortlinks' ) ) {
	/**
	 * Allow shortlinks to be retrieved for pages and custom post types
	 */
	function my_theme_cpt_shortlinks( $shortlink, $id, $context, $allow_slugs=true ) {
		/**
		 * If query is the context, we probably shouldn't do anything
		 */
		if( 'query' == $context )
			return $shortlink;

		$post = get_post( $id );
		$post_id = $post->ID;

		/**
		 * If this is a standard post, return the shortlink that was already built
		 */
		if( 'post' == $post->post_type )
			return $shortlink;

		/**
		 * Retrieve the array of publicly_queryable, non-built-in post types
		 */
		$post_types = get_post_types( array( '_builtin' => false, 'publicly_queryable' => true ) );
		if( in_array( $post->post_type, $post_types ) || 'page' == $post->post_type )
			$shortlink = home_url('?p=' . $post->ID);

		return $shortlink;
	}
}
add_filter( 'get_shortlink', 'my_theme_cpt_shortlinks', 10, 4 );

function wp_admin_bar_givmback_shortlink_menu( $wp_admin_bar ) {

		$post = get_post( $id );
		$post_id = $post->ID;

		/**
		 * If this is a standard post, return the shortlink that was already built
		 */
		if( 'post' == $post->post_type )
			return $shortlink;

		/**
		 * Retrieve the array of publicly_queryable, non-built-in post types
		 */
		$post_types = get_post_types( array( '_builtin' => false, 'publicly_queryable' => true ) );
		if( in_array( $post->post_type, $post_types ) || 'page' == $post->post_type )
			$shortlink = home_url('?p=' . $post->ID);

      $id = 'get-shortlink';
  
      if ( empty( $shortlink ) )
          return;
  
      $html = '<input class="shortlink-input" type="text" readonly="readonly" value="' . esc_attr( $shortlink ) . '" />';
  
      $wp_admin_bar->add_menu( array(
          'id' => $id,
          'title' => __( 'Shortlink' ),
          'href' => $shortlink,
          'meta' => array( 'html' => $html ),
      ) );
}
add_action( 'admin_bar_menu', 'wp_admin_bar_givmback_shortlink_menu',91 )
?>
