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

  function reinit(&$block){
    $col = $block['col'];
    $f = $block['val'];
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
    if($a['col'] == $b['col']){
      return false;
    }
    return true;
  }

  function block($f){
    return ['val'=>$f, 'col'=>$this->find($f)];
  }

  function take_action($cmd, $a, $subcmd, $b){
    if($this->validate_action($a,$b,$subcmd) == false){
      return;
    }
    $block_a = $this->block($a);
    $block_b = $this->block($b);
    if($this->validation_columns($block_a,$block_b) == false){
      return;
    }

    switch($cmd){
      case 'move':
        $this->move($block_a,$block_b,$subcmd);
        break;
      case 'pile':
        $this->pile($block_a,$block_b,$subcmd);
        break;
    }
  }

  protected function move(&$block_a, &$block_b, $subcmd)
  {
    $this->reinit($block_a);
    if($subcmd == 'onto'){
      $this->reinit($block_b);
    }
    $this->shift($block_a, $block_b);
  }
  protected function pile(&$block_a, &$block_b, $subcmd)
  {
    if($subcmd == 'onto') {
      $this->reinit($block_b);
    }
    $this->shift($block_a, $block_b);
  }
  protected function shift(&$block_a, &$block_b)
  {
    $a = $block_a['val'];
    $col_for_a = $block_a['col'];
    $b = $block_b['val'];
    $col_for_b = $block_b['col'];

    $pos = array_search($a, $this->col[$col_for_a]);
    $a_stack = array_splice($this->col[$col_for_a], $pos);
    $this->col[$col_for_b] = array_merge($this->col[$col_for_b], $a_stack);
  }
}
