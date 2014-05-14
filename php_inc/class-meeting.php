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
	 * @param $creatorID	the ID of the creator of the course.
	 * @param $comment		the comment associated with the meeting.
	 * @param $location		where the meeting will be.
	 * @param maxBuddies	the maximum number of people for the meeting.
	 * @param startTime		The time the meeting starts.
	 * @param endTime		The time the meeting ends.
	 *
	 * @returns true on success, false on failure.
	 */
	 
	public function createMeeting( $courseID,
								   $creatorID,
								   $comment,
								   $location,
								   $maxBuddies,
								   $startTime,
								   $endTime )
	{
		global $db;
		
		$sql = ' INSERT INTO ' . Meeting::MEETING_TABLE . '
					( courseID, creatorID, comment, location, maxBuddies, startDate, endDate )
				VALUES
					( :courseID, :creatorID, :comment, :location, :maxBuddies, :startTime, :endTime );'
		$sql = $db->prepare( $sql );
		$sql = bindParam( ':courseID',	$courseID );
		$sql = bindParam( ':creatorID', $creatorID );
		$sql = bindParam( ':comment',	$comment );
		$sql = bindParam( ':location',	$location );
		$sql = bindParam( ':maxBuddies',$maxBuddies );
		$sql = bindParam( ':startDate', $startDate );
		$sql = bindParam( ':endDate', $endDate );
		
		return $sql->execute();