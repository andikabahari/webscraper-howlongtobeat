<?php

/**
 * HowLongToBeat Class
 *
 * @author Andika Bahari
 * @license MIT License
 */
class HowLongToBeat
{

  /**
   * @var string
   */
  private $baseURL = 'https://howlongtobeat.com/search_results.php?page=1';

  /**
   * @var string
   */
  private $gameURL = 'https://howlongtobeat.com/game.php?id=';

  /**
   * @var string
   */
  private $userAgent = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:67.0) Gecko/20100101 Firefox/67.0';

  /**
   * @param int $id
   * @param bool $jsonMode
   * @return mixed
   */
  public function get($id, $jsonMode=FALSE)
  {
    $content = $this->curl($this->gameURL, $id, 'GET');

    $regex = array(
      'title'         => '/\<div class\=\"profile\_header shadow\_text\"\>' . "\n" . '(.*?)\<\/div\>/',
      'main_story'    => '/Main Story\<\/h5\>' . "\n" . '\<div\>(.*?)\<\/div\>/',
      'main_extra'    => '/Main \+ Extras\<\/h5\>' . "\n" . '\<div\>(.*?)\<\/div\>/',
      'completionist' => '/Completionist\<\/h5\>' . "\n" . '\<div\>(.*?)\<\/div\>/',
      'all_styles'    => '/All Styles\<\/h5\>' . "\n" . '\<div\>(.*?)\<\/div\>/',
      'image'         => '/\<img class\=\"shadow\_box\" src\=\'(.*?)\' \/\>/'
    );

    $detail = array();

    foreach ($regex as $key => $value)
    {
      $detail[$key] = preg_match($value, $content, $matches)
        ? trim($matches[1], ' ')
        : NULL;
    }

    return $jsonMode === TRUE
      ? json_encode($detail, JSON_PRETTY_PRINT)
      : $detail;
  }

  /**
   * @param string $title
   * @param bool $jsonMode
   * @param int $limit
   * @return mixed
   */
  public function search($title, $jsonMode=FALSE, $limit=5)
  {
    $content = $this->curl($this->baseURL, $title, 'POST');
    $ids = $this->getGameIds($content);

    // Max execution time is 3600 seconds
    ini_set('max_execution_time', 3600);

    $detais = array();
    $index  = 0;

    for ($index; $index < $limit; $index++)
    {
      $details[] = $this->get($ids[$index], FALSE);
    }

    return $jsonMode === TRUE
      ? json_encode($details, JSON_PRETTY_PRINT)
      : $details;
  }

  /**
   * @param string $content
   * @return array
   */
  private function getGameIds($content)
  {
    $regex = '/href\=\"game\.php\?id\=(.*?)\"\>/';

    return preg_match_all($regex, $content, $matches)
      ? $matches[1]
      : NULL;
  }

  /**
   * @param string $url
   * @param string $query
   * @param string $method
   * @return mixed
   */
  private function curl($url, $query, $method)
  {
    $options = array();

    if ($method == 'GET')
    {
      $url .= $query;
      $options = array(
        CURLOPT_RETURNTRANSFER => TRUE,
        CURLOPT_HEADER         => FALSE,
        CURLOPT_USERAGENT      => $this->userAgent,
        CURLOPT_SSL_VERIFYHOST => FALSE,
        CURLOPT_SSL_VERIFYPEER => FALSE
      );
    }
    else if ($method == 'POST')
    {
      $requestBody = 'queryString=' . rawurlencode($query) . '&t=games&sorthead=popular&sortd=Normal Order&plat=&length_type=main&length_min=&length_max=&detail=';
      $options = array(
        CURLOPT_RETURNTRANSFER => TRUE,
        CURLOPT_POST           => TRUE,
        CURLOPT_POSTFIELDS     => $requestBody,
        CURLOPT_HEADER         => FALSE,
        CURLOPT_USERAGENT      => $this->userAgent,
        CURLOPT_SSL_VERIFYHOST => FALSE,
        CURLOPT_SSL_VERIFYPEER => FALSE
      );
    }
    else
    {
      return;
    }

    $ch = curl_init($url);

    curl_setopt_array($ch, $options);

    $content = curl_exec($ch);
    $errno   = curl_errno($ch);
    $errmsg  = curl_error($ch);

    curl_close($ch);

    empty($errno) OR exit($errmsg);

    return $content;
  }
}
