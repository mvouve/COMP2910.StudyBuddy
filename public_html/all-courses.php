<!--Beginning of all-courses.php-->
        <div data-role="page" data-theme="a" id='page-all-courses'>
            <?php renderPagelet( 'banner.php', array( '{{title}}' => 'All courses' ) ); ?>
            <div data-role="content">
                <ul data-role="listview" data-filter="true" id="all-courses-list">
	                <!--li data-icon="false"><a href="#">BUSA2720<br>Business in a Networked Economy</a></li>
	                <li data-icon="false"><a href="#">COMP1116<br>Business Communications 1</a></li>
	                <li data-icon="false"><a href="#">COMP1100<br>CST Program Fundamentals</a></li>
	                <li data-icon="false"><a href="#">COMP1111<br>Essential Skills for Computing</a></li>
	                <li data-icon="check"><a href="#">COMP1113<br>Applied Mathematics</a></li>
    	            <li data-icon="false"><a href="#">COMP1510<br>Programming Methods</a></li>
    	            <li data-icon="false"><a href="#">COMP1536<br>Introduction to Web Development</a></li-->
                </ul>
            </div>
            <div data-role="footer" data-position="fixed">
                <div data-role="navbar">
		            <ul>
			            <li><a href="#page-add-course">Create Course</a></li>
			            <li><a href="#page-my-courses">My Courses</a></li>
			            <li><a href="#">Clear All</a></li>
		            </ul>
	            </div>
            </div>
        </div>
        <script>
			var allCoursesList;
		
			function allCoursesOnReady()
			{
				$( '#all-courses-list' ).listview();
				$.post( <?php echo '\'' . AJAX_URL . 'courses/courses.php\''; ?>,
							{
                                method: "get-courses"
                            },
							populateAllCourseList,
							"json");
							
				allCoursesList = document.getElementById('all-courses-list');
			}
			
            function populateAllCourseList(result)
            {
                for( var i = 0; i < result.length; ++i )
                {
                    var newLI = document.createElement('li');
                    newLI.setAttribute( 'data-icon', (result[i].inCourse?'check':'false') );
                    newLI.innerHTML = '<a href="#" onclcick="addToUserCourseList(\''+result[i].id+'\')">' + result[i].id + '<br>' + result[i].title + '</a>';
                    allCoursesList.appendChild(newLI);
                }
				
				$('#all-courses-list').listview('refresh');
            }

            function addToUserCourseList( courseID )
            {
            }
        </script>
<!--End of all-courses.php-->
