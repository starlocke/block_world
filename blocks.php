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

    $world->take_action($cmd, $a, $subcmd, $b);
  }
}
if($world != null){
  echo $world->render();
}
