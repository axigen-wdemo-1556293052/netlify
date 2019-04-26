<?php

include('./smutbase.php');

echo('{"pvp.battle.start": ');
echo(post($url, $headers, $fight_data1));
echo(', "pvp.battle.fight": ');
echo(post($url, $headers, $fight_data2));
echo('}');
