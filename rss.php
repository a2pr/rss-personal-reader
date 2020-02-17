<?php
 function getContent() {
    //Thanks to https://davidwalsh.name/php-cache-function for cache idea
    $file = "./feed-cache.txt";
    $current_time = time();
    $expire_time = 5 * 60;
    $file_time = filemtime($file);

    if(file_exists($file) && ($current_time - $expire_time < $file_time)) {
        return file_get_contents($file);
    }
    else {
        $content = getFreshContent();
        file_put_contents($file, $content);
        return $content;
    }
}

 function getFreshContent(){
   $html='';
   $newsSource= array(
[
  'title'=>'Mangadex follow',
  'url'=>'https://mangadex.org/rss/follows/b13464ccc3f9977c33040d4dd5e964bd'
],
       [
           'title'=>'Reddit by New',
           'url'=>'https://www.reddit.com/r/manga/search.rss?q=%5BDISC%5D&restrict_sr=on&include_over_18=on&sort=new&t=all'
       ]
   );
    foreach($newsSource as $source){
        $html .= '<h2>'.$source['title'].'</h2>';
        $html .= getFeed($source['url']);
    }
    return $html;
}

 function getFeed($url){
    $html = '';
    $rss =  new SimpleXMLElement($url,0,true);

    $count = 0;
    $html .= '<ul>';

    if($rss->entry){
        foreach($rss->entry as $item) {
            $count++;
            if($count > 15){
                break;
            }
            $html .= '<li><a href="'.htmlspecialchars($item->link->attributes()).'">'.htmlspecialchars($item->title).'</a></li>';
        }
    }
    //reddit problem
    if($rss->channel->item){
        foreach($rss->channel->item as $item) {
            $count++;
            if($count > 7){
                break;
            }
            $html .= '<li><a href="'.htmlspecialchars($item->link).'">'.htmlspecialchars($item->title).'</a></li>';
        }
    }

    $html .= '</ul>';
    return $html;
}