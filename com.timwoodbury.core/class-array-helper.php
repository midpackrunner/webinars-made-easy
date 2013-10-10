<?php

namespace B0334315817D4E03A27BEED307E417C8;

if( ! class_exists( 'B0334315817D4E03A27BEED307E417C8\Array_Helper' ) ) {

	class Array_Helper {

		/**
		 * Remove the specified key from an array, returning the associated value.
		 *
		 * @since 1.0
		 *
		 * @param array $arr The source array.
		 * @param variable $key The key to remove.
		 *
		 * @return variable The value stored under 'key', or null if the key does not exist.
		 */
		public static function remove( &$arr, $key ) {
			$value = null;

			if ( isset( $arr[ $key ] ) || $arr[ $key ] == null ) {
				$value = $arr[ $key ];
				unset( $arr[ $key ] );
			}

			return $value;
		}
	}

}