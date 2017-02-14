#!/bin/bash

spr="$1"
timeout=$2
count=$3
path='/hosting/monitorfs'
#date=`date +%s`

if [ ! -f "$path/$spr.sqlite" ]; then
 echo "create table spr_stats(unixdate DATETIME, spr_name varchar(10), timeout smallint, count smallint);" | sqlite3 "$path/$spr".sqlite
 echo "CREATE INDEX idx_spr_stats1 ON spr_stats(unixdate,spr_name);" | sqlite3 "$path/$spr".sqlite
fi

echo "INSERT INTO spr_stats(unixdate,spr_name,timeout,count) VALUES(datetime('now','localtime'),'$spr',$timeout,$count);" | sqlite3 $path/$spr.sqlite

