<?php
require( '../../config.php' );
require( PHP_INC_PATH . 'common.php' );

$user = User::instance();
if ( !$user->isLoggedIn() )
{
	die();
}

if( isset( $_POST['method'] ) )
{
    //Add course function
    switch( $_POST['method'] )
    {
        case 'add-course':
            $retval = addCourse( $_POST['id'], $_POST['title'] );
            break;
            
        case 'get-courses':
            $retval = getCourses();
            break;
            
        default:
    }
} 
else if( isset( $_GET['method'] ) )
{
    //Add course function
    switch( $_GET['method'] )
    {
        case 'add-course':
            $retval = addCourse( $_GET['id'], $_GET['title'] );
            break;
            
        case 'get-courses':
            $retval = getCourses();
            break;
            
        default:
    }
    
} 

echo json_encode( $retval );

return;
/*
 * Add a course to the database.
 *
 * @param id the ID of the course
 * @param title 
 *
 * @return true | false
 */
function addCourse( $id, $title )
{
    global $courses;
    global $pusher;
    global $user;
    
    $retval = array( 'success' => false );
    
    if ( $courses->createCourse( $id, $title ) )
    {
        $uid = $user->getUserID( $_SESSION['email'] );
        
        // Try adding the creator immediately.
        if ( !$courses->addUserCourse( $uid, $id ) )
        {
            $uid = -2;
        }
        
        $retval['success'] = true;
        $courses->pushNewCourseToClients( $pusher, $id, $title, $uid );
    }
    
    return $retval;

}

/*
 * Fetch all courses from database.
 *
 * @return array of all courses.
 */
function getCourses()
{
    global $courses;
    global $user;
    
    if( $user->isLoggedIn() )
    {
		//$retval = $courses->getCourseList( null );
        $retval = $courses->getCourseList( $user->getUserID( $_SESSION['email'] ) );
    }
    else
    {
        $retval = $courses->getCourseList( null );
    }
    
    return $retval;
}
