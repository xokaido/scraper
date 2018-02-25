<?php

function checkForEmail( $text )
{
    $regex     = '/(?<email>[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4})/i';
    if( preg_match_all( $regex, $text, $emails, PREG_PATTERN_ORDER ) )
      return trim( $emails['email'][0] );
    return false;
}

