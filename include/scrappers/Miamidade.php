<?php 
class Miamidade {

  private $totalProperties;
  private $mainSearchTerm;
  private $mainJSON;
  private $address;
  private $properties = [];
  private $domain     = 'http://www.miamidade.gov/';
  private $start      = 1;
  private $end        = 200;
  private $url;
  private $proxy;

  public function __construct( $term = false )
  {
      if( $term )
        $this->search( $term );
  }
  public function search( $term )
  {
      $this->mainSearchTerm = $term;
      $this->setURL( );
      $this->setProperties( );
      $this->setTotalProperties( );
  }
  public function getProxy( )
  {
    return $this->proxy;
  }
  public function setProxy( $proxy )
  {
    $this->proxy = $proxy;
  }
  public function getProperties( )
  {
    return $this->properties;
  }
  private function setProperties( )
  {
      $this->setJSON( );
      foreach( $this->mainJSON->MinimumPropertyInfos as $property )
        $this->properties[] = $property;

  }
  public function getURL()
  {
    return $this->url;
  }
  private function setURL( $url = false )
  {
      if( $url ) 
        $this->url = $url;
      else
        $this->url  = $this->domain.
                         'PApublicServiceProxy/PaServicesProxy.ashx?'.
                         'Operation=GetAddress&'.
                         'clientAppName=PropertySearch&'.
                         'from='. $this->start .'&'.
                         'myAddress='. str_replace( ' ', '+', $this->mainSearchTerm ) .'&'.
                         'myUnit=&'.
                         'to='. $this->end;
  }
  public function getJSON( )
  {
    return $this->mainJSON;
  }
  private function setJSON( )
  {
      $headers        = [ 'referer' => $this->domain ];
      $client         = new GuzzleHttp\Client([ 'headers' => $headers,
                                                'proxy'   => $this->proxy
                                             ] );
      $response       = $client->get( $this->url );
      $this->mainJSON = json_decode( $response->getBody( ) );
  }
  public function getTotalProperties()
  {
    return $this->totalProperties;
  }
  private function setTotalProperties()
  {
      $this->totalProperties = $this->mainJSON->Total;
  }

}