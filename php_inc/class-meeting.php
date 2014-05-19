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
        
        
        // get the maximum people allowed in a meeting.
        $sql = 'SELECT maxBuddies
                    FROM' .  Meeting::MEETING_TABLE . '
                    WHERE meetingID = :meetingID;';
        $sql = $db->prepare();
        $sql->bindParam( ':meetingID', $meetingID );
        $sql->execute();
        $maxUsers = $sql->fetch( PDO::FETCH_ASSOC );
        $maxUsers = $maxUsers['$maxBuddies'];
        
        //has to be room in an meeting to join.
        if( $maxUsers > getCurrentUsers( $meetingID ) )
        {
            $sql = 'INSERT INTO' . Meeting::USER_MEETING_TABLE . '
                        VALUES ( :meetingID, :userID );';
            $sql = $db->prepare( $sql );
            $sql->bindParam( ':meetingID',  $meetingID );
            $sql->bindParam( ':userID',     $userID );
        }
        
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
     * Gets all the meetings for a users classes.
     *
     * @param $userID the ID of the current user.
     *
     * @return all meetings as an array.
     */
     public function getUserClassMeetings( $userID )
     {
        global $db;
        $retval = array();
        
        $sql = 'SELECT m.ID, m.courseID, m.location, m.startDate
                    FROM uc.' . Meeting::USER_COURSE_TABLE . '
                        JOIN m.' . Meeting::MEETING_TABLE . '
                            ON uc.courseID = m.courseID
                    WHERE uc.userID = :userID );';
                    
        $sql = $db->prepare( $sql );
        $sql->bindParam( ':userID', $userID );
        $sql->execute();
        
        $result = null;
        
        while( ( $result = $sql->fetch( PDO::FETCH_ASSOC ) ) != null )
        {
            $retval[] = array( 'meetingId'      => $result['m.ID'],
                               'courseId'       => $result['m.courseID'],
                               'location'       => $result['m.location'],
                               'date'           => $result['m.startDate']);
        }
        
        return $retval;
    }

    /*
     * Gets all the meetings the user is the meeting master for.
     *
     * @param $userID the ID of the current user.
     *
     * @return all meetings as an array.
     */ 
    public function getUserMasterMeetings( $userID )
    {
        global $db;
        $retval = array();
        
        $sql = 'SELECT ID, courseID, location, startDate
                    FROM ' . Meeting::MEETING_TABLE . '
                    WHERE masterID = :masterID );';
                    
        $sql = $db->prepare( $sql );
        $sql->bindParam( ':masterID', $userID );
        $sql->execute();
        
        $result = null;
        
        while( ( $result = $sql->fetch( PDO::FETCH_ASSOC ) ) != null )
        {
            $retval[] = array( 'meetingId'      => $result['ID'],
                               'courseId'       => $result['courseID'],
                               'location'       => $result['location'],
                               'date'           => $result['startDate']);
        }
        
        return $retval; 
    }

    /*
     * Gets all the meetings a user has joined.
     *
     * @param $userID the ID of the current user.
     *
     * @return all meetings as an array.
     */ 
    public function getUserJoinedMeetings( $userID )
    {
        global $db;
        $retval = array();
        
        $sql = 'SELECT m.ID, m.courseID, m.location, m.startDate
                    FROM um.' . Meeting::USER_MEETING_TABLE . '
                        JOIN m.' . Meeting::MEETING_TABLE . '
                            ON uc.meetingID = m.ID
                    WHERE um.userID = :userID );';
                    
        $sql = $db->prepare( $sql );
        $sql->bindParam( ':userID', $userID );
        $sql->execute();
        
        $result = null;
        
        while( ( $result = $sql->fetch( PDO::FETCH_ASSOC ) ) != null )
        {
            $retval[] = array( 'meetingId'      => $result['m.ID'],
                               'courseId'       => $result['m.courseID'],
                               'location'       => $result['m.location'],
                               'date'           => $result['m.startDate']);
        }
        
        return $retval; 
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
        
        $sql = 'SELECT count.
                    FROM m.' . Meeting::MEETING_TABLE . ' .
                        JOIN um.' . Meeting::USER_MEETING_TABLE . ' .
                            ON m.ID = um.meetingID
                        JOIN u.' . Meeting::USER_TABLE . '
                            ON um.userID = u.ID
                    WHERE m.ID = :meetingID
                    GROUP BY m.ID;';
        $sql = $db->prepare( $sql );
        $sql-> bindParam( ':meetingID', $meetingID );
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
    public function getMeetingUserList( $meetingID )
    {
        global $db;
        $retval = array();
        
        $sql = 'SELECT u.displayName
                    FROM um.' . Meeting::USER_MEETING_TABLE . '
                        JOIN u.' . Meeting::USER_TABLE . '
                            ON u.ID = um.userID
                        WHERE um.meetingID = :meetingID;';
                        
        $sql = $db->prepare( $sql );
        $sql->bindParam( ':meetingID', $meetingID );
        $sql->execute();
        
        $user = null;
        
        while( ( $user = $sql->fetch( PDO::FETCH_ASSOC ) ) != null )
        {
            $retval[] = $result['displayName'];
        }
    }
    
    
    
    
    /* THIS WILL TOTS WORK NO NEED TO TEST NP NP
     * A function to fetch meetings from the database.
     *
     * @param $userID
     *
     * @returns an array of filtered meetings.
     */
    public function getMeetingList( $userID )
    {
       
        global $db;
        $visible        = $this->getFilter();
        $courseMeeting  = array();
        $joinedMeeting  = array();
        $meetingMaster  = array();
        $signedUp       = array();
        $retval         = array();
        
        // if the user is in the course, but not signed up for the meeting.
        if( $visible & 1 )
        {   
            $sql = 'SELECT m.ID, m.courseID, m.location, m.startDate
                        FROM m.' . Meeting::MEETING_TABLE . '
                            INNER JOIN uc.' . Meeting::USER_COURSE_TABLE . '
                                ON m.courseID = uc.courseID
                            LEFT JOIN um.' . Meeting::USER_MEETING_TABLE . '
                                ON m.ID = um.meetingID
                        WHERE um.userID IS NULL 
                            AND uc.userID = :userID 
                            AND m.endDate > current_timestamp
                            AND uc.visible = \'T\'
                        ORDER BY m.startDate;';
            
            $sql = $db->prepare( $sql );
            $sql->bindParam( ':userID', $userID );
            $sql->execute();
                        
            $return = null;
            
            while( ( $return = $sql->fetch( PDO::FETCH_ASSOC ) ) != null )
            {
                
                $courseMeeting[] = array( 'ID'              => $return['m.ID'],
                                          'courseID'        => $return['m.courseID'],
                                          'location'        => $return['m.location'],
                                          'startDate'       => $return['m.startDate'],
                                          'membershipType'  => 0
                                        );
            }
            
        }
        
        // if the user is signed up for the meeting
        if( $visible & 2 )
        {
            $sql = 'SELECT m.ID, m.courseID, m.location, m.startDate
                        FROM m.' . Meeting::MEETING_TABLE . '
                            INNER JOIN uc.' . Meeting::USER_COURSE_TABLE . '
                                ON m.courseID = uc.courseID
                            LEFT JOIN um.' . Meeting::USER_MEETING_TABLE . '
                                ON m.ID = um.meetingID
                        WHERE um.userID = :userID 
                            AND um.masterID != :userID 
                            AND m.endDate > current_timestamp
                            AND uc.visible = \'T\'
                        ORDER BY m.startDate;';
                        
            $sql = $db->prepare( $sql );
            $sql->bindParam( ':userID', $userID );
            $sql->execute();

            $return = null;
            
            while( ( $return = $sql->fetch( PDO::FETCH_ASSOC ) ) != null )
            {
                $courseEvent[] = array( 'ID'                => $return['m.ID'],
                                        'courseID'          => $return['m.courseID'],
                                        'location'          => $return['m.location'],
                                        'startDate'         => $return['m.startDate'],
                                        'membershipType'    => 1
                                       );
            }
        }
        
        // if the user is the meetings current master.
        if( $visible & 4 )
        {
            $sql = 'SELECT m.ID, m.courseID, m.location, m.startDate
                        FROM m.' . Meeting::MEETING_TABLE . '
                            INNER JOIN uc.' . Meeting::USER_COURSE_TABLE . '
                                ON m.courseID = uc.courseID
                            LEFT JOIN um.' . Meeting::USER_MEETING_TABLE . '
                                ON m.ID = um.meetingID
                        WHERE m.masterID = :userID 
                            AND m.endDate > current_timestamp
                            AND uc.visible = \'T\'
                        ORDER BY m.startDate;';
                        
            $sql = $db->prepare( $sql );
            $sql->bindParam( ':userID', $userID );
            $sql->execute();

            $return = null;
            
            while( ( $return = $sql->fetch( PDO::FETCH_ASSOC ) ) != null )
            {
                echo( 'meeting list called' );
                $meetingMaster[] = array( 'ID'          => $return['m.ID'],
                                          'courseID'    => $return['m.courseID'],
                                          'location'    => $return['m.location'],
                                          'startDate'   => $return['m.startDate'],
                                          'icon'        => 2
                                        );
            }
        }
        
        // array indexes.
        $i      = 0;
        $foo    = 0;
        $bar    = 0;
        
        // Merge $joineMeetings and $meetingMaster in order by date.
        while( $i < count( $joinedMeeting ) + count( $meetingMaster ) )
        {
            // If $couseMeeting is earlier then meetingMaster.
            if( $joinedMeeting[$foo]['startDate'] < $meetingMaster[$bar]['startDate'] )
            {
                $signedUp[$i++] = $joinedMeeting[$foo++];
            }
            else
            {
                $signedUp[$i++] = $meetingMaster[$bar++];
            }
        }
        
        $i      = 0;
        $foo    = 0;
        $bar    = 0;
        
        // Merge $signedUp and $courseMeeting by date.
        while( $i < count( $signedUp ) + count( $courseMeeting ) )
        {
            // If $signedUp is earlier then meeting master. ( this could very well be 0.
            if( $signedUp[$foo]['startDate'] < $signedUp[$bar]['startDate'] )
            {
                $retval[$i++] = $courseMeeting[$foo++];
            }
            else
            {
                $retval[$i++] = $SignedUp[$bar++];
            }
        }
        
        return $retval;
    }
    
    private function getFilter() { 
        return 7; 
    }
    
    
}
