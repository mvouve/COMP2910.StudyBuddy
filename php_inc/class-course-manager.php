<?php
class CourseManager
{
	const COURSE_TABLE = 'Course';
	const USER_COURSE_TABLE = 'UserCourse';
    const PUSHER_CHANNEL = 'study_buddy';
    
	function __construct()
	{
	}
	
	/*
	 * Add a course to the database.
	 *
	 * @param $courseId the ID of the course (eg. COMP2721)
	 * @param $courseTitle the title of the course.
	 *
	 * @returns true on success, false on failure.
	 */
	public function createCourse( $courseId, $courseTitle )
	{
		global $db;
		
		$sql = 'INSERT INTO ' . CourseManager::COURSE_TABLE . ' 
					(ID, name)
				VALUES
					(:id, :title)
				;';
		$sql = $db->prepare( $sql );
		$sql->bindParam( ':id', $courseId );
		$sql->bindParam( ':title', $courseTitle );
		
		return $sql->execute();
	}
	
	/*
	 * Get the entire Course List.
	 *
	 * @userID the ID of the User (null if not logged in)
	 * @returns array( id, title ) of courses.
	 */
	public function getCourseList( $userID )
	{
		global $db;
		$retval = array();
		$sql = '';
        //this some how fixed a issue on the server, I have no idea why.
        $null = null;
		
		if ( $userID == null )
		{
			$sql = 'SELECT *
					FROM ' . CourseManager::COURSE_TABLE . ' 
					;';
			$sql = $db->prepare( $sql );
			$sql->execute();
			$result = null;
			
			while ( ( $result = $sql->fetch( PDO::FETCH_ASSOC ) ) != null )
			{
				$retval[] = array( 'id' => $result['ID'],
                                   'title' => $result['name'],
                                   'inCourse' =>false
                                 );
			}
		}
		else
		{
			$sql = 'SELECT *
					FROM ' . CourseManager::COURSE_TABLE . ' c
						LEFT JOIN ' . CourseManager::USER_COURSE_TABLE . ' uc
							ON uc.courseID = c.ID
								AND uc.userID=:id;
					;';

			$sql = $db->prepare( $sql );
			$sql->bindParam( ':id', $userID );
			$sql->execute();
			$result = null;
			
			while ( ( $result = $sql->fetch( PDO::FETCH_ASSOC ) ) != null )
			{
				$retval[] = array( 'id' => $result['ID'],
                                   'title' => $result['name'],
                                   'inCourse' => !is_null( $result['userID'] ) );
			}
		}
		
		return $retval;
	}
	
