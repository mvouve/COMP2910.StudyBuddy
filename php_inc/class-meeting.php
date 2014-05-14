<?php
class Meeting
{
    const MEETING_TABLE = 'Meeting';
    const USER_MEETING_TABLE = 'UserMeeting';
    
    function __construct()
    {
    }
    
    /*
     * Add a meeting to the database.
     *
     * @param $courseID     the course the meeting will be studdying.
     * @param $masterID     the ID of the creator of the course.
     * @param $comment      the comment associated with the meeting.
     * @param $location     where the meeting will be.
     * @param $maxBuddies   the maximum number of people for the meeting.
     * @param $startTime    The time the meeting starts.
     * @param $endTime      The time the meeting ends.
     *
     * @returns true on success, false on failure.
     */
     // TRANSACTIONS UNTESTED.
	 // TODO: VALIDATE DATE & TIMES
    public function createMeeting( $courseID,
                                   $masterID,
                                   $comment,
                                   $location,
                                   $maxBuddies,
                                   $startTime,
                                   $endTime )
    {
        global $db;
        
        $db->beginTransaction();
        
        // create event.
        $sql = ' INSERT INTO ' . Meeting::MEETING_TABLE . '
                    ( courseID, masterID, comment, location, maxBuddies, startDate, endDate )
                VALUES
                    ( :courseID, :masterID, :comment, :location, :maxBuddies, :startTime, :endTime );';
        $sql = $db->prepare( $sql );
        $sql->bindParam( ':courseID',   $courseID );
        $sql->bindParam( ':masterID',   $masterID );
        $sql->bindParam( ':comment',    $comment );
        $sql->bindParam( ':location',   $location );
        $sql->bindParam( ':maxBuddies', $maxBuddies );
        $sql->bindParam( ':startDate',  $startDate );
        $sql->bindParam( ':endDate',    $endDate );
        $sql->execute();
        
        // add user to the event they just created.
        $sql = 'INSERT INTO  ' . Meeting::USER_MEETING_TABLE . '
                    VALUES ( ' . $db->lastInsertId . ', :userID );';
        $sql = $db->prepare( $sql );
        $sql->bindParam( ':userID', $masterID );
        $sql->execute();
        
        return $db->commit();
    }
    
    /*
     * Join an existing meeting.
     *
     * @param $meetingID    the meeting to join.
     * @param $userID       the id of the user joining the group.
     *
     * @return true on success false on failure.
     */
    public function joinMeeting( $meetingID, $userID )
    {
        global $db;
        
        $sql = 'INSERT INTO' . Meeting::USER_MEETING_TABLE . '
                    VALUES ( :meetingID, :userID );';
        $sql = $db->prepare( $sql );
        $sql->bindParam( ':meetingID',  $meetingID );
        $sql->bindParam( ':userID',     $userID );
        
        return $sql->execute();
    }
    
    /*
     * removes a user from the meeting.
     *
     * @param $userID
     * @param $meetingID
     * @param $masterID
     *
     * @returns true on success, false on failure.
     */
    public function leaveMeeting( $userID, $meetingID, $masterID )
    {
        global $db;
        
        $db->beginTransaction();
        
        // remove the user from the meeting.
        $sql = 'DELETE FROM' . Meeting::USER_MEETING_TABLE . '
                    WHERE meetingID = :meetingID AND userID = :userID;';
        $sql = $db->prepare( $sql );
        $sql->bindParam( ':meetingID',  $meetingID );
        $sql->bindParam( ':userID',     $userID );
        $sql->execute();
        
        // If the user leaving the meeting is the current master, change the master.
        if( $masterID == $userID )
        {
            $sql = 'SELECT userID
                        FROM' . Meeting::USER_MEETING_TABLE . '
                        WHERE meetingID = :meetingID;';
            $sql = $db->prepare( $sql );
            $sql->bindParam( ':meetingID', $meetingID );
            $sql->execute();
            $newMasterID = $sql->fetch( PDO::FETCH_ASSOC );
            $newMasterID = $newMasterID['userID'];
            
            // automaticly make someone in the meeting the new master.
            if( $newMasterID )
            {
                $sql = 'UPDATE' . Meeting::USER_MEETING_TABLE . '
                            SET masterID = :newMasterID
                            WHERE meetingID = :meetingID'
                $sql = $db->prepare( $sql );
                $sql->bindParam( ':newMasterID', $newMasterID );
                $sql->bindParam( ':meetingID', $meetingID );
                $sql->execute();
            }
            // if there's no one else in the meeting delete the meeting.
            else
            {
                $sql = 'DELETE FROM' .Meeting::MEETING_TABLE . '
                            WHERE meetingID = :meetingID;';
                $sql->$db->prepare( $sql );
                $sql->bindParam( ':meetingID', $meetingID );
                $sql->execute();
            }
        }
        
        return $db->commit();
    }
	
	/*
	 * Gets a list of all the meetings in the future from the server, and if the user is
	 * attending/the meetings master. ( can be used to see if the user is the master. )
	 *
	 * @return all meetings as an array.
	 *
	 */
	public function getAllMeetings()
	{
		global $db;
		$retval = array();
		
		$sql = 'SELECT *
					FROM' . Meetings::MEETINGS_TABLE . '
					WHERE endDate > ' . date('Y-m-d H:i:s') . ';';
}