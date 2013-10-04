<?php

namespace B0334315817D4E03A27BEED307E417C8;

if(!class_exists('B0334315817D4E03A27BEED307E417C8\ArrayHelper')) {
  
  class ArrayHelper {
    
    /*
     * Description: Removes the specified key from an array, returning the associated value
     *
     * Params:
     *   arr (required): the source array
     *   key (required): the key to remove
     *
     * Returns: The value stored under 'key', or null if the key does not exist
     */
    public static function remove(&$arr, $key) {
      $value = null;
      
      if (array_key_exists($key, $arr)) {
        $value = $arr[$key];
        unset($arr[$key]);
      }
      
      return $value;
    }
  }
}

?>