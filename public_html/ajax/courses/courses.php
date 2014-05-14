<?php
require( '../../config.php' );
require( PHP_INC_PATH . 'common.php' );

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
            $retval = getCourse();
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
    
    $retval = array( 'success' => false );
    
    if ( $courses->createCourse( $id, $title ) )
    {
        $retval['success'] = true;
        //$courses->pushNewCourseToClients( $pusher, $id, $title );
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
