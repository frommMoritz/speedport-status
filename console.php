<?php

namespace frommMoritz\speedportStatus\consoleArguments;

use function frommMoritz\speedportStatus\commands\help;
use function frommMoritz\speedportStatus\commands\license;
use function frommMoritz\speedportStatus\commands\headers;

// This file handles the cli arguments
$shortoptions  = '';
$shortoptions .= 's::';  // short for --speedport
$shortoptions .= 'p::';  // short for --path
$shortoptions .= 'w::';  // short for --write
$shortoptions .= 't::';  // short for --write
$shortoptions .= 'h';    // Short for --help
$shortoptions .= 'l';    // Short for --license
$shortoptions .= 'd';    // Short for --debug
$shortoptions .= 'v';    // Short for --verbose

$longoptions = [
    'speedport::',  // Define the hostname (the speedport's ip) to be used, default: 192.168.2.1
    'path::',       // Defint the full path to the status.json to be used
    'write::',      // Relative path to the results file, will be crated if not existing, stdout will be used if not given
    'delimiter::',  // The CSV delimiter
    'help',         // Show all options
    'timeout',      // Enable debug output
    'verbose',      // Show the LICENSE
    'debug',        // Timeout for the curl request
    'license',      // Show the LICENSE
    'showHeaders',  // Show the LICENSE
];
/**
 * Check if a given shell argument is given
 *
 * @param array $arguments The Arguments to check agains
 * @param boolean $matchAll If all arguments should be matched, if false only one argument must match to return true
 * @param array|null $shortoptions
 * @param array|null $longoptions
 * @return boolean
 */
function isGiven(array $arguments, $matchAll = false, ?array $shortoptions = null, ?array $longoptions = null) :bool {
    if ($shortoptions === null) {
        global $shortoptions;
    }

    if ($longoptions === null) {
        global $longoptions;
    }

    if (\count($arguments) < 0) {
        return false;
    }

    $shellArgs = getopt($shortoptions, $longoptions);
    if ($matchAll) {
        // Return false if one argument is not given
        foreach ($arguments as $argument) {
            if (!\array_key_exists($argument, $shellArgs)) {
                return false;
            }
        }

        return true;
    }
    // Return true as soon as one argument is given
    foreach ($arguments as $argument) {
        if (\array_key_exists($argument, $shellArgs)) {
            return true;
        }
    }
    
    return false;
}

function getShellArg($argument, ?array $shortoptions = null, ?array $longoptions = null) {
    if ($shortoptions === null) {
        global $shortoptions;
    }

    if ($longoptions === null) {
        global $longoptions;
    }

    $shellArgs = getopt($shortoptions, $longoptions);
    if (is_string($argument))
    {
        return $shellArgs[$argument];
    }
    foreach ($argument as $arg) {
        if (array_key_exists($arg, $shellArgs)) {
            return $shellArgs[$arg];
        }
    }

    return null;
}

if (isGiven(['d', 'debug'])) {
    define('debug', true, true);
} else {
    define('debug', false, true);
}

if (isGiven(['v', 'verbose'])) {
    define('verbose', true, true);
} else {
    define('verbose', false, true);
}

if (isGiven(['h', 'help'])) {
    echo help();
    exit(0);
}

if (isGiven(['l', 'license'], false)) {
    echo license();
    exit(0);
}

if (isGiven(['showHeaders'])) {
    echo headers();
    exit(0);
}
