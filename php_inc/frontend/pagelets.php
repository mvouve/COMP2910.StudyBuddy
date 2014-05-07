<?php
function renderPagelet( $pagelet, $replacements )
{
    ob_start();
    include( WWW_PATH . 'pagelets/' . $pagelet );
    $output = ob_get_clean();
    
    if ( is_array( $replacements ) )
    {
        foreach ( $replacements as $tag => $value )
        {
            $output = str_replace( $tag, $value, $output );
        }
    }
    
    echo $output;
}