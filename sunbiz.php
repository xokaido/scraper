<?php 
require_once( 'vendor/autoload.php' );


$term   = 'EL BRINCO 02 LLC';
$sunbiz = new Sunbiz( $term );
printf( "Agent Title: %s\nAgent Name: %s\nPDFs: \n", $sunbiz->getAgentTitle( ), $sunbiz->getAgentName( ) );
print_r( $sunbiz->getPDFs( ) );
$email = $sunbiz->getEmail( );
if( $email )
  die( 'Yes, with an email!' );
die( 'Without an email' );

exit;
require_once( 'pdf2text.php' );

// $file = 'http://search.sunbiz.org/Inquiry/CorporationSearch/ConvertTiffToPDF?storagePath=COR%5C2014%5C1003%5C63477525.Tif&documentNumber=P09000042519';
// $pdf  = file_get_contents( $file );
// $email = ' something.really-big_huge@with-a_domain.name.subdomain.and.net ';
// $pdf = file_get_contents( 'document2.pdf' );
// $pdf  =  new PdfToText ( 'document2.pdf' ) ;
// echo $pdf->Text;
// exit;
// if( preg_match( '/ ([^ ]*)@([^ ]*) /', $pdf, $matches, PREG_OFFSET_CAPTURE ) )
//   die( 'contains an email' );

Config::load();
$url        = 'http://search.sunbiz.org//Inquiry/CorporationSearch/SearchResultDetail?inquirytype=EntityName&directionType=Initial&searchNameOrder=ELBROTHERS%20L140000299760&aggregateId=flal-l14000029976-7a473b20-101a-4335-a3e2-d151cce33229&searchTerm=EL%20BRINCO%2002%20LLC&listNameOrder=ELBRINCO02%20L160001045650';
$contents   = file_get_contents( $url );
$html       = phpQuery::newDocument( $contents );
$files      = $html->find( '.detailSection > table > tr' );
echo $files;
exit;

$domain     = 'http://search.sunbiz.org';
$searchTerm = 'EL BRINCO 02 LLC';
$sunbiz     = $domain.
                  '/Inquiry/CorporationSearch/SearchResults?'.
                  'inquiryType=EntityName&'.
                  'searchNameOrder='. str_replace( ' ', '', $searchTerm ) .'&'.
                  'searchTerm='. urlencode( $searchTerm );

// $client   = new GuzzleHttp\Client( );
// $resp     = $client->get( $sunbiz );
// $contents = $resp->getBody( );
// file_put_contents('/tmp/sunbiz.html', $contents );
$contents = file_get_contents( '/tmp/sunbiz.html' );
$html     = phpQuery::newDocument( $contents );
$trs      = $html->find( '#search-results > table > tbody > tr' );

foreach( $trs as $tr )
{
    $tr     = pq( $tr );
    $status = strtolower( $tr->find( 'td:nth-child(3)' )->text( ) );
    $link   = $tr->find( 'td:first-child > a' )->attr( 'href' );
    $furl   = $domain .'/'. $link;
    if( $status == 'active' )
    {
      echo getCompanyPage( $furl );

      echo getPDFlist( $furl );
      echo $furl ."\n\n"; 
    }
}
function getImageLinks( $html )
{
  return true;
}
function getCompanyPage( $url )
{
  return true;
}
function getPDFlist( $url )
{
    return true;
}