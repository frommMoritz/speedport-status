<?php
namespace frommMoritz\speedportStatus\commands;

use function frommMoritz\speedportStatus\consoleArguments\isGiven;
use function frommMoritz\speedportStatus\consoleArguments\getShellArg;

/**
 * Get the help commands content
 *
 * @return void
 */
function help() {
    $response  = '';
    $response .= 'This is a simple script to get the speed information of the telekom speedport and convert it to csv';
    $response .= "\n\r\n\r";
    $response .= 'Usage: ./readStatus.php ';
    $response .= '[-d]';
    $response .= '[-v]';
    $response .= '[-h]';
    $response .= '[-s]';
    $response .= '[-p]';
    $response .= '[-w]';
    $response .= '[-t]';
    $response .= '[-l]';
    $response .= '[--delimiter]';
    $response .= '[--showHeaders]';
    $response .= "\n\r\n\r";
    $response .= "-d, --debug\t\tEnable Debug output\n\r\t\t\tNot implemented yet\n";
    $response .= "-v, --verbose\t\tEnable verbose output\n";
    $response .= "-h, --help \t\tShow this help output and exit\n";
    $response .= "-s, --speedport \tDefine the hostname (the speedport's ip) to be used\n\r\t\t\tDefault: 192.168.2.1\n";
    $response .= "-p, --path \t\tDefint the full path to the status.json to be used\n\r\t\t\tDefault: /data/Status.json\n";
    $response .= "-w, --write \t\tRelative path to the results file\n\r\t\t\twill be created if not existing, dump to stdout if not given\n\r\t\t\tDefault: measurments.csv\n";
    $response .= "-t, --timeout \t\tTimeout in seconds for the curl request\n\r\t\t\tDefault: 30\n";
    $response .= "-l, --license \t\tDump the license\n";
    $response .= "--delimiter \t\tThe CSV delimiter to use\n\r\t\t\tDefault: ,\n";
    $response .= "--showHeaders \t\tDump the Headers for the CSV file\n\r\t\t\tDefault: 30\n";
    $response .= "\n\r";
    $response .= "(c) Moritz Fromm <git@moritz-fromm.de> 2019, Released unter the MIT License";
    $response .= "\n\r";
    return $response;
}

/**
 * Return the content of the license
 *
 * @return string
 */
function license() :string {
    $licenseFile = __DIR__ . '/LICENSE';
    return file_get_contents($licenseFile);
}
/**
 * Return the Headers for the CSV file
 *
 * @return string
 */
function headers() :string {
    return(implode(getDelimiter(), ['timestamp', 'downstream', 'upstream']) . "\n\r");
}

function getSpeedport() :string {
    if (isGiven(['s', 'speedport'])) {
        return getShellArg(['s', 'speedport']);
    }
    return '192.168.2.1';
}

function getPath() :string {
    if (isGiven(['p', 'path'])) {
        return getShellArg(['p', 'path']);
    }
    return '/data/Status.json';
}

function getWrite() :?string {
    $output = null;
    if (isGiven(['w', 'write'])) {
        $output = getShellArg(['w', 'write']);
    }
    return $output;
}

function getDelimiter() :?string {
    if (isGiven(['delimiter'])) {
        return getShellArg('delimiter');
    }
    return ',';
}

function getTimeout() :int {
    if (isGiven(['t', 'timeout'])) {
        return (int) getShellArg(['t', 'timeout']);
    }
    return 30;
}

function getFullUrl() :string {
    return getSpeedport() . '/' . getPath();
}
