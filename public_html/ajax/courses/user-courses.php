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
    switch( $_POST['method'] )
    {
        case 'add-course':
            $retval = addCourse( $_POST['id'] );
            
            break;
            
        case 'get-courses':
            $retval = getCourses();
            
            break;
            
        case 'remove-course':
            $retval = removeCourse( $_POST['id'] );
            
            break;
			
		case 'remove-all-courses':
            $retval = removeAllCourses();
            
            break;
            
        case 'toggle-visibility':
            $retval = toggleVisibility( $_POST['id'] );
            
            break;
        default:
        
            break;
    }
}
else if( isset( $_GET['method'] ) )
{
    switch( $_GET['method'] )
    {
        case 'add-course':
            $retval = addCourse( $_GET['id'] );
            
            break;

        case 'get-courses':
            $retval = getCourses();
            
            break;

        case 'remove-all-courses':
            $retval = removeAllCourses();
            
            break;
			
        case 'remove-course':
            $retval = removeCourse( $_GET['id'] );
            
            break;
			
		case 'toggle-visibility':
            $retval = toggleVisibility( $_GET['id'] );
            
            break;
			
        default:
            break;
    }
}

echo json_encode( $retval ); 


// just in case!
return;

/* 
 * gets the courses the current user is enrolled in.
 *
 * @return an array of the current users courses.
 */
function getCourses()
{
    global $courses;
    global $user;
    
	$uid = $user->getUserID( $_SESSION[ 'email' ] );
    return $courses->getUserCourseList( $uid );
}

/*
 * Adds a course a user in the DB
 * 
 * @param $id the courseID to be added
 * @return true | false 
 */
function addCourse( $id )
{
    global $courses;
    
    $retval = array( 'success' => false );
    
    if( $courses->addUserCourse( getUID(), $id ) )
    {
        $retval = array( 'success' => true );
    }
    
    return $retval;
}

/*
 * remove a course from a user in the DB
 * 
 * @param $id the courseID to be added
 * @return true | false 
 */
function removeCourse( $id )
{
    global $courses;
    $retval = array( 'success' => false ); 
    
    if( $courses->removeUserCourse( getUID(), $id ) )
    {
        $retval = array( 'success' => true ); 
    }
    
    return $retval;

}

/*
 * remove all courses from the logged in user in the DB
 * 
 * @return true | false 
 */
function removeAllCourses()
{
	global $courses;
	$retval = array();
	
	$retval['success'] = $courses->removeAllUserCourses( getUID() );
	return $retval;
}

/*
 * toggles the visiblity of a course in the DB
 * 
 * @param $id the courseID to be added
 * @return true | false 
 */
function toggleVisibility( $id )
{
    global $courses;
    $retval = array( 'success' => false ); 
    
    if( $courses->toggleVisibility( getUID(), $id ) )
    {
        $retval = array( 'success' => true ); 
    }
    
    return $retval;

}

/*
 * Helper function to get current sessions UserID.
 *
 * @return UID
 */
function getUID()
{
    global $user;
    
    return $user->getUserID( $_SESSION['email'] );
}