#!/bin/bash

spr="$1"
path="/hosting/monitorfs"

#echo "select * from spr_stats;" | sqlite3 $path/$spr.sqlite | wc -l

echo "DELETE FROM spr_stats WHERE unixdate < datetime('now','-12 month','localtime') AND spr_name='$spr';" | sqlite3 $path/$spr.sqlite

#echo "select * from spr_stats;" | sqlite3  $path/$spr.sqlite | wc -l
