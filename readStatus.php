#!/usr/bin/php
<?php

// -------------------------------------------------------------------
// Configuration params
define('statusUrl', 'http://192.168.2.1/data/Status.json', true);
define('downstreamKey', 23, true);
define('upstreamKey', 24, true);
define('resultsFile', 'measurments.csv', true); // Relative to script
// -------------------------------------------------------------------

define('absoluteResultsFile', dirname(__FILE__) . '/' . resultsFile, true);


$ch = curl_init(statusUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FORBID_REUSE, true);
curl_setopt($ch, CURLOPT_FRESH_CONNECT, true);

$response = curl_exec($ch);
curl_close($ch);

$response = json_decode($response);
$downstream = $response[downstreamKey]->varvalue;
$upstream = $response[upstreamKey]->varvalue;

$createHeaders = !file_exists(absoluteResultsFile);

$fh = fopen(absoluteResultsFile, 'a');

if ($createHeaders)
{
    fputcsv($fh, ['timestamp', 'dsl_downstream', 'dsl_upstream']);
}

fputcsv($fh, [date('c'), $downstream, $upstream]);

fclose($fh);
