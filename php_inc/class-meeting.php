<?php
// todo add properly formatted date checks.
class Meeting
{
    const MEETING_TABLE = 'Meeting';
    const USER_MEETING_TABLE = 'UserMeeting';
    const USER_COURSE_TABLE = 'UserCourse';
    const USER_TABLE = 'User';
    
    public function __construct()
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
     // TESTED READY TO GO.
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
        $sql->bindParam( ':startTime',  $startTime );
        $sql->bindParam( ':endTime',    $endTime );
        $sql->execute();
        
        // add user to the event they just created.
        $sql = 'INSERT INTO  ' . Meeting::USER_MEETING_TABLE . '
                    VALUES ( LAST_INSERT_ID(), :userID );';
        $sql = $db->prepare( $sql );
        $sql->bindParam( ':userID', $masterID );
        $sql->execute();
        
        return $db->commit();
    }

    /*
     * Add a meeting to the database.
     *
     * @param $courseID     the course the meeting will be studdying.
     * @param $meetingID    the ID of the meeting to be edited.
     * @param $comment      the comment associated with the meeting.
     * @param $location     where the meeting will be.
     * @param $maxBuddies   the maximum number of people for the meeting.
     * @param $startTime    The time the meeting starts.
     * @param $endTime      The time the meeting ends.
     *
     * @returns true on success, false on failure.
     */
     // TODO: VALIDATE DATE & TIMES
    public function editMeeting( $courseID,
                                 $meetingID,
                                 $comment,
                                 $location,
                                 $maxBuddies,
                                 $startTime,
                                 $endTime )
    {
        global $db;
        
        // Update event
        $sql = ' UPDATE ' . Meeting::MEETING_TABLE . '
                    SET courseID = :courseID, comment = :comment, 
                        location = :location, maxBuddies = :maxBuddies,
                        startTime = :startTime, endTime = :endTime
                    WHERE ID = :meetingID';
        $sql = $db->prepare( $sql );
        $sql->bindParam( ':courseID',   $courseID );
        $sql->bindParam( ':meetingID',  $meetingID );
        $sql->bindParam( ':comment',    $comment );
        $sql->bindParam( ':location',   $location );
        $sql->bindParam( ':maxBuddies', $maxBuddies );
        $sql->bindParam( ':startTime',  $startTime );
        $sql->bindParam( ':endTime',    $endTime );
        
        return $sql->execute();
    }
    
    /*
     * Cancel a meeting
     *
     * @param @meetingID
     *
     * @returns true on success, false on failure
     */
    public function cancelMeeting( $meetingID )
    {
        global $db;
        
        $sql = 'UPDATE ' . Meeting::MEETING_TABLE . '
                    SET canceled = \'T\'
                    WHERE ID = :meetingID;';
        $sql = $db->prepare( $sql );
        $sql->bindParam( ':meetingID' );
        
        return $sql->execute();
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
        
        $db->beginTransaction();
        // get the maximum people allowed in a meeting.
        $sql = 'SELECT maxBuddies
                    FROM ' .  Meeting::MEETING_TABLE . '
                    WHERE ID = :ID;';
        $sql = $db->prepare( $sql );
        $sql->bindParam( ':ID', $meetingID );
        $sql->execute();
        $maxUsers = $sql->fetch( PDO::FETCH_ASSOC );
        print_r( $maxUsers );
        $maxUsers = $maxUsers['maxBuddies'];
        
        //has to be room in an meeting to join.
        if( $maxUsers > $this->getCurrentUsers( $meetingID ) )
        {
            $sql = 'INSERT INTO ' . Meeting::USER_MEETING_TABLE . '
                        VALUES( :meetingID, :userID );';
            $sql = $db->prepare( $sql );
            $sql->bindParam( ':meetingID',  $meetingID );
            $sql->bindParam( ':userID',     $userID );
            $sql->execute();
        }
        
        return $db->commit();
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
    public function leaveMeeting( $userID, $meetingID )
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
        if( $this->isMaster( $userID, $meetingID ) )
        {
            //SQL statment for getting userIDs for other users attending this meeting.
            $sql = 'SELECT userID
                        FROM' . Meeting::USER_MEETING_TABLE . '
                        WHERE meetingID = :meetingID;';            
            $sql = $db->prepare( $sql );
            $sql->bindParam( ':meetingID', $meetingID );
            $sql->execute();
            
            //fetch the first row from the sql statment ( i.e. the next user )
            $newMasterID = $sql->fetch( PDO::FETCH_ASSOC );
            $newMasterID = $newMasterID['userID'];
            
            // If that row exists, make that person the new master.
            if( $newMasterID )
            {
                $sql = 'UPDATE' . Meeting::USER_MEETING_TABLE . '
                            SET masterID = :newMasterID
                            WHERE meetingID = :meetingID;';
                $sql = $db->prepare( $sql );
                $sql->bindParam( ':newMasterID', $newMasterID );
                $sql->bindParam( ':meetingID', $meetingID );
                $sql->execute();
            }
            
            // if there's no one else in the meeting delete the meeting.
            else
            {
                $sql = 'DELETE FROM' . Meeting::MEETING_TABLE . '
                            WHERE meetingID = :meetingID;';
                $sql = $db->prepare( $sql );
                $sql->bindParam( ':meetingID', $meetingID );
                $sql->execute();
            }
        }
        
        return $db->commit();
    }
    
    /*
     * Get details of a meeting
     *
     * @param $meetingID the ID of the meeting you're fetching details for.
     *
     * @return meeting details as an array.
     *
     */
    public function getMeetingDetails( $meetingID )
    {
        global $db;
        
        $sql = 'SELECT comment, courseID, location, startDate, endDate, maxBuddies
                    FROM ' . Meeting::MEETING_TABLE . ' m
                    WHERE m.ID = :meetingID;';
        $sql = $db->prepare( $sql );
        $sql-> bindParam( ':meetingID', $meetingID );
        $sql->execute();
        
        $sql = $sql->fetch( PDO::FETCH_ASSOC );
        
        $retval = array( 'discription'  => $sql['comment'],
                         'courseID'     => $sql['courseID'],
                         'location'     => $sql['location'],
                         'startDate'    => $sql['startDate'],
                         'endDate'      => $sql['endDate']
                        );
        return $retval;
    }
    
    /*
     * Get the number of users currently in a given meeting.
     *
     * @param $meetingID The meeting to count users from.
     *
     * @returns the current number of users in the meeting.
     */
    private function getCurrentUsers( $meetingID )
    {
        global $db;
        
        $sql = 'SELECT COUNT(1) AS TotalUsers
                    FROM' . Meeting::USER_MEETING_TABLE . '
                    WHERE meetingID = :meetingID';
        $sql = $db->prepare( $sql );
        $sql->bindParam( ':meetingID', $meetingID );
        $sql->execute();
        
        $totalUsers = $sql->fetch( PDO::FETCH_ASSOC );
        
        return $totalUsers['TotalUsers'];
    }
    
    /*
     * Fetch an array of users associated to a meeting.
     * 
     * @param $meetingID the meeting to fetch users for.
     *
     * @returns an array of meeting users.
     *
     */
    public function getMeetingBuddyList( $meetingID )
    {
        global $db;
        $retval = array();
        
        $sql = 'SELECT u.displayName
                    FROM ' . Meeting::USER_MEETING_TABLE . ' um
                        JOIN ' . Meeting::USER_TABLE . ' u
                            ON u.ID = um.userID
                        WHERE um.meetingID = :meetingID;';
                        
        $sql = $db->prepare( $sql );
        $sql->bindParam( ':meetingID', $meetingID );
        $sql->execute();
        
        $user = null;
        
        while( ( $user = $sql->fetch( PDO::FETCH_ASSOC ) ) != null )
        {
            $retval[] = $user['displayName'];
        }
        
        return $retval;
    }
    
    
    
    
    /*
     * A function to fetch meetings from the database.
     *
     * @param $userID
     *
     * @returns an array of filtered meetings.
     */
    public function getMeetingList( $userID )
    {
        global $db;
        $retval = array();
        $row = null;
        
        // Build SQL statement
        $sql = 'SELECT m.ID, m.masterID, m.courseID, m.location, m.startDate, um.userID as m_user, m.canceled
                FROM ' . Meeting::MEETING_TABLE . ' m
                    JOIN ' . Meeting::USER_COURSE_TABLE . ' uc
                        ON m.courseID = uc.courseID
                    LEFT JOIN ' . Meeting::USER_MEETING_TABLE . ' um
                        ON m.ID = um.meetingID AND uc.userID = um.userID
                WHERE uc.userID = :uid
                    AND uc.visible = \'T\'
                    AND m.endDate > NOW()
                ORDER BY m.startDate
                ;';
        
        // Execute the SQL
        $sql = $db->prepare( $sql );
        $sql->bindParam( ':uid', $userID );
        
        if ( !$sql->execute() )
        {
            return $retval;
        }
        
        // Loop through the results and organize the output
        while ( ( $row = $sql->fetch( PDO::FETCH_ASSOC ) ) != null )
        {
            $output = array(
                            'ID'        => $row['ID'],
                            'courseID'  => $row['courseID'],
                            'location'  => $row['location'],
                            'startDate' => $row['startDate']
                            );
            if ( $row['canceled'] == 'T' )
            {
                $output['canceled'] = true;
            }
            else
            {
                $output['canceled'] = false; 
            }
            // User is not signed-up for the meeting
            if ( is_null( $row['m_user'] ) )
            {
                $output['filter'] = 0;
            }
            // User created the meeting.
            else if ( $row['masterID'] == $userID )
            {
                $output['filter'] = 2;
            }
            // User is attending but did not create the meeting.
            else
            {
                $output['filter'] = 1;
            }
            
            $retval[] = $output;
        }
        
        return $retval;
    }
    
    /*
     * Checks if a user is the current meeting master.
     *
     * @param $userID the user ID to check.
     * @param $meetingID the meeting to check.
     * @return true is user is the master, false if the user is not the master.
     */
    public function isMaster( $userID, $meetingID )
    {
        global $db;
    
        $sql = 'SELECT masterID
                    FROM ' . Meeting::MEETING_TABLE . '
                    WHERE ID = :meetingID;';
        $sql = $db->prepare( $sql );
        $sql->bindParam( ':meetingID', $meetingID );
        $sql->execute();
        $sql = $sql->fetch( PDO::FETCH_ASSOC );
        
        $retval = ( $sql['masterID'] == $userID );
        // returns if the current user is the master or not.
        return $retval;
    }
}
