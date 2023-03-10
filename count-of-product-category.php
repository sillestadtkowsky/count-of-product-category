<?php
/**
* Plugin Name: Count of Product Category for WP WooCommerce 
* Plugin URI: https://osowsky-webdesign.de/plugins/count-of-product-category
* Description: This plugin provides a shortcode that displays the count of products in a product category. IMPORTANT! This is clearly NOT an official plugin from Woocommerce.
* Version: 1.0.3
* Requires at least: 5.8.0
* Requires PHP:      8.0
* Author: Silvio Osowsky
* License: GPLv3 or later
* License URI: https://www.gnu.org/licenses/gpl-3.0.html
* Author URI: https://osowsky-webdesign.de/
*/

function category_product_count_shortcode( $atts ) {
  // shortcode attributes
  $atts = shortcode_atts( array(
      'category' => '',
      'show_category_name' => true,
  ), $atts, 'category_product_count' );

  // get category id
  $category_id = get_term_by( 'name', $atts['category'], 'product_cat' )->term_id;

  // get products in category
  $args = array(
      'post_type' => 'product',
      'tax_query' => array(
          array(
              'taxonomy' => 'product_cat',
              'field' => 'term_id',
              'terms' => $category_id,
          ),
      ),
  );
  $products = new WP_Query( $args );

  // build output string
  $output = '<div style="display: flex; align-items: center; justify-content: center;">';
  if ( $atts['show_category_name'] == 'true' ) {
      $output .= $atts['category'] . ' ';
  }
  $output .= '(' . $products->post_count . ')';
  $output .= '</div>';

  // return output
  return $output;
}
add_shortcode( 'category_product_count', 'category_product_count_shortcode' );

