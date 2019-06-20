<?php

namespace frommMoritz\speedportStatus\io;

use function frommMoritz\speedportStatus\commands\getWrite;
use function frommMoritz\speedportStatus\commands\getDelimiter;

/**
 * Write data array to csv file and return it as a string
 * This is used so we can take advantage of the built in functions (encoding etc.)
 *
 * @param array $data
 * @param string $delimiter
 * @return string
 */
function str_gencsv($data, $delimiter = ',') :string {
    $fh = fopen('php://temp', 'r+');
    $isArr = \is_array($data[0]);
    if ($isArr) {
        foreach($data as $dat) {
            fputcsv($fh, $dat, $delimiter);
        }
    } else {
        fputcsv($fh, $data, $delimiter);
    }
    rewind($fh);

    $csv = '';
    while (($line = fgets($fh)) !== false) {
        $csv .= trim($line) . "\n\r";
    }
    return $csv;
}

/**
 * Convert data to csv and write it to the specified output
 *
 * @param array $data
 * @return void
 */
function writeAsCsv(array $data) {
    $output = getWrite();
    $delimiter = getDelimiter();
    if (debug) {
        var_dump($data);
        var_dump($delimiter);
        var_dump($output);
    }
    if ($output === null || strtolower($output) === 'stdout') {
        echo str_gencsv($data, getDelimiter());
        return;
    }
    $fh = fopen($output, 'a');
    if (is_array($data[0])) {
        foreach($data as $dat) {
            fputcsv($fh, $dat, $delimiter);
        }
    } else {
        fputcsv($fh, $data, $delimiter);
    }
}
