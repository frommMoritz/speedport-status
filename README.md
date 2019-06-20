# Speedport Status


## What is it

This (not so simple anymore) scripte takes the DSL up/downloak speed as reported by the telekom speedport and outputs it as csv.

## What is it not

This script does not perform any sort of speedtest. It is only the speed reported by the speedport and not meassured in any way.

## How do I use it / Setup

Setup is farely straingt foward.

```bash
git clone https://github.com/frommMoritz/speedport-status.git # You could aso use ssh
git clone git@github.com:frommMoritz/speedport-status.git

cd speedport-status
chmod +x readStatus.php
readStatus.php --showHeaders > ~/measurments.csv
readStatus.php -w=~/measurments.csv

# Verify everything is ok
cat ~/measurments.csv
```

This script is intended to be deployed on for example a raspberry pi and executed one per time x to get data over a long period of time not only for one single measurement.

To execute this script once a minute, a cronjob can be added like this:

```bash
$ crontab -e

# Add this at the bottom of the crobtab file
* * * * * /path/to/readStatus.php -w=~/measurments.csv
```

For documentation of the cli interface, look at the help output.

```
./readStatus.php -h
This is a simple script to get the speed information of the telekom speedport and convert it to csv

Usage: ./readStatus.php [-d][-v][-h][-s][-p][-w][-t][-l][--delimiter][--showHeaders]

-d, --debug             Enable Debug output
                        Not implemented yet
-v, --verbose           Enable verbose output
-h, --help              Show this help output and exit
-s, --speedport         Define the hostname (the speedport's ip) to be used
                        Default: 192.168.2.1
-p, --path              Defint the full path to the status.json to be used
                        Default: /data/Status.json
-w, --write             Relative path to the results file
                        will be created if not existing, dump to stdout if not given
                        Default: measurments.csv
-t, --timeout           Timeout in seconds for the curl request
                        Default: 30
-l, --license           Dump the license
--delimiter             The CSV delimiter to use
                        Default: ,
--showHeaders           Dump the Headers for the CSV file
                        Default: 30

(c) Moritz Fromm <git@moritz-fromm.de> 2019, Released unter the MIT License
```
