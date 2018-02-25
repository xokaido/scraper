<?php 
class Google {

  private $url;
  private $html;
  private $proxy          = '';
  private $domain         = 'https://google.com/';
  private $searchResults  = [];
  private $mainSearchURL;

  public function __construct( $term = false )
  {
      if( $term )
        $this->search( $term );
  }
  public function search( $term )
  {
      $this->setMainSearchURL( $term );
      $this->setHTML( );
      $this->setSearchResults( );
  }
  public function getProxy( )
  {
    return $this->proxy;
  }
  public function setProxy( $proxy )
  {
    $this->proxy = $proxy;
  }
  public function getSearchResults( )
  {
    return $this->searchResults;
  }
  private function setSearchResults( )
  {
      $h3s = $this->html->find( '.g h3' ); 
      foreach( $h3s as $h3 )
      {
          $h3     = pq( $h3 );
          $regex  = '/q=(?<url>[^&]*)&/i';
          $href   = $h3->find( 'a' )->attr( 'href' );
          if( preg_match( $regex, $href, $matches, PREG_OFFSET_CAPTURE ) )
            $this->searchResults[] = $matches['url'][0];
      }
  }
  public function getMainSearchURL( )
  {
    return $this->mainSearchURL;
  }
  private function setMainSearchURL( $term )
  {
      $this->mainSearchURL = $this->domain . 'search?q='. str_replace( ' ', '+', $term );
  }
  public function getHTML( )
  {
    return $this->html;
  }
  private function setHTML( $url = false )
  {
      // $contents   = file_get_contents( '/tmp/google.html' );
      // $this->html = phpQuery::newDocument( $contents );
      // return true;
      $page_url   = ( $url ? $url : $this->mainSearchURL );
      $this->setURL( $url );

      $client     = new GuzzleHttp\Client([ 'proxy' => $this->proxy ]);
      $response   = $client->get( $page_url );
      $this->html = phpQuery::newDocument( $response->getBody( ) );
  }
  public function getURL( )
  {
    return $this->url;
  }
  private function setURL( $url )
  {
      $this->url = $url;
  }
  
}