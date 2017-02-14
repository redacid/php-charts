<?php
header("content-type: application/json");
$date = date_create();

$spravka = strtoupper($_GET['spravka']);
$rn="\r\n";
//$rn="";
$callback=$_GET['callback'];
$period=$_GET['period'];
$dayrows=290;
$dataline=$_GET['dataline'];

   class MyDB extends SQLite3
   {
      function __construct()
      {
         $this->open($GLOBALS['spravka'].'.sqlite');
      }
   }
   $db = new MyDB();
   if(!$db){
      echo $db->lastErrorMsg();
   } else {
      //echo "Opened database successfully\n";
   }

 //  $sql =<<<EOF
 //     SELECT * from spr_stats;
//EOF;

switch ($period) {
    case "1d":
 	$minusdays="-1 day";
        break;
    case "2d":
        $minusdays="-2 day";
        break;
    case "1w":
        $minusdays="-7 day";
        break;
    case "1m":
        $minusdays="-1 month";
        break;
    case "1y":
        $minusdays="-1 year";
        break;
    default:
       $minusdays="-1 day";
}



$sql = "select * from spr_stats 
	where unixdate between datetime('now','".$minusdays."','localtime') and datetime('now','localtime') and spr_name = '$spravka';";

#$sql = "select strftime('%s',unixdate) as unixdate,spr_name,timeout,count from spr_stats where unixdate between datetime('now','-1 day','localtime') and datetime('now','localtime');";

echo $callback."([".$rn;

   $ret = $db->query($sql);

   while($row = $ret->fetchArray(SQLITE3_ASSOC) ){
      
      #echo "unixdate = ". $row['unixdate'] . $rn;
      #echo "spr_name = ". $row['spr_name'] .$rn;
      #echo "timeout = ". $row['timeout'] .$rn;
      #echo "count =  ".$row['count'] .$rn;
      #echo "date =  ".date_format(strtotime($row['unixdate']), 'Y,n,j,G,i').$rn;
      #echo "date2 =  ".date('Y,n,j,G,i', strtotime($row['unixdate'])).$rn;
	#date_time_set($date, $row['unixdate']);
	#$date->modify('-1 month');

#print_r(date_parse($row['unixdate']));

	$datearr=date_parse($row['unixdate']);

	$datetoprint="[Date.UTC($datearr[year],$datearr[month]-1,$datearr[day],$datearr[hour],$datearr[minute])";


        switch ($dataline) {
                case "timeout":
                #echo date_format($row['unixdate'], '\[\D\a\t\e\.\U\T\C\(Y,n,j,G,i)').",".$row['timeout']."],".$rn;
		#echo date('\[\D\a\t\e\.\U\T\C\(Y,n,j,G,i)',strtotime($row['unixdate'])).",".$row['timeout']."],".$rn;
		#echo date('\[\D\a\t\e\.\U\T\C\(Y,n,j,G,i)',$date).",".$row['timeout']."],".$rn;
	#	echo date_format($date, '\[\D\a\t\e\.\U\T\C\(Y,n,j,G,i)').",".$row['timeout']."],".$rn;
		echo $datetoprint.",".$row['timeout']."],".$rn;
		#echo strtotime($row['unixdate'])." ".$rn;
		#echo $row['unixdate']." ".$rn;
                break;
                case "count":
                #echo date_format($row['unixdate'], '\[\D\a\t\e\.\U\T\C\(Y,n,j,G,i)').",".$row['count']."],".$rn;
		#echo date('\[\D\a\t\e\.\U\T\C\(Y,n,j,G,i)',strtotime($row['unixdate'])).",".$row['count']."],".$rn;
		#echo date('\[\D\a\t\e\.\U\T\C\(Y,n,j,G,i)',$date).",".$row['count']."],".$rn;
	#	echo date_format($date, '\[\D\a\t\e\.\U\T\C\(Y,n,j,G,i)').",".$row['count']."],".$rn;
		echo $datetoprint.",".$row['count']."],".$rn;
                break;
        }

   }
   //echo "Operation done successfully\n";
   $db->close();

echo "]);".$rn;


?>
