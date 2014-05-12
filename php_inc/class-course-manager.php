<?
class CourseManager
{
	const COURSE_TABLE = 'Course';

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
	 * @returns array( id, title ) of courses.
	 */
	public function getCourseList()
	{
		global $db;
		$retval = array();
		
		$sql = 'SELECT *
				FROM ' . CourseManager::COURSE_TABLE . ' 
				;';
		$sql = $db->prepare( $sql );
		$sql->execute();
		$result = null;
		
		while ( ( $result = $db->fetch( PDO::FETCH_ASSOC ) ) != null )
		{
			$result[] = array( 'id' => $result['ID'], 'title' => $result['name'] );
		}
		
		return $result;
	}
	
}