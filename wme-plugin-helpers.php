<?php

namespace B0334315817D4E03A27BEED307E417C8;

class WME_OutputHelper {
  
  static function echo_if_set($variable) {
    if(isset($variable)) {
      echo $variable;
    }
  }
}

?>