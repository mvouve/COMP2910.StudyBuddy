<!--Beginning of all-courses.php-->
        <div data-role="page" data-theme="a" id='page-all-courses'>
            <?php renderPagelet( 'banner.php', array( '{{title}}' => 'All courses' ) ); ?>
            <div data-role="content" class="listview-wrapper">
                <ul data-role="listview" data-filter="true" id="all-courses-list" data-split-icon="false">
	                <!--li data-icon="false"><a href="#">BUSA2720<br>Business in a Networked Economy</a></li>
	                <li data-icon="false"><a href="#">COMP1116<br>Business Communications 1</a></li>
	                <li data-icon="false"><a href="#">COMP1100<br>CST Program Fundamentals</a></li>
	                <li data-icon="false"><a href="#">COMP1111<br>Essential Skills for Computing</a></li>
	                <li data-icon="check"><a href="#">COMP1113<br>Applied Mathematics</a></li>
    	            <li data-icon="false"><a href="#">COMP1510<br>Programming Methods</a></li>
    	            <li data-icon="false"><a href="#">COMP1536<br>Introduction to Web Development</a></li-->
                </ul>
            </div>
            <div data-role="footer" data-position="fixed" data-tap-toggle="false" data-split-theme="a">
                <div data-role="navbar">
		            <ul>
			            <li><a href="#page-my-courses" data-icon="back" data-iconpos="top">My Courses</a></li>
			            <li><a href="#page-add-course" data-icon="plus" data-iconpos="top">Create Course</a></li>
			            <!--<li><a href="#" id="clear-my-courses" data-icon="minus" data-iconpos="top">Remove All</a></li> TO BE REMOVED-->
		            </ul>
	            </div>
            </div>
        </div>
        <script>
			function allCoursesOnReady()
			{
				$( '#all-courses-list' ).listview();
				allCoursesList = document.getElementById('all-courses-list');
			}
        </script>
<!--End of all-courses.php-->
