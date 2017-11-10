<?php

  echo "id:;:";

// Shoutcast
function getID($radioip,$radioport,$postfix = "GET /7.html HTTP/1.1\nUser-Agent:Mozilla\n\n")
  {
    $open = fsockopen($radioip,$radioport,$errno,$errstr,'.5');
    if ($open) {
    fputs($open,$postfix);
    stream_set_timeout($open,'1');
    $read = fread($open,255);
    $exploded = explode(",",$read);
    if($exploded[6] == '' || $exploded[6] == '</body></html>')
    { $text = 'streaming'; } else { $text = $exploded[6]; }
    $id = str_replace("</body></html>","",$text);
    } else { return false; }
    fclose($open);
    return $id;
  }

  $radioip = "93.100.61.75";
  $radioport = "8000";
    echo getID($radioip,$radioport);
    echo ":;:";
  $radioip = "67.212.165.106";
  $radioport = "8144";
    echo getID($radioip,$radioport);
    echo ":;:";
  $radioip = "93.100.61.75";
  $radioport = "8024";
    echo getID($radioip,$radioport);
    echo ":;:";
// // outdated:
//  $radioip = "173.236.30.162";
//  $radioport = "8022";
//    echo getID($radioip,$radioport);
// // outdated:
//  $radioip = "91.237.213.34";
//  $radioport = "8008";
//    echo getID($radioip,$radioport).":;:";
  $radioip = "79.120.39.202";
  $radioport = "9009";
    echo getID($radioip,$radioport);
    echo ":;:";

// Icecast
// https://stackoverflow.com/a/17109654
function getMp3StreamTitle($streamingUrl, $interval, $offset = 0, $headers = true)
    {
        $needle = 'StreamTitle=';
        $ua = 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/27.0.1453.110 Safari/537.36';

        $opts = [
            'http' => [
                'method' => 'GET',
                'header' => 'Icy-MetaData: 1',
                'user_agent' => $ua
            ]
        ];

        if (($headers = get_headers($streamingUrl)))
            foreach ($headers as $h)
                if (strpos(strtolower($h), 'icy-metaint') !== false && ($interval = explode(':', $h)[1]))
                    break;

        $context = stream_context_create($opts);

        if ($stream = fopen($streamingUrl, 'r', false, $context))
        {
            $buffer = stream_get_contents($stream, $interval, $offset);
            fclose($stream);

            if (strpos($buffer, $needle) !== false)
            {
                $title = explode($needle, $buffer)[1];
                return substr($title, 1, strpos($title, ';') - 2);
            }
            else
                return getMp3StreamTitle($streamingUrl, $interval, $offset + $interval, false);
        }
        else
            throw new Exception("Unable to open stream [{$streamingUrl}]");
    }

    echo getMp3StreamTitle('http://audio-online.net:8015/live', 19200);
    echo ":;:";

    $radioip = "sonus.fm";
    $radioport = "8000";
    $postfix = "GET /7.html?sid=3 HTTP/1.1\nUser-Agent:Mozilla\n\n";
    echo getID($radioip,$radioport,$postfix);
    echo ":;:";

    echo getMp3StreamTitle('http://pub2.diforfree.org:8000/di_dubtechno_hi', 19200);
    echo ":;:";
    echo ":;:";

?>
