<?php
 class Post { 
           var $likes; 
           var $shares; 
           var $txt, $data; 
           var $id; 
           static function cmp ($a, $b) { 
               if ($a->likes == $b->likes)  
                  return ($a->shares < $b->shares) ? +1 : -1; 
              return ($a->likes < $b->likes) ? +1 : -1; 
         } 
 } 
 function get_url($url)
 {
         $ch = curl_init();
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_TIMEOUT, 5);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
 
     curl_setopt($ch, CURLOPT_URL, $url);
    $tmp = curl_exec($ch);
    curl_close($ch);
    return $tmp;
 }


    include 'post.php';

    $file = 'data';
    $lines = file($file);
    $n = $lines[0];
    $all = array();
    $cnt = 1;
    
 /*
    for ($i = 0; $i < $n; $i++) {    
        $cur = new Post();
        
        $parts = explode(" ", $lines[$cnt]);
        $cur->likes = $parts[0];
        $cur->shares = $parts[1];
        $cnt++;

        $cur->date = $lines[$cnt++];
        $cur->txt = $lines[$cnt++];
        $cur->id = $lines[$cnt++];
        $cnt++;
        array_push($all, $cur);
    }*/
    $ID =  -55298594;
    
    $url = 'https://api.vk.com/method/wall.getById?posts='.$ID.'_';

    $end = 600;
    $start = 0;
    $lines = file('good');
    $n = sizeof($lines);
    if ($n > 0) $start = $lines[$n-1];
    for ($i = $start+1; $i <= $end; $i++) array_push($lines, $i);
    $n = sizeof($lines);
    foreach ($lines as $key => $i) {
        $cUrl = $url.$i;
        echo $i."\n";
        $json = file_get_contents($cUrl);
        $data = json_decode($json, true);
        if (!isset($data['response'][0])) {
            unset($lines[$key]);
            continue;
        }
        $response = $data['response'][0];
        echo "fine\n";
        $cur = new Post();
        $cur->likes = $response['likes']['count'];
        $cur->shares = $response['reposts']['count'];
        $cur->txt = $response['text']."\n";
        $cur->date = gmdate("d M Y H:i:s", $response['date'])."\n";
        $cur->id = $response['id']."\n";
        array_push($all, $cur);
    }
    usort($all, array("post", "cmp"));
    $result = sizeof($all)."\n";
    foreach ($all as $x) {
        $result.=$x->likes." ".$x->shares."\n";
        $result.=$x->date;
        $result.=$x->txt;
        $result.=$x->id;
        $result.="\n";
    }
    $smth="";
    foreach ($lines as $x)     $smth.=$x."\n";
    
    file_put_contents('good', $smth);
    file_put_contents($file, $result);
    ?>
