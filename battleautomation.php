<?php

$RARITY_TIMES = array(2700, 10800, 43200, 172800);
$CHEST_SAFETY_TIME = 60;
$CHEST_SLOTS = 4;

include('./smutbase.php');

$modified_chests = false;
$file = './chests.json';
$chests = json_decode(file_get_contents($file), true);
$chests_count = sizeof($chests);
$fight = null;

for($x=0; $x<$chests_count; $x++) {
  $chest = $chests[$x];
  $index = $chest['rarity'] - 1;
  if(time() - $chest['time_added'] > $RARITY_TIMES[$index]) {
    echo("Opening chest: " . $chest['id'] + "\n");
    $res = json_decode(open_chest($chest['id']), true);
    if($res['result'] == "error") {
      echo("WARNING: Chest opening returned error, chest time may be incorrect!\n");
    } else {
      unset($chests[$x]);
      $modified_chests = true;
    }
  }
}

$chests = array_values($chests);

while(sizeof($chests) < $CHEST_SLOTS) {
  do
  {
    echo("Fighting\n");
    $fight = json_decode(fight(), true);
    sleep(1);
  } while ($fight['response']['result']['result'] != "won");

  if($fight['response']['chest'] == NULL) {
    echo("\nWARNING: Won fight but got no chest, database might be corrupt!\n\n");
    break;
  } else {
    $newchest = [
      'id' => $fight['response']['chest']['id'],
      'rarity' => $fight['response']['chest']['rarity'],
      'time_added' => time() + $CHEST_SAFETY_TIME
    ];
    echo("Added chest: " . $newchest['id'] + "\n");
    array_push($chests, $newchest);
    $modified_chests = true;
  }
}


if($modified_chests) {
  file_put_contents($file, json_encode($chests));
}

var_dump($chests);
