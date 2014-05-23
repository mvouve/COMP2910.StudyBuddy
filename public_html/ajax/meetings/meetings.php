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

date_default_timezone_set( 'America/Los_Angeles' );

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
            
        case 'create-meeting':
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
            $retval = cancelMeeting( $_POST['ID'], $_POST['courseID'] );
            break;
            
        case 'join-meeting':
            $retval = joinMeeting( $_POST['id'] );
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
	global $meetings, $uid;
	
    return $meetings->getMeetingList( $uid );
}

/*
 * Get the details of a meeting, including current attendees.
 */
function getMeetingDetails( $meetingID )
{
	global $meetings;

    $ret = $meetings->getMeetingDetails( $meetingID );
    $ret['buddies'] = $meetings->getMeetingBuddyList( $meetingID );
    
    return $ret;
}

/*
 * Create a new Meeting
 */
function createMeeting( $courseID, $description, $location, $maxBuddies, $startTime, $endTime )
{
	global $meetings, $uid;
	
	$sTime = DateTime::createFromFormat('Y-m-d H:i:s', $startTime)->format('Y-m-d H:i:s');
	$eTime = DateTime::createFromFormat('Y-m-d H:i:s', $endTime)->format('Y-m-d H:i:s');
	
    $ret = array( 'success' => false );
    $created = $meetings->createMeeting( $courseID,
                                         $uid,
                                         $description,
                                         $location,
                                         $maxBuddies,
                                         $sTime,
                                         $eTime );
    
    if ( $created != -1 )
    {
        $ret['success'] = true;
        
        // Push the Meeting through Pusher
        global $pusher;
        $data = array( 'ID' => $created, 'courseID' => $courseID, 'creator' => $uid,
            'location' => $location, 'startTime' => $startTime );
        $pusher->trigger( 'private-' . $courseID, 'meeting_added', $data ); 
        
        // Push to the user who created it to create their notification in phonegap app
        $data = array( 'meetingID' => $created, 'title' => 'StudyBuddy Reminder: ' . $courseID,
                       'message' => 'Your study meeting for ' . $courseID .
                                    ' starts in 30 minutes in ' . $location . '!',
                       'date' => date_sub( DateTime::createFromFormat('Y-m-d H:i:s', $startTime),
                                           date_interval_create_from_date_string('30 minutes'))
                     );
        $pusher->trigger( 'study_buddy_user_' . $uid, 'create_notification', $data );
    }
    
    return $ret;
}

/*
 * Edit a Meeting
 */
function editMeeting( $meetingID, $courseID, $description, $location, $maxBuddies, $startTime,
                      $endTime )
{
	global $meetings, $uid;
	
    $ret = array( 'success' => false );
	
	$sTime = DateTime::createFromFormat('Y-m-d H:i:s', $startTime)->format('Y-m-d H:i:s');
	$eTime = DateTime::createFromFormat('Y-m-d H:i:s', $endTime)->format('Y-m-d H:i:s');
    
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
        
        // Push to the user who editted it to edit their notification in phonegap app
        $data = array( 'meetingID' => $meetingID, 'title' => 'StudyBuddy Reminder: ' . $courseID,
                       'message' => 'Your study meeting for ' . $courseID .
                                    ' starts in 30 minutes in ' . $location . '!',
                       'date' => date_sub( DateTime::createFromFormat('Y-m-d H:i:s', $startTime), 
                                           date_interval_create_from_date_string('30 minutes'))
                     );
        $pusher->trigger( 'study_buddy_user_' . $uid, 'edit_notification', $data );
    }
    
    return $ret;
}

/*
 * Cancel a Meeting.
 */
function cancelMeeting( $meetingID, $courseID )
{
	global $meetings, $uid;

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
        
        // Push to the user who cancelled it to cancel their notification in phonegap app
        $data = array( 'meetingID' => $meetingID );
        $pusher->trigger( 'study_buddy_user_' . $uid, 'cancel_notification', $data );
    }
    
    return $ret;
}

/*
 * Cause the User to join a meeting
 */
function joinMeeting( $meetingID )
{
	global $pusher, $meetings, $uid;

    $ret =  array( 'success' => $meetings->joinMeeting( $meetingID, $uid ) );
    
    if ( $ret['success'] )
    {
        $meeting = $meetings->getMeetingDetails( $meetingID );
        
        $sTime = new DateTime( $meeting['startDate'] );
        
        // Push to the user who created it to create their notification in phonegap app
        $data = array( 'meetingID' => $meetingID,
                       'title' => 'StudyBuddy Reminder: ' . $meeting['courseID'],
                       'message' => 'Your study meeting for ' . $meeting['courseID'] .
                                    ' starts in 30 minutes in ' . $meeting['location'] . '!',
                       'date' => date_sub($sTime, date_interval_create_from_date_string('30 minutes'))
                     );
        $pusher->trigger( 'study_buddy_user_' . $uid, 'create_notification', $data );
    }
    
    return $ret;
}

/*
 * Cause the User to leave a meeting
 */
function leaveMeeting( $meetingID )
{
	global $pusher, $meetings, $uid;

    $ret = array( 'success' => $meetings->leaveMeeting( $uid, $meetingID ) );
    
    if ( $ret['success'] )
    {
        // Push to the user who left it to cancel their notification in phonegap app
        $data = array( 'meetingID' => $meetingID );
        $pusher->trigger( 'study_buddy_user_' . $uid, 'cancel_notification', $data );
    }
    
    return $ret;
}







