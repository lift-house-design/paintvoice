<?  
class Network{

  var $ch;
  var $agents = array( 
    'Mozilla/5.0 (Windows NT 6.2; WOW64) AppleWebKit/534.57.2 (KHTML like Gecko) Version/5.1.7 Safari/534.57.2',
    'Mozilla/5.0 (Windows; U; Windows NT 6.2; cs-cz) AppleWebKit/534.55.3 (KHTML like Gecko) Version/5.1.3 Safari/534.53.10',
    'Mozilla/5.0 (Windows NT 6.2) AppleWebKit/534.57.2 (KHTML like Gecko) Version/5.1.7 Safari/534.57.2',
    'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.7.4) AppleWebKit/7534.56.5 (KHTML like Gecko) Version/5.1.7 Safari/7534.57.2 Raven for Mac/0.7.14665',
    'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.7.4) AppleWebKit/7534.56.5 (KHTML like Gecko) Version/5.1.7 Safari/7534.57.2');

  function __construct(){
    $this->ch = $this->start_curl_session();
  }

  function setCurlOptions($options){
    curl_setopt_array($this->ch, $options);
  }

  function get($url){
    curl_setopt($this->ch, CURLOPT_URL, $url);
    $webpage = curl_exec($this->ch);
    return $webpage;
  }

  function post($url, $data){
    if(is_array($data))
      $data = http_build_query($data);

    // set post options
    curl_setopt($this->ch, CURLOPT_URL, $url);
    curl_setopt($this->ch, CURLOPT_POST, true);
    curl_setopt($this->ch, CURLOPT_POSTFIELDS, $data);

    $webpage = curl_exec($this->ch);
    return $webpage;
  }

  function head($url)
  {
    // set head options
    curl_setopt($this->ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HEADER, true);
    curl_setopt($curl, CURLOPT_NOBODY, true);

    $webpage = curl_exec($this->ch);
    return $webpage;
  }

  function rand_user_agent()
  {
    return $this->agents[array_rand($this->agents)];    
  }
 
  function start_curl_session() {
    $ch = curl_init();
    $time = time();

    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
      'X-Requested-With: XMLHttpRequest',
      'Content-Type: application/x-www-form-urlencoded; charset=UTF-8',
      'Connection: keep-alive',
      'DNT: 1',
      //'Accept-Encoding: text/html',
      'Accept-Language: en-us,en;q=0.5',
      'Accept=application/json, text/javascript, */*; q=0.01'
    ));
 
    //curl_setopt($ch, CURLOPT_HEADER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CAPATH, __DIR__ . '/cacert.pem');
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($ch, CURLOPT_SSLVERSION, 3);
    curl_setopt($ch, CURLOPT_COOKIEFILE, __DIR__.'/cookies/'.$time);
    curl_setopt($ch, CURLOPT_COOKIEJAR, __DIR__.'/cookies/'.$time);
    curl_setopt($ch, CURLOPT_USERAGENT, $this->rand_user_agent());

    return $ch;
  }
  function get_multi($urls,$options){
    // create both cURL resources
    $chs = array();
    $pages = array();
    $mh = curl_multi_init();

    foreach($urls as $i => $url)
    {
      $chs[$i] = $this->start_curl_session();
      curl_setopt($chs[$i], CURLOPT_URL, $url);
      if(!empty($options))
        curl_setopt_array($chs[$i], $options);
      curl_multi_add_handle($mh,$chs[$i]);
    }

    $active = null;
    //execute the handles
    do {
      $mrc = curl_multi_exec($mh, $active);
    } while ($mrc == CURLM_CALL_MULTI_PERFORM);

    while ($active && $mrc == CURLM_OK) {
        if (curl_multi_select($mh) != -1) {
            do {
                $mrc = curl_multi_exec($mh, $active);
              usleep(1000);
            } while ($mrc == CURLM_CALL_MULTI_PERFORM);
        }
      usleep(1000);
    }

    foreach($urls as $i => $url)
    {
      $pages[$i] = curl_multi_getcontent($chs[$i]);
      unset($urls[$i]);
      curl_multi_remove_handle($mh, $chs[$i]);
      curl_close($chs[$i]);
    }
    curl_multi_close($mh);
    $this->parse_headers($pages);
    return $pages;
  }

  function parse_headers(&$pages)
  {
    foreach($pages as $i => $page)
    {
      do{
        $tmp = explode("\r\n\r\n", $page, 2);
        if(empty($tmp[1]))
          $tmp[1] = '';
        $page = $tmp[1];
      }while(strpos($tmp[1],'HTTP/') === 0);
      list($head, $body) = $tmp; 
      preg_match_all('/([^\r\n:]+): ([^\r\n]+)(\r\n|$)/s',$head,$matches);
      if(empty($matches[1]))
      {
        $pages[$i] = array('head' => array(), 'body' => '');
        continue;
      }
      foreach($matches[1] as $j => $match)
        $headers[trim($match)] = trim($matches[2][$j]);
      $pages[$i] = array('head' => $headers, 'body' => trim($body));
    }
  }
}
?>
