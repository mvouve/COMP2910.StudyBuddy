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
	 * @param $courseID		the course the meeting will be studdying.
	 * @param $masterID		the ID of the creator of the course.
	 * @param $comment		the comment associated with the meeting.
	 * @param $location		where the meeting will be.
	 * @param $maxBuddies	the maximum number of people for the meeting.
	 * @param $startTime	The time the meeting starts.
	 * @param $endTime		The time the meeting ends.
	 *
	 * @returns true on success, false on failure.
	 */
	 // TRANSACTIONS UNTESTED.
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
		$sql->bindParam( ':courseID',	$courseID );
		$sql->bindParam( ':masterID',	$masterID );
		$sql->bindParam( ':comment',	$comment );
		$sql->bindParam( ':location',	$location );
		$sql->bindParam( ':maxBuddies',	$maxBuddies );
		$sql->bindParam( ':startDate', 	$startDate );
		$sql->bindParam( ':endDate',	$endDate );
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
	 * @param $meetingID	the meeting to join.
	 * @param $userID		the id of the user joining the group.
	 *
	 * @return true on success false on failure.
	 */
	public function joinMeeting( $meetingID, $userID )
	{
		global $db;
		
		$sql = 'INSERT INTO' . Meeting::USER_MEETING_TABLE . '
					VALUES ( :meetingID, :userID );';
		$sql = $db->prepare( $sql );
		$sql-> bindParam( ':meetingID', $meetingID );
		$sql-> bindParam( ':userID',	$userID );
		
		return $sql->execute();
	}

}