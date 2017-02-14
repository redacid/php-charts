#!/bin/bash



randtimeout=`shuf -i 0-200 -n 1`
randcount=`shuf -i 1000-4000 -n 1`
/hosting/monitorfs/add-stats-record.sh P62G60 $randtimeout $randcount
/hosting/monitorfs/delete-old-stats.sh P62G60

randtimeout=`shuf -i 0-200 -n 1`
randcount=`shuf -i 1000-4000 -n 1`
/hosting/monitorfs/add-stats-record.sh P62G61 $randtimeout $randcount
/hosting/monitorfs/delete-old-stats.sh P62G61

randtimeout=`shuf -i 0-200 -n 1`
randcount=`shuf -i 1000-4000 -n 1`
/hosting/monitorfs/add-stats-record.sh P62G81 $randtimeout $randcount
/hosting/monitorfs/delete-old-stats.sh P62G81



#echo "select * from spr_stats;" | sqlite3 teststats.sqlite | wc -l
