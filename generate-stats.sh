#!/bin/bash


#echo "DELETE from spr_stats;" | sqlite3 teststats.sqlite

echo "DROP table spr_stats;" | sqlite3 teststats.sqlite

#echo "create table spr_stats(unixdate varchar(10), spr_name varchar(10), timeout smallint, count smallint);" | sqlite3 teststats.sqlite

echo "create table spr_stats(unixdate DATETIME, spr_name varchar(10), timeout smallint, count smallint);" | sqlite3 teststats.sqlite

#echo "create table spr_stats(unixdate int, spr_name varchar(10), timeout smallint, count smallint);" | sqlite3 teststats.sqlite
echo "CREATE INDEX idx_spr_stats1 ON spr_stats(unixdate,spr_name);" | sqlite3 teststats.sqlite

time=0

spr="P62G60"
date=`date +%s`
step=300
#generatecount=289
#generatecount=8641
generatecount=105120




for (( count=1; count<$generatecount; count++ ))
do
echo "count=$count"
#echo "minustime=$time"
#echo "date=$date"

randtimeout=`shuf -i 0-200 -n 1`
randcount=`shuf -i 1000-4000 -n 1`

echo "INSERT INTO spr_stats(unixdate,spr_name,timeout,count) VALUES(datetime('now','-$time minutes','localtime'),'$spr',$randtimeout,$randcount);" | sqlite3 teststats.sqlite
let "time = time + 5"

#echo "INSERT INTO spr_stats(unixdate,spr_name,timeout,count) VALUES($date,'P62G60',$RANDOM,$RANDOM);" | sqlite3 teststats.sqlite
#let "date = date - step"

done

echo "select * from spr_stats;" | sqlite3 teststats.sqlite | wc -l
