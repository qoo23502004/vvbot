<?php

#$date_default_timezone_set('Asia/Taipei');

require_once('line-bot-sdk-tiny/LINEBotTiny.php');
require_once('weather.php');
$channelAccessToken = '09mdileCjp5VlcpNG1gv+3gZ2tBa0tcBGNbzQEwPcZbVYqfTCXPkbuebN7In2nPC7adVZKiHKJHfvO5ZmwjBBSXW/4gvzOuZzbGfeAP0fqGtJxM3j+VFX6Ac2L8g/N3RyQJ2qusyx5s0nkRfPQHozQdB04t89/1O/w1cDnyilFU=';
$channelSecret = '994cd15223d21d1114738fa4b6111b42';

$client = new LINEBotTiny($channelAccessToken, $channelSecret);


 



//$channelAccessToken = '{b/mBXDVm3/gsIZlxk2J2Vz6nI9NwdGXUsFkBRS+xFRCjNpOWKwxzCNZ9WxQ96xf7Yd39WAjQ9SxZQL+CepANPvMNDGrtbWLlw1gd360WpcwfDaxRB3ECWcufFc497o0MNcFUQp9lDgHCOYf4khpqsAdB04t89/1O/w1cDnyilFU=}';
$password = "get IDfffg";      // group login password
$dbFilePath = 'line-db.json';        // group info database file path
if (!file_exists($dbFilePath)) {
   file_put_contents($dbFilePath, json_encode(['group' => []]));
}
$db = json_decode(file_get_contents($dbFilePath), true);
$bodyMsg = file_get_contents('php://input');
file_put_contents('log.txt', date('Y-m-d H:i:s') . 'Recive: ' . $bodyMsg);
$obj = json_decode($bodyMsg, true);
file_put_contents('log.txt', print_r($db, true));
foreach ($obj['events'] as &$event) {
   $groupId = $event['source']['groupId'];
   // bot dirty logic
   if (!isset($db['group'][$groupId])) {
       if ($event['message']['text'] === $password) {
           $db['group'][$groupId] = [
               'groupId' => $groupId,
               'timestamp' => $event['timestamp']
           ];
           file_put_contents($dbFilePath, json_encode($db));
           $message = 'ID Get';
       } /*else {
           //$message = 'Input password please.';
		   
       }*/
   } 
   else {
       if (strtolower($event['message']['text']) === "!closenotify") {
           unset($db['group'][$groupId]);
           file_put_contents($dbFilePath, json_encode($db));
           $message = 'do nothing';
       } /*else {
           $message = '已經為您取消開台通知';
       }*/
   }
   // Make payload
   $payload = [
       'replyToken' => $event['replyToken'],
       'messages' => [
           [
               'type' => 'text',
               'text' => $message
           ]
       ]
   ];
   // Send reply API
   $ch = curl_init();
   curl_setopt($ch, CURLOPT_URL, 'https://api.line.me/v2/bot/message/reply');
   curl_setopt($ch, CURLOPT_POST, true);
   curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
   curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
   curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
   curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
   curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
   curl_setopt($ch, CURLOPT_HTTPHEADER, [
       'Content-Type: application/json',
       'Authorization: Bearer ' . $channelAccessToken
   ]);
   $result = curl_exec($ch);
   curl_close($ch);
   


}






