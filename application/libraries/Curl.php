<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Curl{
    
    public function get_signle_curl($url) // return decoded Json
    {
        $get_signle_curl = curl_init();
        curl_setopt ($get_signle_curl, CURLOPT_HEADER, 0);
        curl_setopt ($get_signle_curl, CURLOPT_RETURNTRANSFER, 1); 
        curl_setopt ($get_signle_curl, CURLOPT_URL, $url);
            
        $result = json_decode(curl_exec($get_signle_curl)); 
        
        return $result;
    } 
    
    public function get_multiple_curl($urls) // return array with decoded Jsons
    {
   
    $mh = curl_multi_init();
    foreach($urls as $i => $url)
    {
      $ch[$i] = curl_init($url);
      curl_setopt($ch[$i], CURLOPT_RETURNTRANSFER, 1);
      curl_multi_add_handle($mh, $ch[$i]);
    }

    do {
        $execReturnValue = curl_multi_exec($mh, $runningHandles);
    } while ($execReturnValue == CURLM_CALL_MULTI_PERFORM);

    while ($runningHandles && $execReturnValue == CURLM_OK) {

      $numberReady = curl_multi_select($mh);
      if ($numberReady != -1) {
        do {
          $execReturnValue = curl_multi_exec($mh, $runningHandles);
        } while ($execReturnValue == CURLM_CALL_MULTI_PERFORM);
      }
    }

    if ($execReturnValue != CURLM_OK) {
      trigger_error("Curl multi read error $execReturnValue\n", E_USER_WARNING);
    }

    foreach($urls as $i => $url)
    {
      // Check for errors
      $curlError = curl_error($ch[$i]);
      if($curlError == "")
      {
        $result[$i] = json_decode(curl_multi_getcontent($ch[$i]));      
      } 
      else 
      {
        return "Curl error on handle $i: $curlError\n";
      }
      // Remove and close the handle
      curl_multi_remove_handle($mh, $ch[$i]);
      curl_close($ch[$i]);
    }
    // Clean up the curl_multi handle
    curl_multi_close($mh);

    return $result;
    
  }
    
}

