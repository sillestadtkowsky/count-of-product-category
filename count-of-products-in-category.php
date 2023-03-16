<?php
/**
* Plugin Name: Count of Products in Category
* Plugin URI: https://plugin.wp.osowsky-webdesign.de/count-of-products
* Description: This plugin provides a shortcode that displays the count of products in a product category of woocommerce. You can use the shortcode on every page or post. IMPORTANT! This is clearly NOT an official plugin from Woocommerce.
* Version: 1.0.5
* Requires at least: 5.8.0
* Requires PHP:      8.0
* Author: Silvio Osowsky
* License: GPLv3 or later
* License URI: https://www.gnu.org/licenses/gpl-3.0.html
* Author URI: https://osowsky-webdesign.de/
*/

function so_category_product_count_shortcode( $atts ) {
    // shortcode attributes
    $atts = shortcode_atts( array(
        'title' => '',
        'show_category_name' => true,
    ), $atts, 'category_product_count' );
  
    // get category id
    $category_id = get_term_by( 'slug', wp_strip_all_tags($atts['title']), 'product_cat' )->term_id;
  
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
    if ( wp_strip_all_tags($atts['show_category_name']) == 'true' ) {
        $output .= get_term_by('slug', $atts['title'], 'product_cat')->name . ' ';
    }
    $output .= '(' . $products->post_count . ')';
    $output .= '</div>';
  
    // return output
    return $output;
  }
  add_shortcode( 'so_cp_count', 'so_category_product_count_shortcode' );