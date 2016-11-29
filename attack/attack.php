<?php
	require "vendor/autoload.php";

	$zapip = gethostbyname('zap2');
	$target_ip = gethostbyname('testsite');
  $target = "http://${target_ip}:8080/";
	echo "ip=".$target_ip."\n";

	$zap = new Zap\Zapv2('tcp://'.$zapip.':8090');
	$zap->base = 'http://'.$zapip.':8090/JSON/';

	$version = @$zap->core->version();
	if(is_null($version)) {
		echo "PHP API error\n";
	} else {
		echo "version: ${version}\n";
	}

	$scan_id = $zap->spider->scan($target);
	echo "scan_id:${scan_id}\n";

  $count = 0;
  while (true) {
    if ($count > 10) exit();
    $progress = intval($zap->spider->status($scanid));
    echo "progress ${progress}%\n";
    if ($progress >= 100) break;
    sleep(1);
    $count++;
  }

 $res = $zap->spider->results($scan_id);

echo "\n";
 $res = $zap->spider->fullResults($scan_id);

echo "Spider completed\n";

// Give the passive scanner a chance to finish
sleep(3);

echo "Scanning target ${target}\n";
// Response JSON for error looks like {"code":"url_not_found", "message":"URL is not found"}
$scan_id = $zap->ascan->scan($target);
echo "scan_id:${scan_id}\n";
$count = 0;
while (true) {
  if ($count > 10) exit();
  $progress = intval($zap->ascan->status($scan_id));
  printf("Scan progress %d\n", $progress);
  if ($progress >= 100) break;
  sleep(2);
  $count++;
}
echo "Scan completed\n";

// Report the results
echo "Hosts: " . implode(",", $zap->core->hosts()) . "\n";
$alerts = $zap->core->alerts($target, "", "");
echo "Alerts (" . count($alerts) . "):\n";

$res_xml = new SimpleXMLElement($zap->core->xmlreport());
//echo $res_xml->asXML();
$filepath = "./report/workspace/zap_".time().".xml";
$fp = fopen($filepath, "w");
fwrite($fp, $res_xml->asXML());
fclose($fp);
