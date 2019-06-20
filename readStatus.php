#!/usr/bin/php
<?php
use function frommMoritz\speedportStatus\io\writeAsCsv;
use function frommMoritz\speedportStatus\commands\getFullUrl;
use function frommMoritz\speedportStatus\commands\getTimeout;

define('downstreamKey', 23, true);
define('upstreamKey', 24, true);

require 'commands.php';
require 'console.php';
require 'io.php';

$url = getFullUrl();

if (debug) {
    var_dump($url);
}

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FORBID_REUSE, true);
curl_setopt($ch, CURLOPT_FRESH_CONNECT, true);
curl_setopt($ch, CURLOPT_TIMEOUT, getTimeout());
$response = curl_exec($ch);
curl_close($ch);
if (debug) {
    var_dump($response);
}
$response = json_decode($response);
if (debug) {
    var_dump($response);
}
$downstream = $response[downstreamKey]->varvalue;
$upstream = $response[upstreamKey]->varvalue;
$data = [date('c'), $downstream, $upstream];
if (debug) {
    var_dump($data);
    // fadsfj
}
writeAsCsv($data);
exit(0);