	/*
	 * Add a Course to a User Courses List.
	 *
	 * @param $userID the the ID of the User.
	 * @param $courseID the ID of the Course.
	 *
	 * @returns true on success, false on failure.
	 */
	public function addUserCourse( $userID, $courseID )
	{
		global $db;
		
		$sql = 'INSERT INTO ' . CourseManager::USER_COURSE_TABLE . ' 
					(userID, courseID, visible)
				VALUES
					(:uid, :cID, \'T\')
				;';
		$sql = $db->prepare( $sql );
		$sql->bindParam( ':uid', $userID );
		$sql->bindParam( ':cID', $courseID );
		
		return $sql->execute();
	}

	/*
	 * Remove a Course from a User list.
	 *
	 * @param $userID the users ID
	 * @param $courseID the course ID
	 *
	 * @returns true on success, false on failure.
	 */
	public function removeUserCourse( $userID, $courseID )
	{
		global $db;
		
		$sql = 'DELETE FROM ' . CourseManager::USER_COURSE_TABLE . ' 
				WHERE userID=:uid
					AND courseID=:cid
				;';
		$sql = $db->prepare( $sql );
        $sql->bindParam( ':uid', $userID );
        $sql->bindParam( ':cid', $courseID );
		
        if ( !$sql->execute() )
        {
            return false;
        }
        
		return $sql->rowCount() >= 1;
	}
	
	/*
	 * Remove all courses from a users course list.
	 *
	 * @param $userID the users ID
	 *
	 * @returns TRUE if courses were deleted, false if nothing was deleted.
	 */
	public function removeAllUserCourses( $userID )
	{
		global $db;
		
		$sql = 'DELETE FROM ' . CourseManager::USER_COURSE_TABLE . ' 
				WHERE userID=:id
				;';
		$sql = $db->prepare( $sql );
		$sql->bindParam( ':id', $userID );
		
		return ( $sql->execute() && $sql->rowCount() >= 1 );
	}
	
	/*
	 * Get the Course List of a specific User
	 *
	 * @param $userID the id of the user whose list to retrieve.
	 * 
	 * @returns array( id, title ) of courses.
	 */
	public function getUserCourseList( $userID )
	{
		global $db;
		$retval = array();
        
		$sql = 'SELECT c.ID, c.name, uc.visible
				FROM ' . CourseManager::COURSE_TABLE . ' c
					JOIN ' . CourseManager::USER_COURSE_TABLE . ' uc
						ON c.ID = uc.courseID
				WHERE uc.userID=:id
				;';
		$sql = $db->prepare( $sql );
		$sql->bindParam( ':id', $userID );
		$sql->execute();
		
		$result = null;
		
		while ( ( $result = $sql->fetch( PDO::FETCH_ASSOC ) ) != null )
		{
			$retval[] = array( 'id' 	 => $result['ID'],
							   'title'   => $result['name'],
							   'visible' => ( $result['visible'] === 'T' ) );
		}
		
		return $retval;
	}

    /*
	 * Toggles the visibility of a course for a specific user.
	 *
	 * @param $userID the ID of the user who's course will be toggled.
     * @param $courseID the ID of the course to toggle.
     * @throws SQLFailure if there's an issue connecting to the SQL.
	 * 
	 * @returns true|false on success/failure.
	 */
    public function toggleVisibility( $userID, $courseID )
    {
        global $db;
		$vis = $this->getVisibility( $userID, $courseID )?'\'F\'':'\'T\'';
        
        // ¯\_(ツ)_/¯ seems legit. really needs testing.
        try
        {
            $sql = 'UPDATE ' . CourseManager::USER_COURSE_TABLE .'
                        SET visible= ' . $vis . '
                        WHERE userID = :userID AND courseID = :courseID';
            $sql->bindParam( ':userID', $userID );
            $sql->bindParam( ':courseID', $courseID );
            
            return $sql->execute();
        }
        catch( SQLFailure $e )
        {            
            return false;
        }
    }
    
    /*
     * Use Pusher to push a newly created Course to connected clients.
     */
    public function pushNewCourseToClients( $pusher, $courseID, $courseTitle, $creatorID )
    {
        $data = array( 'id' => $courseID, 'title' => $courseTitle, 'creator' => $creatorID );
        $pusher->trigger( CourseManager::PUSHER_CHANNEL, 'course_added', $data ); 
    }
    
    /*
	 * Checks courses current visibility.
	 *
	 * @param $userID the ID of the user who's course is being checked.
     * @param $courseID the ID of the course that's being checked.
	 * 
	 * @returns true|false on the visiblity.
	 */
    private function getVisibility( $userID, $courseID )
    {
        global $db;
        
        $sql = 'SELECT visible
                    FROM ' . CourseManager::USER_COURSE_TABLE .'
                    WHERE userID =:userID AND courseID = :courseID;';
        $sql =  $db->prepare( $sql );
        $sql->bindParam( ':userID', $userID );
        $sql->bindParam( ':courseID', $courseID );
        if( !$sql->execute() )
        {
            require_once( '/../exceptions/class-sql-failure.php' );
            
            throw new SQLFailure();
        }
        
        $visible = $sql->fetch( PDO::FETCH_ASSOC );
        $visible = $visible['visible'];
        
        if( $visible == 'T' )
        {
            return true;
        }
        
        return false;
    }
}