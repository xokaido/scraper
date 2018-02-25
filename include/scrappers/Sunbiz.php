<?php
class Sunbiz {

  private $url;
  private $email;
  private $nextPage;
  private $mainSearchURL;
  private $mainSearchTerm;
  private $detailedSearchURL;
  private $agentTitle;
  private $agentName  = false;
  private $domain     = 'http://search.sunbiz.org';
  private $PDFs       = [];
  private $proxy;

  public function __construct( $term = false )
  {
      if( $term )
        $this->search( $term );
  }
  public function search( $term )
  {
        $this->mainSearchTerm = $term;
        $this->setMainSearchURL( );
        $this->setHTML( );
        $this->processMainSearchPage( );
  }
  public function getProxy( )
  {
    return $this->proxy;
  }
  public function setProxy( $proxy )
  {
    $this->proxy = $proxy;
  }
  private function processMainSearchPage( )
  {
      $trs  = $this->html->find( '#search-results > table > tbody > tr' );
      foreach( $trs as $tr )
      {
          $tr         = pq( $tr );
          $title      = strtolower( $tr->find( 'td:nth-child(0) > a' )->text( ) );
          $status     = strtolower( $tr->find( 'td:nth-child(3)' )->text( ) );
          $href       = $tr->find( 'td:first > a' )->attr( 'href' );
          $companyURL = $this->domain .'/'. $href;
          if( $title  == strtolower( $this->mainSearchTerm ) && $status == 'active' )
          {
              $this->setHTML( $companyURL );
              $this->setAgentName( );
              $this->setPDFs( );
              $this->setAgentTitle( );
              $this->setEmail( );
              break;
          }
      }
  }
  public function getEmail( )
  {
    return $this->email;
  }
  private function setEmail( )
  {
      $text  = $this->html->text( );
      $regex = '/(?<email>[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4})/i';

      if( preg_match_all( $regex, $text, $matches, PREG_PATTERN_ORDER ) )
        $this->email = ( isset( $matches['email'] ) && !empty( $matches['email'] ) ) ? $matches['email'][0] : '';
  }
  public function getAgentName( )
  {
    return $this->agentName;
  }
  private function setAgentName( )
  {
      $name = $this->html->find( '.detailSection:nth-child(6) > span:nth-child(2)' )
                         ->text( );
      $this->agentName = trim( $name );
  }
  public function getAgentTitle( )
  {
    return $this->agentTitle;
  }
  private function setAgentTitle( )
  {
      $title = $this->html->find( '.detailSection:nth-child(7)' );
      $title->find( 'span:first' )->remove( );
      $title->find( 'span:first' )->remove( );
      $this->agentTitle = trim( preg_replace( '/\s+/', ' ', $title->text( ) ) );
  }
  public function getPDFs( )
  {
    return $this->PDFs;
  }
  private function setPDFs( )
  {
      $pdf_trs = $this->html->find( '.detailSection:last > table > tr' );
      foreach( $pdf_trs as $tr )
      {
          $tr = pq( $tr );
          $pdf_url = $tr->find( 'td:first > a' )->attr( 'href' );
          $this->PDFs[] = $this->domain . '/'. $pdf_url;
      }
  }
  public function getURL( )
  {
    return $this->url;
  }
  private function setURL( $url )
  {
      $this->url = $url;
  }
  public function getHTML( )
  {
    return $this->html;
  }
  private function setHTML( $url = false )
  {
      $page_url   = ( $url ? $url : $this->mainSearchURL );
      $this->setURL( $url );
      $client         = new GuzzleHttp\Client([ 'proxy'   => $this->proxy ]);
      $response   = $client->get( $page_url );
      $this->html = phpQuery::newDocument( $response->getBody( ) );
  }
  public function getMainSearchURL( )
  {
    return $this->mainSearchURL;
  }
  private function setMainSearchURL( )
  {
      $this->mainSearchURL = $this->domain .
                      '/Inquiry/CorporationSearch/SearchResults?'.
                      'inquiryType=EntityName&'.
                      'searchNameOrder='. str_replace( ' ', '', $this->mainSearchTerm ) .'&'.
                      'searchTerm='. urlencode( $this->mainSearchTerm );
  }
}