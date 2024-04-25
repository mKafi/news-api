<?php 

/**
 * Getting new sources
 */
    $apiKey = '8592fc6dcc3b4d82b135e6ec87241497';
    $fields = array(
        #'category' => 'business',
        'language' => 'en',
        #'country' => '',
        'apiKey' => $apiKey
    );
    $url = "https://newsapi.org/v2/sources";  
    $url .= '?'.http_build_query($fields); 
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
    $sources = curl_exec($ch);
    curl_close($ch);
    
    if(!curl_errno($ch)){
        $source = json_decode($sources);
        if($source->status == 'ok' && !empty($source->sources)){            
            file_put_contents("./dbase/sources.nws",json_encode($source->sources)); 
            
            $headers = array(
                'Accept: application/json',
                'Content-Type: application/json'
            );

            foreach($source->sources AS $ns){
                $url = 'https://newsapi.org/v2/top-headlines?sources='.$ns->id.'&apiKey='.$apiKey;                
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                curl_setopt($ch, CURLOPT_HEADER, 0);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
                $news_headings = curl_exec($ch);
                if(!curl_error($ch)){
                    $file_name = "NS".$ns->id.".nws";
                    $handle = fopen("./dbase/".$file_name, "w");
                    fwrite($handle, $news_headings);
                    fclose($handle);
                }
                sleep(2);
            }
        }
    }