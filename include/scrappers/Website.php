<?php 
class Website {

  public static function checkForEmail( $url, $proxy = false )
  {
      $client    = new GuzzleHttp\Client([ 'proxy' => $proxy ]);
      $response  = $client->get( $url );
      $html      = phpQuery::newDocument( $response->getBody( ) );
      $regex     = '/(?<email>[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4})/i';
      if( preg_match_all( $regex, $html->text( ), $emails, PREG_PATTERN_ORDER ) )
        return trim( $emails['email'][0] );
      return false;
  }
  
}