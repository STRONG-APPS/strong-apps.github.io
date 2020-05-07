<?php
$channelid = $_GET['channelid'];
$username = '00:00:00:00:00:00';// $_GET['macAddress'];
$password = 'Ma_Hani_Karin'; // $_GET['serialNumber'];
$url = "https://mw.nimitv.net/wbs/pc/auth";
$data = array("macAddress" => $username, "serialNumber" => $password, "model" => "", "timeStamp" => time(), "firmwareVersion" => "");               
$data_string = json_encode($data);                                      
$ch = curl_init($url);                                                          
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                                                     
curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);                                                                  
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Content-Length: ' . strlen($data_string)));                                                                                                                   
$result = curl_exec($ch);
#print_r($result);
#die();
$data = json_decode($result);
$session = $data->payload->sessionId;
$account = "https://mw.nimitv.net/wbs/api/v2/tv/".$channelid;
$cookieheaders = "Cookie: JSESSIONID=" . $session;
$ch2 = curl_init();
$headers = array("$cookieheaders");
curl_setopt($ch2, CURLOPT_URL, $account);
curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch2, CURLOPT_HTTPHEADER, $headers);
$answer = curl_exec($ch2);

$data = json_decode($answer, true);
$final = $data['playbackUrl'];
// print_r($final);
// die();
header('Location: '.$final);
// header('Content-type: application/x-mpegURL');
// header('Content-Disposition: attachment; filename="index.m3u8"');
?>