foreach ($client->parseEvents() as $event) {

    switch ($event['type']) {
        case 'message':
            $message = $event['message'];

            switch ($message['type']) {
                case 'text': 

				$response2=array("安安唷^^","你好啊^^","0..0","嗨~","哩賀!","Hello!","Hi^^");
				$response3=array("不然呢?","叫歐歐教我啊!","阿不然你跟我講要回什麼?");				
				$response5=array("我也愛妳呢<3","小歐也是很愛妳的^^","太害羞了吧＞／／／＜");
				$response5a=array("好巧，我也正在想妳<3","真的嗎，我也想妳","><我也想妳呢!");
				$cityCHT=array("!台北市","!台南市","!基隆市","!高雄市","!台中市","!新北市","!新竹市","!嘉義市","!嘉義縣","!桃園縣","!屏東縣","!新竹縣","!苗栗縣","!台東縣","!花蓮縣","!宜蘭縣","!彰化縣","!澎湖縣","!南投縣","!金門縣","!雲林縣","!連江縣");
				$cityENG=array("Taipei_City","Tainan_City","Keelung_City","Kaohsiung_City","Taichung_City","New_Taipei_City","Hsinchu_City","Chiayi_City","Chiayi_County","Taoyuan_County","Pingtung_County","Hsinchu_County","Miaoli_County","Taitung_County","Hualien_County","Yilan_County","Changhua_County","Penghu_County","Nantou_County","Kinmen_County","Yunlin_County","Lienchiang_County");
			//中央氣象局 https://opendata.cwb.gov.tw/api/v1/rest/datastore/F-C0032-001?Authorization=CWB-F6A47420-AC70-4467-96CB-B94C0E1BDA11&limit=1&offset=2&format=JSON&sort=time	
				
						
						
						if(preg_match("/!小歐作筆記/i", $message["text"])){
						$cmd = fopen("command.txt", "a+");
						$userSet = explode(";",$message["text"]);
						fwrite($cmd, "\n".$userSet[1].";".$userSet[2].";");
						fclose($cmd);						
						$client->replyMessage(array(
                        'replyToken' => $event['replyToken'],
                        'messages' => array(
                            array(
                               'type' => 'text',
						'text' => "好喔好喔",
                                
                            ),
							 
							)
						));
						}
						
						if($message["text"]=="!text"){	
						#$commandList = fopen("command.txt","a+");
						$datetime= date("H:i");
						//fclose($commandList);
						$client->replyMessage(array(
                        'replyToken' => $event['replyToken'],
                        'messages' => array(
                            array(
                               'type' => 'text',
						'text' => $datetime,
                                
                            ),
							
							)
						));
						}
						
						
						
						
						if(in_array($message["text"], $cityCHT)){
						$key=array_search($message["text"],$cityCHT);					
						$Weather=getWeather($cityENG[$key]);
						$client->replyMessage(array(
                        'replyToken' => $event['replyToken'],
                        'messages' => array(
                            array(
                               'type' => 'text',
						'text' =>  $Weather[0]['date']."\n溫度：".$Weather[0]['temperature']."\n天氣狀況：".$Weather[0]['title'],
                                
                            ),
							
							)
						));
						}
						
				
						if($message["text"]=="小歐怎麼叫"){
						$client->replyMessage(array(
                        'replyToken' => $event['replyToken'],
                        'messages' => array(
                            array(
                               'type' => 'text',
						'text' => "Happy Sugar Life!",
                                
                            ),
							
							)
						));
						}
				
				        
						//打招呼 
						if(preg_match("/小歐安安/i", $message["text"])){
						$client->replyMessage(array(
                        'replyToken' => $event['replyToken'],
                        'messages' => array(
                            array(
                               'type' => 'text',
                                'text' => $response2[rand(0,6)] ,
                                
                            ),
							
							)
						));
						}
					    
						//對機器人的疑問
						if(preg_match("/只會回這幾句/i", $message["text"])){
						$client->replyMessage(array(
                        'replyToken' => $event['replyToken'],
                        'messages' => array(
                            array(
                               'type' => 'text',
                                'text' => $response3[rand(0,6)] ,
                                
                            ),
							
							)
						));
						}
						
						if($message["text"]=="!早餐"){
						$breakfirst='breakfirst.txt';//文件名
						$breakfirstArray=file($breakfirst);//把文件的所有内容获取到数组里面
						$allCount=count($breakfirstArray);//获得总行数
						$randomNumber=rand(0,$allCount-1);//产生随机行号
						$rnd_breakfirst=$breakfirstArray[$randomNumber];//获得随机行	
						$client->replyMessage(array(
                        'replyToken' => $event['replyToken'],
                        'messages' => array(
                            array(
                               'type' => 'text',
                                'text' => "真心推薦: ".$rnd_breakfirst,
                                
                            ),
							 
							)
						));
						}
						
						if($message["text"]=="!午餐"){
						$lunch='lunch.txt';//文件名
						$lunchArray=file($lunch);//把文件的所有内容获取到数组里面
						$allCount=count($lunchArray);//获得总行数
						$randomNumber=rand(0,$allCount-1);//产生随机行号
						$rnd_lunch=$lunchArray[$randomNumber];//获得随机行	
						$client->replyMessage(array(
                        'replyToken' => $event['replyToken'],
                        'messages' => array(
                            array(
                               'type' => 'text',
                                'text' => "真心推薦: ".$rnd_lunch,
                                
                            ),
							  
							)
						));
						}
						
						if($message["text"]=="!下午茶"){
						$AfternoonTea='AfternoonTea.txt';//文件名
						$AfternoonTeaArray=file($AfternoonTea);//把文件的所有内容获取到数组里面
						$allCount=count($AfternoonTeaArray);//获得总行数
						$randomNumber=rand(0,$allCount-1);//产生随机行号
						$rnd_AfternoonTea=$AfternoonTeaArray[$randomNumber];//获得随机行	
						$client->replyMessage(array(
                        'replyToken' => $event['replyToken'],
                        'messages' => array(
                            array(
                               'type' => 'text',
                                'text' => "真心推薦: ".$rnd_AfternoonTea,
                                
                            ),
							 
							)
						));
						}								
						
						
						if($message["text"]=="!晚餐"){
						$dinner='dinner.txt';//文件名
						$dinnerArray=file($dinner);//把文件的所有内容获取到数组里面
						$allCount=count($dinnerArray);//获得总行数
						$randomNumber=rand(0,$allCount-1);//产生随机行号
						$rnd_dinner=$dinnerArray[$randomNumber];//获得随机行	
						$client->replyMessage(array(
                        'replyToken' => $event['replyToken'],
                        'messages' => array(
                            array(
                               'type' => 'text',
                                'text' => "真心推薦: ".$rnd_dinner,
                                
                            ),
							
							)
						));
						}
						 
						if($message["text"]=="!宵夜"){
						$LateNightMeal='LateNightMeal.txt';//文件名
						$LateNightMealArray=file($LateNightMeal);//把文件的所有内容获取到数组里面
						$allCount=count($LateNightMealArray);//获得总行数
						$randomNumber=rand(0,$allCount-1);//产生随机行号
						$rnd_LateNightMeal=$LateNightMealArray[$randomNumber];//获得随机行	
						$client->replyMessage(array(
                        'replyToken' => $event['replyToken'],
                        'messages' => array(
                            array(
                               'type' => 'text',
                                'text' => "真心推薦: ".$rnd_LateNightMeal,
                                
                            ),
							 
							)
						));
						}
						
						if($message["text"]=="!窮人早餐"||$message["text"]=="!窮人午餐"||$message["text"]=="!窮人晚餐"){
						$client->replyMessage(array(
                        'replyToken' => $event['replyToken'],
                        'messages' => array(
                            array(
                               'type' => 'text',
						'text' => "看你要吃泡麵還是要餓死",
                                
                            ),
							
							)
						));
						}
						

						
						//撒嬌系
						if(preg_match("/小歐我愛你/i", $message["text"])){
						$client->replyMessage(array(
                        'replyToken' => $event['replyToken'],
                        'messages' => array(
                            array(
                               'type' => 'text',
                                'text' => $response5[rand(0,2)] ,
                                
                            ),
							
							)
						));
						}
						if(preg_match("/小歐我愛妳/i", $message["text"])){
						$client->replyMessage(array(
                        'replyToken' => $event['replyToken'],
                        'messages' => array(
                            array(
                               'type' => 'text',
                                'text' => $response5[rand(0,2)] ,
                                
                            ),
							
							)
						));
						}
						if($message["text"]=="想妳"||$message["text"]=="想你"||$message["text"]=="我想你"||$message["text"]=="我想妳"){
						$client->replyMessage(array(
                        'replyToken' => $event['replyToken'],
                        'messages' => array(
                            array(
                               'type' => 'text',
                                'text' => $response5a[rand(0,2)] ,
                                
                            ),
							
							)
						));
						}
						

					break;
				
					
                default:
				
                    error_log("Unsupporeted message type: " . $message['type']);
				   break;
				
            }
            break;
        default:
            error_log("Unsupporeted event type: " . $event['type']);
            break;
			
    
}




};



?>
