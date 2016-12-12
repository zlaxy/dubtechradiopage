<?php

  echo "id:;:";

function getID($radioip,$radioport)
  {
    $open = fsockopen($radioip,$radioport,$errno,$errstr,'.5');
    if ($open) {
	fputs($open,"GET /7.html HTTP/1.1\nUser-Agent:Mozilla\n\n");
	stream_set_timeout($open,'1');
	$read = fread($open,255);
	$exploded = explode(",",$read);
	if(exploded[6] == '' || $exploded[6] == '</body></html>')
	{ $text = 'streaming'; } else { $text = $exploded[6]; }
	$id = str_replace("</body></html>","",$text);
    } else { return false; }
	fclose($open);
	return $id;
  }

  $radioip = "93.100.61.75";
  $radioport = "8000";
    echo getID($radioip,$radioport).":;:";
  $radioip = "67.212.165.106";
  $radioport = "8144";
    echo getID($radioip,$radioport).":;:";
  $radioip = "173.236.30.162";
  $radioport = "8022";
    echo getID($radioip,$radioport).":;:";
  $radioip = "91.237.213.34";
  $radioport = "8008";
    echo getID($radioip,$radioport).":;:";
  $radioip = "79.120.39.202";
  $radioport = "9009";
    echo getID($radioip,$radioport);

?>