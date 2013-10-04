<?php

class WME_OutputHelper {
  
  static function echo_if_set($variable) {
    if(isset($variable)) {
      echo $variable;
    }
  }
}

?>