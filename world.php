<?php

class World {
  var $col;
  function __construct($size) {
    if($size < 0 || $size > 25) {
      throw new Exception("Bad world size.");
    }
    $this->col = [];
    for($i = 0; $i < $size; ++$i){
      $this->col[$i] = [$i];
    }
  }

  function render(){
    $result = '';
    for($i = 0; $i < count($this->col); ++$i){
      $result .= "$i: ";
      $result .= implode(' ', $this->col[$i]);
      $result .= "\n";
    }
    return $result;
  }

  function find($f){
    foreach($this->col as $k => $c){
      if(in_array($f, $c)){
        return $k;
      }
    }
  }

  function reinit($col, $f){
    $pos = array_search($f, $this->col[$col]);
    $orphans = array_splice($this->col[$col], $pos);
    foreach($orphans as $b){
      $this->col[$b][] = $b;
    }
  }

  function validate_action($a, $b, $subcmd){
    if($a == $b){
      return false;
    }
    if($a < 0 || $a > count($this->col)-1){
      return false;
    }
    if($b < 0 || $b > count($this->col)-1){
      return false;
    }
    if($subcmd != 'onto' && $subcmd != 'over'){
      return false;
    }
    return true;
  }
  function validation_columns($a, $b){
    if($a == $b){
      return false;
    }
    return true;
  }

  function move_onto($a,$b){
    $this->move($a,$b,'onto');
  }
  function move_over($a,$b){
    $this->move($a,$b,'over');
  }
  function move($a,$b,$subcmd){
    if($this->validate_action($a,$b,$subcmd) == false){
      return;
    }
    $col_for_a = $this->find($a);
    $col_for_b = $this->find($b);
    if($this->validation_columns($col_for_a,$col_for_b) == false){
      return;
    }

    $this->reinit($col_for_a, $a);
    if($subcmd == 'onto'){
      $this->reinit($col_for_b, $b);
    }
    array_pop($this->col[$col_for_a]);
    $this->col[$col_for_b][] = $a;
  }
  function pile_onto($a,$b){
    $this->pile($a,$b,'onto');
  }
  function pile_over($a,$b){
    $this->pile($a,$b,'over');
  }
  function pile($a,$b,$subcmd){
    if($this->validate_action($a,$b,$subcmd) == false){
      return;
    }
    $col_for_a = $this->find($a);
    $col_for_b = $this->find($b);
    if($this->validation_columns($col_for_a,$col_for_b) == false){
      return;
    }

    $pos = array_search($a, $this->col[$col_for_a]);
    $a_stack = array_splice($this->col[$col_for_a], $pos);
    if($subcmd == 'onto'){
      $this->reinit($col_for_b, $b);
    }
    $this->col[$col_for_b] = array_merge($this->col[$col_for_b], $a_stack);
  }
}
