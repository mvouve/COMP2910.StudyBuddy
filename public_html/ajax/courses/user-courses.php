<?php
require( '../../config.php' );
require( PHP_INC_PATH . 'common.php' );

if( isset( $_POST['method'] ) )
{
    switch( $_POST['method'] )
    {
        case 'add-course':
            $retval = addCourse( $_POST['id'] );
            break;
            
        
        default:
            break;
    }
}
else if( isset( $_GET['method'] )
{
    switch( $_GET['method'] )
    {
        case 'add-course':
            $retval = addCourse( $_GET['id'] );
            
            break;
        default:
            break;
    }
}

echo json_encode( $retval ); 

/*
 * Adds a course a user in the DB
 * 
 * @param $id the courseID to be added
 * @return true | false 
 */
function addCourse( $id )
{
    global $user;
    
    $retval = array( 'success' => false );
    
    if( addUserCouse( $user->getUserID( $_SESSION['email'] ), $id ) )
    {
        $retval = array( 'success' => true );
    }
    
    return $retval;
}

/*
 *
 *