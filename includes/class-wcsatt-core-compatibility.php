<?php
/**
 * Functions related to core back-compatibility.
 *
 * @class  WCS_ATT_Core_Compatibility
 * @since  1.0.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class WCS_ATT_Core_Compatibility {

	/**
	 * Back-compat wrapper for getting CRUD object props directly.
	 *
	 * @since  1.1.3
	 *
	 * @param  WC_Product  $product
	 * @return string
	 */
	public static function get_price_html_from_text( $product ) {
		if ( self::is_wc_version_gte_2_7() ) {
			$value = wc_get_price_html_from_text();
		} else {
			$value = $product->get_price_html_from_text();
		}
		return $value;
	}

	/**
	 * Back-compat wrapper for 'get_id'.
	 *
	 * @since  1.1.3
	 *
	 * @param  WC_Product  $product
	 * @return mixed
	 */
	public static function get_id( $product ) {
		if ( self::is_wc_version_gte_2_7() ) {
			$id = $product->get_id();
		} else {
			$id = $product->is_type( 'variation' ) ? absint( $product->variation_id ) : absint( $product->id );
		}
		return $id;
	}

	/**
	 * Back-compat wrapper for getting CRUD object props directly.
	 *
	 * @since  1.1.3
	 *
	 * @param  object  $obj
	 * @param  string  $name
	 * @return mixed
	 */
	public static function get_prop( $obj, $name ) {
		if ( self::is_wc_version_gte_2_7() ) {
			$get_fn = 'get_' . $name;
			$value = is_callable( array( $obj, $get_fn ) ) ? $obj->$get_fn( 'edit' ) : null;
		} else {
			$value = $obj->$name;
		}
		return $value;
	}

	/**
	 * Back-compat wrapper for setting CRUD object props directly.
	 *
	 * @since  1.1.3
	 *
	 * @param  object  $obj
	 * @param  string  $name
	 * @param  mixed   $value
	 * @return void
	 */
	public static function set_prop( $obj, $name, $value ) {
		if ( self::is_wc_version_gte_2_7() ) {
			$set_fn = 'set_' . $name;
			if ( is_callable( array( $obj, $set_fn ) ) ) {
				$obj->$set_fn( $value );
			} else {
				$obj->$name = $value;
			}
		} else {
			$obj->$name = $value;
		}
	}

	/**
	 * Display a WooCommerce help tip.
	 *
	 * @since  1.0.4
	 *
	 * @param  string $tip
	 * @return string
	 */
	public static function wc_help_tip( $tip ) {
		if ( self::is_wc_version_gte_2_5() ) {
			return wc_help_tip( $tip );
		} else {
			return '<img class="help_tip woocommerce-help-tip" data-tip="' . $tip . '" src="' . WC()->plugin_url() . '/assets/images/help.png" />';
		}
	}

	/**
	 * Helper method to get the version of the currently installed WooCommerce
	 *
	 * @since  1.0.0
	 * @return string woocommerce version number or null
	 */
	private static function get_wc_version() {
		return defined( 'WC_VERSION' ) && WC_VERSION ? WC_VERSION : null;
	}

	/**
	 * Returns true if the installed version of WooCommerce is 2.7 or greater.
	 *
	 * @since  1.1.2
	 * @return boolean
	 */
	public static function is_wc_version_gte_2_7() {
		return self::get_wc_version() && version_compare( self::get_wc_version(), '2.7', '>=' );
	}

	/**
	 * Returns true if the installed version of WooCommerce is 2.6 or greater.
	 *
	 * @since  1.0.4
	 * @return boolean
	 */
	public static function is_wc_version_gte_2_6() {
		return self::get_wc_version() && version_compare( self::get_wc_version(), '2.6', '>=' );
	}

	/**
	 * Returns true if the installed version of WooCommerce is 2.5 or greater.
	 *
	 * @since  1.0.4
	 * @return boolean
	 */
	public static function is_wc_version_gte_2_5() {
		return self::get_wc_version() && version_compare( self::get_wc_version(), '2.5', '>=' );
	}

	/**
	 * Returns true if the installed version of WooCommerce is 2.4 or greater.
	 *
	 * @since  1.0.0
	 * @return boolean
	 */
	public static function is_wc_version_gte_2_4() {
		return self::get_wc_version() && version_compare( self::get_wc_version(), '2.4', '>=' );
	}

	/**
	 * Returns true if the installed version of WooCommerce is 2.3 or greater.
	 *
	 * @since  1.0.0
	 * @return boolean
	 */
	public static function is_wc_version_gte_2_3() {
		return self::get_wc_version() && version_compare( self::get_wc_version(), '2.3', '>=' );
	}

	/**
	 * Returns true if the installed version of WooCommerce is 2.2 or greater.
	 *
	 * @since  1.0.0
	 * @return boolean
	 */
	public static function is_wc_version_gte_2_2() {
		return self::get_wc_version() && version_compare( self::get_wc_version(), '2.2', '>=' );
	}

	/**
	 * Returns true if the installed version of WooCommerce is less than 2.2.
	 *
	 * @since  1.0.0
	 * @return boolean
	 */
	public static function is_wc_version_lt_2_2() {
		return self::get_wc_version() && version_compare( self::get_wc_version(), '2.2', '<' );
	}

	/**
	 * Returns true if the installed version of WooCommerce is greater than $version.
	 *
	 * @since  1.0.0
	 * @param  string $version
	 * @return boolean
	 */
	public static function is_wc_version_gt( $version ) {
		return self::get_wc_version() && version_compare( self::get_wc_version(), $version, '>' );
	}
}
