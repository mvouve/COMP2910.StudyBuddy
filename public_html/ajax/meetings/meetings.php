<?php
require( '../../config.php' );
require( PHP_INC_PATH . 'common.php' );

// Ensure the user is logged in before letting them change anything
$user = User::instance();
if ( !$user->isLoggedIn() )
{
	die();
}

$meetings = new Meeting();
$uid = $user->getUserID( $_SESSION['email'] );

// Call the appropriate function based on the requested method.
if ( isset( $_POST['method'] ) )
{
    $retval = array();
    
    switch( $_POST['method'] )
    {
        case 'get-meetings':
            $retval = getMeetings();
            break;
            
        case 'get-meeting-details':
            $retval = getMeetingDetails( $_POST['ID'] );
            break;
            
        case: 'create-meeting':
            $retval = createMeeting( $_POST['courseID'],
                                     $_POST['description'],
                                     $_POST['location'],
                                     $_POST['maxBuddies'],
                                     $_POST['startTime'],
                                     $_POST['endTime'] );
            break;
            
        case 'edit-meeting':
            $retval = editMeeting( $_POST['ID'],
                                   $_POST['courseID'],
                                   $_POST['description'],
                                   $_POST['location'],
                                   $_POST['maxBuddies'],
                                   $_POST['startTime'],
                                   $_POST['endTime'] );
            break;
            
        case 'cancel-meeting':
            $retval = cancelMeeting( $_POST['ID'] );
            break;
            
        case 'join-meeting':
            $retval = joinMeeting( $_POST['ID'] );
            break;
            
        case 'leave-meeting':
            $retval = leaveMeeting( $_POST['id'] );
            break;
            
        default:
            break;
    }
    
    // Return any return values as JSON.
    echo json_encode( $retval );
    return;
}

/*
 * Get the list of meetings relevant to the logged in user.
 */
function getMeetings()
{
    return $meetings->getMeetingList( $uid );
}

/*
 * Get the details of a meeting, including current attendees.
 */
function getMeetingDetails( $meetingID )
{
    $ret = $meetings->getMeetingDetails( $meetingID );
    $ret['buddies'] = $meetings->getMeetingBuddyList( $meetingID );
    return ret;
}

/*
 * Create a new Meeting
 */
function createMeeting( $courseID, $description, $location, $maxBuddies, $startTime, $endTime )
{
    $ret = array( 'success' => false );
    $created = $meetings->createMeeting( $courseID,
                                         $uid,
                                         $description,
                                         $location,
                                         $maxBuddies,
                                         $startTime,
                                         $endTime );
    
    if ( $created != -1 )
    {
        $ret['success'] = true;
        
        // Push the Meeting through Pusher
        global $pusher;
        $data = array( 'ID' => $created, 'courseID' => $courseID, 'creator' => $uid,
            'location' => $location, 'startTime' => $startTime );
        $pusher->trigger( 'private-' . $courseID, 'meeting_added', $data ); 
    }
    
    return $ret;
}

/*
 * Edit a Meeting
 */
function editMeeting( $meetingID, $courseID, $description, $location, $maxBuddies, $startTime,
                      $endTime )
{
    $ret = array( 'success' => false );
    
    // Ensure the editting user is the master of the meeting.
    if ( !$meetings->isMaster( $uid, $meetingID ) )
    {
        return $ret;
    }
    
    // Edit the meeting
    $editted = $meetings->editMeeting( $courseID,
                                       $meetingID,
                                       $description,
                                       $location,
                                       $maxBuddies,
                                       $startTime,
                                       $endTime );
    
    if ( $editted )
    {
        $ret['success'] = true;
        
        // Push the Edits through Pusher
        global $pusher;
        $data = array( 'ID' => $meetingID, 'courseID' => $courseID, 'creator' => $uid,
            'location' => $location, 'startTime' => $startTime );
        $pusher->trigger( 'private-' . $courseID, 'meeting_editted', $data ); 
    }
    
    return $ret;
}

/*
 * Cancel a Meeting.
 */
function cancelMeeting( $meetingID )
{
    $ret = array( 'success' => false );

    if ( !$meetings->isMaster( $uid, $meetingID ) )
    {
        return $ret;
    }
    
    if ( $meetings->cancelMeeting( $meetingID ) )
    {
        $ret['success'] = true;
        
        // Push the cancellation through Pusher
        global $pusher;
        $data = array( 'ID' => $meetingID );
        $pusher->trigger( 'private-' . $courseID, 'meeting_cancelled', $data ); 
    }
    
    return $ret;
}

/*
 * Cause the User to join a meeting
 */
function joinMeeting( $meetingID )
{
    return array( 'success' => $meetings->joinMeeting( $meetingID, $uid ) );
}

/*
 * Cause the User to leave a meeting
 */
function leaveMeeting( $meetingID )
{
    return array( 'success' => $meetings->leaveMeeting( $meetingID, $uid ) );
}







