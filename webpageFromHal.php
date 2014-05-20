<?php
// no direct access
defined('_JEXEC') or die;
jimport( 'joomla.plugin.plugin' );

class plgContentWebpagefromhal extends JPlugin
{

  public function __construct(&$subject, $params )
  {
    parent::__construct( $subject, $params );
  }

  public function onContentPrepare($context, &$article, &$params, $offset = 0)
  {
   
    // Get Article Text
    $text = &$article->text;

    $text = html_entity_decode($text);

    // Change Article Text

    // Check for tag
    if (!preg_match('/\{\{\s*type\="webpage_from_hal"([^\}]+)\}\}/', $text, $matches)) {
      JFactory::getApplication()->enqueueMessage('webpage_from-hal: No tag match');
      return true;
    }
   
    // Check url syntax and get url
    if (!preg_match("#url=\"([^\"]+)\"#", strip_tags($matches[1]), $uris)) {
      JError::raiseNotice( 100, 'webpage_from_hal: Tag found but syntax error with url' );
      return true;
    }
 
    // parse url and check IP address
    $infos = parse_url($uris[1]);
    $ip = gethostbyname($infos['host']);

    if ($ip != '193.48.96.10') {
      //  JError::raiseError( 4711, 'webpage_from_hal: Invalid url' );
      JError::raiseNotice( 100, 'webpage_from_hal: Invalid url' );        
      return true;
    }
    
    /* get html content via CURL */

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $uris[1]);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $user_agent = $_SERVER['HTTP_USER_AGENT'];                           
    curl_setopt($ch, CURLOPT_USERAGENT, $user_agent);
    curl_setopt($ch, CURLINFO_HEADER_OUT, true);
    $content=curl_exec($ch);
    if (false==$content)  JError::raiseNotice( 100, 'webpage_from_hal: Couldn\'t get content from given url' ); 
    curl_close($ch);

    // process   
    $dom = new DomDocument('1.0', 'UTF-8');
    $dom->preserveWhiteSpace = false;

    $str = mb_convert_encoding($content, "HTML-ENTITIES");
    $dom->loadHTML($str);
    $xpath = new DOMXpath($dom);
    $entries = $xpath->query('//div[@id="res_script"]');

    if ($entries->length == 0) {
      JError::raiseNotice( 100, 'webpage_from_hal: Can\'t localize <div id="res_script">' );    
      return true;
    }

    $res_script = $dom->saveXML($entries->item(0));

    //replace text in article
    $text = str_replace($matches[0], $res_script, $text);

    return true;
  }
}


