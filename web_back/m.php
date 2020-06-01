<?php

echo preg_match_all("{'[a-zA-Z0-9_]*'[,]?}i", "{'answer1', 'answer2'}");
echo preg_match_all("{'answer1', 'answer2'}i", "{'answer1', 'answer2'}");

?>
