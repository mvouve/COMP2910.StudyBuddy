<?php require_once( 'config.php' ); ?>
<?php renderPagelet( 'header.php', array( '{{customHeadTags}}' => '' ) ); ?>
    <body>
        <form id="get-all-courses-form" name="get-all-courses-form" method="POST">
            <input type="hidden" name="method" value="get-courses" />
		</form>
        <div data-role="page" data-theme="a">
            <?php define('HAS_MENU',1);
                  renderPagelet( 'banner.php', array( '{{title}}' => 'All courses' ) ); ?>
            <div data-role="content">
                <ul data-role="listview" data-filter="true" id="all-courses-list">
	                <li data-icon="false"><a href="#">BUSA2720<br>Business in a Networked Economy</a></li>
	                <li data-icon="false"><a href="#">COMP1116<br>Business Communications 1</a></li>
	                <li data-icon="false"><a href="#">COMP1100<br>CST Program Fundamentals</a></li>
	                <li data-icon="false"><a href="#">COMP1111<br>Essential Skills for Computing</a></li>
	                <li data-icon="check"><a href="#">COMP1113<br>Applied Mathematics</a></li>
    	            <li data-icon="false"><a href="#">COMP1510<br>Programming Methods</a></li>
    	            <li data-icon="false"><a href="#">COMP1536<br>Introduction to Web Development</a></li>
                </ul>
            </div>
            <div data-role="footer" data-position="fixed">
                <div data-role="navbar">
		            <ul>
			            <li><a href="#">Create Course</a></li>
			            <li><a href="#">My Courses</a></li>
			            <li><a href="#">Clear All</a></li>
		            </ul>
	            </div>
            </div>
        </div>
        <script>
            var formData = $("#get-all-courses-form").serializeArray();
            $.post( <?php echo '\'' . AJAX_URL . 'courses/courses.php\''; ?>,
                        formData,
                        pupulateCourseList,
                        "json");

            function pupulateCourseList(result)
            {
                var allCoursesList = document.getElementById('all-courses-list');
                for( var i = 0; i < result.length; ++i )
                {
                    var newLI = document.createElement('li');
                    newLI.setAttribute( 'data-icon', (result[i].inCourse?'check':'false') );
                    newLI.innerHTML = '<a href="#">' + result[i].id + '<br>' + result[i].title + '</a>';
                    allCoursesList.appendChild(newLI);
                }
				
				$('#all-courses-list').listview('refresh');
            }
        </script>
    </body>
</html>
