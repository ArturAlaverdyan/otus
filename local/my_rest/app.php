<?php
$queryURL = "https://ca43694.tw1.ru/rest/1/8102vq5wa1zjaf8g/crm.activity.get.json";	
$queryData = http_build_query(array(
	"ID" => $_REQUEST['data']['FIELDS']['ID'],
	),	 
);

$curl = curl_init();
curl_setopt_array($curl, array(
	CURLOPT_SSL_VERIFYPEER => 0,
	CURLOPT_POST => 1,
	CURLOPT_HEADER => 0,
	CURLOPT_RETURNTRANSFER => 1,
	CURLOPT_URL => $queryURL,
	CURLOPT_POSTFIELDS => $queryData,
));
$result = curl_exec($curl);
curl_close($curl);
$result = json_decode($result,1);

file_put_contents(
	__DIR__ . '/log/result' . time() . '.txt',
	var_export($result, true)
);


$queryURL = "https://ca43694.tw1.ru/rest/1/8102vq5wa1zjaf8g/crm.contact.update.json";	
$queryData = http_build_query(array(
	"ID" => $result['result']['OWNER_ID'],
	"FIELDS" => array(	
		"UF_CRM_1744220066" => date("Y-m-d H:i:s"),
		),
	),	 
);

$curl = curl_init();
curl_setopt_array($curl, array(
	CURLOPT_SSL_VERIFYPEER => 0,
	CURLOPT_POST => 1,
	CURLOPT_HEADER => 0,
	CURLOPT_RETURNTRANSFER => 1,
	CURLOPT_URL => $queryURL,
	CURLOPT_POSTFIELDS => $queryData,
));
$result = curl_exec($curl);
curl_close($curl);
$result = json_decode($result,1);

file_put_contents(
	__DIR__ . '/log/change' . time() . '.txt',
	var_export($result, true)
);