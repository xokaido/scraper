<?php

require_once( 'vendor/autoload.php' );

$search = 'EL BRINCO 02 LLC contact info';
$google = new Google( );
$google->setProxy( $proxy );
$google->search( $search );
print_r( $google->getSearchResults( ) );
exit;
$address    = '36 nw 6 ave';
// $address = '111 nw 1 st';
$miami           = new Miamidade( $address );
$properties      = $miami->getProperties( );
$totalProperties = $miami->getTotalProperties( );

foreach( $properties as $property )
{
    $owner = $property->Owner1;
    if( stristr( $owner, 'llc'))
    {
        $sunbiz = new Sunbiz( $owner );
        $pdfs   = $sunbiz->getPDFs( );
        $email  = $sunbiz->getEmail( );
        $agent  = $sunbiz->getAgentName( );
        $title  = $sunbiz->getAgentTitle( );

        foreach( $pdfs as $pdf )
          process_pdf( $pdf );
    }
}

function process_pdf( $pdf )
{
  return true;
}

