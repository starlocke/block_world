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
        $world->move($a,$b,$subcmd);
        break;
      case 'pile':
        $world->pile($a,$b,$subcmd);
        break;
    }
  }
}
if($world != null){
  echo $world->render();
}
