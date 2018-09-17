<?php

require "./include/common.php";

if (!defined('AXE'))
	exit;

$time=time();
$nextcheck =time()+(10*60);
 
$year = date("Y");
$month = date("m");
$week = date("W");
$day = date("z")+1;

class ParallelGet
{

  function __construct($urls)
  {
   
    global $CMS_PDO,$year,$month,$week,$day;    
      
    // Create get requests for each URL
    $mh = curl_multi_init();
    foreach($urls as $i => $url)
    {
      $ch[$i] = curl_init($url);
      curl_setopt($ch[$i], CURLOPT_RETURNTRANSFER, 1);
      curl_multi_add_handle($mh, $ch[$i]);
    }

    // Start performing the request
    do {
        $execReturnValue = curl_multi_exec($mh, $runningHandles);
    } while ($execReturnValue == CURLM_CALL_MULTI_PERFORM);
    // Loop and continue processing the request
    while ($runningHandles && $execReturnValue == CURLM_OK) {
      // Wait forever for network
      $numberReady = curl_multi_select($mh);
      if ($numberReady != -1) {
        // Pull in any new data, or at least handle timeouts
        do {
          $execReturnValue = curl_multi_exec($mh, $runningHandles);
        } while ($execReturnValue == CURLM_CALL_MULTI_PERFORM);
      }
    }

    // Check for any errors
    if ($execReturnValue != CURLM_OK) {
      trigger_error("Curl multi read error $execReturnValue\n", E_USER_WARNING);
    }

    
     $res7 = $CMS_PDO->prepare("REPLACE INTO stream_meta (name,followers,views,year,month,week,day) VALUES (:name,:followers,:views,:year,:month,:week,:day)");
    // Extract the content
    foreach($urls as $i => $url)
    {
      // Check for errors
      $curlError = curl_error($ch[$i]);
      if($curlError == "") {

      $array = json_decode(curl_multi_getcontent($ch[$i]));
                
        $res7->bindParam(':name', $array->name, PDO::PARAM_STR);
        $res7->bindParam(':followers', $array->followers, PDO::PARAM_INT);
        $res7->bindParam(':views', $array->views, PDO::PARAM_INT);
        $res7->bindParam(':year', $year, PDO::PARAM_INT);
        $res7->bindParam(':month', $month, PDO::PARAM_INT);
        $res7->bindParam(':week', $week, PDO::PARAM_INT);
        $res7->bindParam(':day', $day, PDO::PARAM_INT);
        $res7->execute();
      } 
      else 
      {
        print "Curl error on handle $i: $curlError\n";
      }
      // Remove and close the handle
      curl_multi_remove_handle($mh, $ch[$i]);
      curl_close($ch[$i]);
    }
    // Clean up the curl_multi handle
    curl_multi_close($mh);

  }
  
}

	$mycurl = curl_init();
		curl_setopt ($mycurl, CURLOPT_HEADER, 0);
		curl_setopt ($mycurl, CURLOPT_RETURNTRANSFER, 1); 
                
                // 100 csatorna lekérdezése maximum 300 magyar csatornáig support!
                $offset = rand(0,2);
                $offset = $offset*100;       
                
		$url = "https://api.twitch.tv/kraken/streams?language=hu&limit=100&offset=".$offset."";
                
                //https://api.twitch.tv/kraken/streams?language=hu
                
                curl_setopt ($mycurl, CURLOPT_URL, $url);
                $web_response =  curl_exec($mycurl); 
                $array = json_decode($web_response);
                
                
                echo"".$array->_total.""; 
                
                if($array->_total > 0)
                {
                foreach($array->streams as $value) 
                {
      
                $streamer[$i] = $value->channel->name;
                $display[$i] = $value->channel->display_name;
                $followers[$i] = $value->channel->followers;
                $views[$i] = $value->channel->views;
                $status[$i] = $value->channel->status;
                $viewers[$i] = $value->viewers;
                $game[$i] = $value->game;
                $preview[$i] = $value->preview->large;
                $offline[$i] = $value->channel->profile_banner;

              //  echo"".$streamer[$i].""; 
                
                
                $res5 = $CMS_PDO->prepare("INSERT IGNORE INTO `stream_list` (`name`, `display_name`, `followers`, `views`, `status`, `viewers`, `game`, `large`, `offline`) VALUES (:name, :display_name, :followers, :views, :status, :viewers, :game, :preview, :offline);");
		$res5->bindParam(':name', htmlspecialchars($streamer[$i]), PDO::PARAM_STR);
                $res5->bindParam(':display_name', htmlspecialchars($display[$i]), PDO::PARAM_STR);
                $res5->bindParam(':followers', $followers[$i], PDO::PARAM_INT);
                $res5->bindParam(':views', $views[$i], PDO::PARAM_INT);
                $res5->bindParam(':status', htmlspecialchars($status[$i]), PDO::PARAM_STR);
                $res5->bindParam(':viewers', $viewers[$i], PDO::PARAM_INT);
                $res5->bindParam(':game', htmlspecialchars($game[$i]), PDO::PARAM_STR);
                $res5->bindParam(':preview', htmlspecialchars($preview[$i]), PDO::PARAM_STR);
                $res5->bindParam(':offline', htmlspecialchars($offline[$i]), PDO::PARAM_STR);
		$res5->execute();
                
                $res8 = $CMS_PDO->prepare("UPDATE `stream_list` SET followers=:followers,views = :views, viewers=:viewers , large =:preview WHERE name=:name;");
                $res8->bindParam(':name', htmlspecialchars($streamer[$i]), PDO::PARAM_STR);
                $res8->bindParam(':followers', $followers[$i], PDO::PARAM_INT);
                $res8->bindParam(':preview', htmlspecialchars($preview[$i]), PDO::PARAM_STR);
                $res8->bindParam(':viewers', $viewers[$i], PDO::PARAM_INT);
                $res8->bindParam(':views', $views[$i], PDO::PARAM_INT);
		$res8->execute();
                
                
                $res6 = $CMS_PDO->prepare("INSERT IGNORE INTO `stream_update` (`name`) VALUES (:name);");
                $res6->bindParam(':name', htmlspecialchars($streamer[$i]), PDO::PARAM_STR);
                $res6->execute();
                
                $res7 = $CMS_PDO->prepare("UPDATE `stream_update` SET timecheck=:timechecknext,online =1 WHERE name=:name;");
                $res7->bindParam(':timechecknext', $nextcheck, PDO::PARAM_INT);
                $res7->bindParam(':name', htmlspecialchars($streamer[$i]), PDO::PARAM_STR);
		$res7->execute();  
                
		$i++;
		}

                }

        
                $res2 = $CMS_PDO->prepare("SELECT `stream_update`.name FROM `stream_update` INNER JOIN stream_list ON stream_update.name = stream_list.name WHERE timecheck<= :time
                ORDER BY `stream_list`.`followers` DESC LIMIT 20;");
                $res2->bindParam(':time', $time, PDO::PARAM_INT);
		$res2->execute();


		while ($row = $res2->fetch())	
			{
			$channelName = $row['name'];
			$stream_list.="".strtolower($channelName).","; 
			}
			unset($res2);
	
                $stream_list.="gamertvhu";     
                        
                $res6 = $CMS_PDO->prepare("UPDATE `stream_update` SET timecheck=:timechecknext,online=0 WHERE name IN (".$stream_list.");");
                $res6->bindParam(':timechecknext', $nextcheck, PDO::PARAM_INT);
		$res6->execute();         
                        
                $res7 = $CMS_PDO->prepare("UPDATE `stream_update` SET timecheck=:timechecknext,online =0 WHERE timecheck<= :time;");
                $res7->bindParam(':timechecknext', $nextcheck, PDO::PARAM_INT);
                $res7->bindParam(':time', $time, PDO::PARAM_INT);
		$res7->execute(); 
                
       
		$mycurl = curl_init();
		curl_setopt ($mycurl, CURLOPT_HEADER, 0);
		curl_setopt ($mycurl, CURLOPT_RETURNTRANSFER, 1); 
		$url = "https://api.twitch.tv/kraken/streams?channel=".$stream_list."";
                
                curl_setopt ($mycurl, CURLOPT_URL, $url);
                $web_response =  curl_exec($mycurl); 
                $array = json_decode($web_response);
                

                echo"".$array->_total.""; 
                
                if($array->_total > 0)
                {
                foreach($array->streams as $value) 
                {

                 echo"ok";     
                    
                $streamer[$i] = $value->channel->name;
                $display[$i] = $value->channel->display_name;
                $followers[$i] = $value->channel->followers;
                $views[$i] = $value->channel->views;
                $status[$i] = $value->channel->status;
                $viewers[$i] = $value->viewers;
                $game[$i] = $value->game;
                $preview[$i] = $value->preview->large;
                $offline[$i] = $value->channel->profile_banner;

              //  echo"".$streamer[$i].""; 
                
                
                $res5 = $CMS_PDO->prepare("INSERT IGNORE INTO `stream_list` (`name`, `display_name`, `followers`, `views`, `status`, `viewers`, `game`, `large`, `offline`) VALUES (:name, :display_name, :followers, :views, :status, :viewers, :game, :preview, :offline);");
		$res5->bindParam(':name', htmlspecialchars($streamer[$i]), PDO::PARAM_STR);
                $res5->bindParam(':display_name', htmlspecialchars($display[$i]), PDO::PARAM_STR);
                $res5->bindParam(':followers', $followers[$i], PDO::PARAM_INT);
                $res5->bindParam(':views', $views[$i], PDO::PARAM_INT);
                $res5->bindParam(':status', htmlspecialchars($status[$i]), PDO::PARAM_STR);
                $res5->bindParam(':viewers', $viewers[$i], PDO::PARAM_INT);
                $res5->bindParam(':game', htmlspecialchars($game[$i]), PDO::PARAM_STR);
                $res5->bindParam(':preview', htmlspecialchars($preview[$i]), PDO::PARAM_STR);
                $res5->bindParam(':offline', htmlspecialchars($offline[$i]), PDO::PARAM_STR);
		$res5->execute();
                
                $res8 = $CMS_PDO->prepare("UPDATE `stream_list` SET followers=:followers,views = :views, viewers=:viewers , large =:preview WHERE name=:name;");
                $res8->bindParam(':name', htmlspecialchars($streamer[$i]), PDO::PARAM_STR);
                $res8->bindParam(':followers', $followers[$i], PDO::PARAM_INT);
                $res8->bindParam(':preview', htmlspecialchars($preview[$i]), PDO::PARAM_STR);
                $res8->bindParam(':viewers', $viewers[$i], PDO::PARAM_INT);
                $res8->bindParam(':views', $views[$i], PDO::PARAM_INT);
		$res8->execute();
                
                
                
                $res6 = $CMS_PDO->prepare("UPDATE `stream_update` SET timecheck=:timechecknext,online =1 WHERE name=:name;");
                $res6->bindParam(':timechecknext', $nextcheck, PDO::PARAM_INT);
                $res6->bindParam(':name', htmlspecialchars($streamer[$i]), PDO::PARAM_STR);
		$res6->execute();  
                
                if($followers[$i]<=5 and $viewers[$i]>=200)
                {
                $res8 = $CMS_PDO->prepare("UPDATE `stream_update` SET banned=1 WHERE name=:name;");
                $res8->bindParam(':name', htmlspecialchars($streamer[$i]), PDO::PARAM_STR);
		$res8->execute();
                }
                
                $res7 = $CMS_PDO->prepare("REPLACE INTO stream_meta (name,followers,views,year,month,week,day) VALUES (:name,:followers,:views,:year,:month,:week,:day)");
                $res7->bindParam(':name', htmlspecialchars($streamer[$i]), PDO::PARAM_STR);
                $res7->bindParam(':followers', $followers[$i], PDO::PARAM_INT);
                $res7->bindParam(':views', $views[$i], PDO::PARAM_INT);
                $res7->bindParam(':year', $year, PDO::PARAM_INT);
                $res7->bindParam(':month', $month, PDO::PARAM_INT);
                $res7->bindParam(':week', $week, PDO::PARAM_INT);
                $res7->bindParam(':day', $day, PDO::PARAM_INT);
                
                $res7->execute();
                
		$i++;
		}

                }
                
    //StreamUser Update
                
    $res2 = $CMS_PDO->prepare("SELECT name FROM `stream_list` WHERE `views`>40000 OR custom=1 ORDER BY RAND() LIMIT 5;");
    $res2->execute();


		while ($row = $res2->fetch())	
			{
			$channelName = $row['name'];
			$stream_list.="".strtolower($channelName).","; 
                        
                        $urls[] = "https://api.twitch.tv/kraken/channels/".$row['name']."";
			}
			unset($res2);

                    $pg = new ParallelGet($urls);                   
                      
                   $stream_list.="gamertvhu";     
                        
		$mycurl = curl_init();
		curl_setopt ($mycurl, CURLOPT_HEADER, 0);
		curl_setopt ($mycurl, CURLOPT_RETURNTRANSFER, 1); 
		$url = "https://api.twitch.tv/kraken/streams?channel=".$stream_list."";
                
                curl_setopt ($mycurl, CURLOPT_URL, $url);
                $web_response =  curl_exec($mycurl); 
                $array = json_decode($web_response);
                
                echo"".$array->_total.""; 
                
                if($array->_total > 0)
                {
                     
                foreach($array->streams as $value) 
                {

                 echo"ok";     
                    
                $streamer[$i] = $value->channel->name;
                $display[$i] = $value->channel->display_name;
                $followers[$i] = $value->channel->followers;
                $views[$i] = $value->channel->views;
                $status[$i] = $value->channel->status;
                $viewers[$i] = $value->viewers;
                $game[$i] = $value->game;
                $preview[$i] = $value->preview->large;
                $offline[$i] = $value->channel->profile_banner;

              //  echo"".$streamer[$i].""; 
                
                
                $res5 = $CMS_PDO->prepare("INSERT IGNORE INTO `stream_list` (`name`, `display_name`, `followers`, `views`, `status`, `viewers`, `game`, `large`, `offline`) VALUES (:name, :display_name, :followers, :views, :status, :viewers, :game, :preview, :offline);");
		$res5->bindParam(':name', htmlspecialchars($streamer[$i]), PDO::PARAM_STR);
                $res5->bindParam(':display_name', htmlspecialchars($display[$i]), PDO::PARAM_STR);
                $res5->bindParam(':followers', $followers[$i], PDO::PARAM_INT);
                $res5->bindParam(':views', $views[$i], PDO::PARAM_INT);
                $res5->bindParam(':status', htmlspecialchars($status[$i]), PDO::PARAM_STR);
                $res5->bindParam(':viewers', $viewers[$i], PDO::PARAM_INT);
                $res5->bindParam(':game', htmlspecialchars($game[$i]), PDO::PARAM_STR);
                $res5->bindParam(':preview', htmlspecialchars($preview[$i]), PDO::PARAM_STR);
                $res5->bindParam(':offline', htmlspecialchars($offline[$i]), PDO::PARAM_STR);
		$res5->execute();
                
                $res8 = $CMS_PDO->prepare("UPDATE `stream_list` SET followers=:followers,views = :views, viewers=:viewers , large =:preview WHERE name=:name;");
                $res8->bindParam(':name', htmlspecialchars($streamer[$i]), PDO::PARAM_STR);
                $res8->bindParam(':followers', $followers[$i], PDO::PARAM_INT);
                $res8->bindParam(':preview', htmlspecialchars($preview[$i]), PDO::PARAM_STR);
                $res8->bindParam(':viewers', $viewers[$i], PDO::PARAM_INT);
                $res8->bindParam(':views', $views[$i], PDO::PARAM_INT);
		$res8->execute();
                
                $res6 = $CMS_PDO->prepare("UPDATE `stream_update` SET timecheck=:timechecknext,online =1 WHERE name=:name;");
                $res6->bindParam(':timechecknext', $nextcheck, PDO::PARAM_INT);
                $res6->bindParam(':name', htmlspecialchars($streamer[$i]), PDO::PARAM_STR);
		$res6->execute();  
                
                $res7 = $CMS_PDO->prepare("REPLACE INTO stream_meta (name,followers,views,year,month,week,day) VALUES (:name,:followers,:views,:year,:month,:week,:day)");
                $res7->bindParam(':name', htmlspecialchars($streamer[$i]), PDO::PARAM_STR);
                $res7->bindParam(':followers', $followers[$i], PDO::PARAM_INT);
                $res7->bindParam(':views', $views[$i], PDO::PARAM_INT);
                $res7->bindParam(':year', $year, PDO::PARAM_INT);
                $res7->bindParam(':month', $month, PDO::PARAM_INT);
                $res7->bindParam(':week', $week, PDO::PARAM_INT);
                $res7->bindParam(':day', $day, PDO::PARAM_INT);
                
                $res7->execute();
                
		$i++;
		}

                }

		// Youtube VÉGRE!!!!
		
		//for($x=0; $x<$arrlength; $x++){
			$random = rand(1,3);
			
                        if($random<=3)
                        {
                                if($random==1)
                                {
                                $url="https://www.googleapis.com/youtube/v3/search?part=snippet&eventType=live&type=video&videoCategoryId=20&q=hun&maxResults=50&key=AIzaSyDKuC1zbz9OVEaWOjdPaMFxoddZznbwcBc";
                                }
                                elseif($random==2)
                                {
                                $url="https://www.googleapis.com/youtube/v3/search?part=snippet&eventType=live&type=video&videoCategoryId=20&q=élő&maxResults=50&key=AIzaSyDKuC1zbz9OVEaWOjdPaMFxoddZznbwcBc";			
                                }
                                elseif($random==3)
                                {
                                $url="https://www.googleapis.com/youtube/v3/search?part=snippet&eventType=live&type=video&videoCategoryId=20&q=HU&maxResults=50&key=AIzaSyDKuC1zbz9OVEaWOjdPaMFxoddZznbwcBc";			
                                }
                                else
                                {
                                $url="https://www.googleapis.com/youtube/v3/search?part=snippet&eventType=live&type=video&videoCategoryId=20&q=magyar&maxResults=50&key=AIzaSyDKuC1zbz9OVEaWOjdPaMFxoddZznbwcBc";
                                }				

                                $resp = file_get_contents($url);
                                $obj = json_decode($resp);

                                for ($i=0; $i<5; $i++){

                                $id = $obj->items[$i]->id->channelId;
                                $title = $obj->items[$i]->snippet->title;
                                $name = $obj->items[$i]->snippet->channelTitle;
                                $realname = $obj->items[$i]->snippet->channelId;

                                $videoID = $obj->items[$i]->id->videoId;

                                $picture = $obj->items[$i]->snippet->thumbnails->high->url;
                                $tube = 1;

                                $res6 = $CMS_PDO->prepare("UPDATE `tube_update` SET online=0 WHERE timecheck<=:timechecknext;");
                                $res6->bindParam(':timechecknext', $time, PDO::PARAM_INT);
                                $res6->execute();     

                                if($videoID!="")
                                {    
                                $url = "https://www.youtube.com/live_stats?v=".$videoID."";
                                $viewers = file_get_contents($url);
                                }

                                $url = "https://www.googleapis.com/youtube/v3/channels?part=statistics,snippet&id=".$realname."&key=AIzaSyDKuC1zbz9OVEaWOjdPaMFxoddZznbwcBc";

                                $resp = file_get_contents($url);
                                $obj2 = json_decode($resp);

                                $viewCount = $obj2->items[0]->statisctics->viewCount;
                                $subscriberCount = $obj2->items[0]->statisctics->subscriberCount;
                                $offline = $obj2->items[0]->snippet->thumbnails->high->url;
                                $desc = $obj2->items[0]->snippet->description;


                                if($name!='')
                                {
                                        $res5 = $CMS_PDO->prepare("REPLACE INTO `tube_list` (`name`, `display_name`, `videoID`, `followers`, `views`, `status`, `description`, `viewers`, `game`, `large`, `offline`) VALUES (:name, :display_name, :videoID, :followers, :views, :status, :description, :viewers, :game, :preview, :offline);");
                                        $res5->bindParam(':name', $realname, PDO::PARAM_STR);
                                        $res5->bindParam(':display_name', $name, PDO::PARAM_STR);
                                        $res5->bindParam(':followers', $subscriberCount, PDO::PARAM_INT);
                                        $res5->bindParam(':videoID', $videoID, PDO::PARAM_STR);
                                        $res5->bindParam(':views', $viewCount, PDO::PARAM_INT);
                                        $res5->bindParam(':status', $title, PDO::PARAM_STR);
                                        $res5->bindParam(':description', $desc, PDO::PARAM_STR);
                                        $res5->bindParam(':viewers', $viewers, PDO::PARAM_INT);
                                        $res5->bindParam(':game', $tube, PDO::PARAM_STR);
                                        $res5->bindParam(':preview', $picture, PDO::PARAM_STR);
                                        $res5->bindParam(':offline', $offline, PDO::PARAM_STR);
                                        $res5->execute();
                                        
                                        echo $realname;
                                        

                                        $res7 = $CMS_PDO->prepare("REPLACE INTO `tube_update` (`name`, `online`, `timecheck`) VALUES (:name, 1, :timechecknext);");
                                        $res7->bindParam(':name', $realname, PDO::PARAM_STR);
                                        $res7->bindParam(':timechecknext', $nextcheck, PDO::PARAM_INT);
                                        $res7->execute();
                                }
                                }
	}

     
       echo'<html>
<head>
 <script type="text/javascript">

function display_c(){
var refresh=10000; // Refresh rate in milli seconds
mytime=setTimeout("charlist()",refresh)
}


function charlist () {
        
        xmlhttp = new XMLHttpRequest();
        
        xmlhttp.onreadystatechange = function() {
            
            
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            }

        }
        xmlhttp.open("GET","streamupdater.php",true);
        xmlhttp.send();  
        
display_c();
}

</script></head>
<body>
<script type="text/javascript">
        window.onload =  charlist;
        
        </script>
</body>

</html>
               ';
	
?>	