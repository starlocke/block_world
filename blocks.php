<?php
include('world.php');
$cmd = null;

$world = null;
while($cmd != 'quit'){
  $cmd = trim(readline("> "));
  if($world === null){
    $size = intval($cmd);
    $world = new World($size);
  }
  else {
    $tokens = explode(' ', $cmd);

    if(count($tokens) < 4){
      continue;
    }

    $cmd = $tokens[0];
    $a = $tokens[1];
    $subcmd = $tokens[2];
    $b = $tokens[3];

    switch($cmd){
      case 'move':
        switch($subcmd) {
          case 'onto':
            $world->move_onto($a,$b);
            break;
          case 'over':
            $world->move_over($a,$b);
            break;
        }
        break;
      case 'pile':
        switch($subcmd){
          case 'onto':
            $world->pile_onto($a,$b);
            break;
          case 'over':
            $world->pile_over($a,$b);
            break;
        }
        break;
    }
  }
}
if($world != null){
  echo $world->render();
}
