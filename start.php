<?php

require_once( 'vendor/autoload.php' );

// The configs should be in the .env file
Config::load();

// The Goutte scrapper
$client   = new Goutte\Client();
$base_uri = 'http://goodwilldelivery.ge/category.aspx?id=6';
$crawler  = $client->request( 'GET', $base_uri );
$link     = $crawler->selectLink( 'მზა კვება' )->link();
$pcrawler = $client->click( $link );

// Logging and DB
$log  = Logger::get( 'scrapper' );
$db   = Db::get( );
$stm  = $db->prepare( 'SHOW TABLES' );
$stm->execute( );
$log->debug( 'The SHOW TABLES are these: ', $stm->fetchAll() );

$pcrawler->filter( "#ProductMenu > a " )->each( function( $a ) use ( $log ) { 

  $thing = sprintf( "%s -> %s\n", $a->text(), $a->attr('href') );
  $log->debug( 'The DEBUG message!', ( is_array( $thing ) ? $thing : [ $thing ] ) );

});

// GuzzleHttp and phpQuery version
$client = new GuzzleHttp\Client([ 'base_uri' => $base_uri ]);
$resp = $client->get( '/category.aspx?id=6' );
$html = phpQuery::newDocument( $resp->getBody() );

$things = $html->find( '#ProductMenu > a' );
foreach( $things as $a )
{
    $a = pq( $a );
    printf( "%s -> %s\n", $a->text(),$a->attr( 'href' ) );
}

