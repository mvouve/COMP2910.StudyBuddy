<?
class CourseManager
{
	const COURSE_TABLE = 'Course';
	const USER_COURSE_TABLE = 'UserCourse';

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
		
		if ( $user == null )
		{
			$sql = 'SELECT *
					FROM ' . CourseManager::COURSE_TABLE . ' 
					;';
			$sql = $db->prepare( $sql );
			$sql->execute();
			$result = null;
			
			while ( ( $result = $db->fetch( PDO::FETCH_ASSOC ) ) != null )
			{
				$retval[] = array( 'id' => $result['ID'], 'title' => $result['name'] );
			}
		}
		else
		{
			
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
					(:uid, :cID, \'F\')
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
		
		return $sql->execute();
	}
	
	/*
	 * Get the Course List of a specific User
	 *
	 * @param $userID the ID of the user whose list to retrieve.
	 * 
	 * @returns array( id, title ) of courses.
	 */
	public function getUserCourseList( $userID )
	{
		global $db;
		
		$sql = 'SELECT c.ID, c.name
				FROM ' . CourseManager::COURSE_TABLE . ' c
					JOIN ' . CourseManager::USER_COURSE_TABLE . ' uc
						ON c.ID = uc.courseID
				WHERE uc.userID=:uid
				;';
		$sql = $db->prepare( $sql );
		$sql->bindParam( ':uid', $userID );
		$sql->execute();
		
		$result = null;
		
		while ( ( $result = $db->fetch( PDO::FETCH_ASSOC ) ) != null )
		{
			$retval[] = array( 'id' => $result['ID'], 'title' => $result['name'] );
		}
		
		return $retval;
	}
}