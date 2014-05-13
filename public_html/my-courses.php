<?php require_once( 'config.php' ); ?>
<?php renderPagelet( 'header.php', array( '{{customHeadTags}}' => '' ) ); ?>
    <body>
        <form id="get-my-courses-form" name="get-my-courses-form" method="POST">
            <input type="hidden" name="method" value="get-courses" />
		</form>
        <div data-role="page" data-theme="a">
            <?php define('HAS_MENU',1);
                  renderPagelet( 'banner.php', array( '{{title}}' => 'My courses' ) ); ?>
            <div data-role="content">
                <ul data-role="listview" data-filter="true" id="my-courses-list">
	                <li data-icon="false"><a href="#">BUSA2720<br>Business in a Networked Economy</a></li>
	                <li data-icon="false"><a href="#">COMP1116<br>Business Communications 1</a></li>
	                <li data-icon="false"><a href="#">COMP1100<br>CST Program Fundamentals</a></li>
	                <li data-icon="false"><a href="#">COMP1111<br>Essential Skills for Computing</a></li>
	                <li data-icon="false"><a href="#">COMP1113<br>Applied Mathematics</a></li>
    	            <li data-icon="false"><a href="#">COMP1510<br>Programming Methods</a></li>
    	            <li data-icon="false"><a href="#">COMP1536<br>Introduction to Web Development</a></li>
                </ul>
            </div>
            <div data-role="footer" data-position="fixed">
                <div data-role="navbar">
		            <ul>
			            <li><a href="#" id="add-course-button">Add Courses</a></li>
			            <li><a href="#" id="remove-course-button">Remove Courses</a></li>
		            </ul>
	            </div>
            </div>
        </div>
        <script>
            var formData = $("#get-courses-form").serializeArray();
            $.post( <?php echo '\'' . AJAX_URL . 'courses/user-courses.php\''; ?>,
                        formData,
                        pupulateCourseList,
                        "json");

            function pupulateCourseList(result)
            {
                var myCoursesList = document.getElementById('my-courses-list');
                for( var i = 0; i < result.length; ++i )
                {
                    var newLI = document.createElement('li');
                    newLI.setAttribute( 'data-icon', (result[i].inCourse?'check':'false') );
                    newLI.innerHTML = '<a href="#">' + result[i].id + '<br>' + result[i].title + '</a>';
                    myCoursesList.appendChild(newLI);
                }

				$('#my-courses-list').listview('refresh');
            }

            $('#remove-course-button').on( 'click tap', function(e){
                //alert('tapped');
                $('#my-courses-list>li').attr('data-icon', 'delete');
                $('#my-courses-list a').addClass('ui-btn-icon-right ui-icon-delete');
				$('#my-courses-list').listview('refresh');
            } )
        </script>
    </body>
</html>
