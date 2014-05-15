<!--Beginning of all-courses.php-->
        <div data-role="page" data-theme="a" id='page-all-courses'>
            <?php renderPagelet( 'banner.php', array( '{{title}}' => 'All courses' ) ); ?>
            <div data-role="content" class="listview-wrapper">
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
            <div data-role="footer" data-position="fixed" data-tap-toggle="false">
                <div data-role="navbar">
		            <ul>
			            <li><a href="#page-my-courses" data-icon="back" data-iconpos="top">My Courses</a></li>
			            <li><a href="#page-add-course" data-icon="plus" data-iconpos="top">Create Course</a></li>
			            <li><a href="#" id="clear-my-courses" data-icon="minus" data-iconpos="top">Clear All</a></li>
		            </ul>
	            </div>
            </div>
        </div>
        <script>
			var allCoursesList;
		
			function allCoursesOnReady()
			{
                
				$( '#all-courses-list' ).listview();
				allCoursesList = document.getElementById('all-courses-list');

                $( '#clear-my-courses' ).on( 'click tap', function(e)
                {
                    if( clearing )
                    {
                        return;
                    }
                    else
                    {
                        clearing = true;
                    }
                    $.ajax
                    ({
                        url: ajaxURL + 'courses/user-courses.php',
                        data:
                        {
                            method: "remove-all-courses"
                        },
                        dataType: "json",
                        success: function (json)
                        {
                            if(json.success == true)
                            {
                                $( '#all-courses-list>li' ).attr( 'data-icon', 'false' );
                                $( '#all-courses-list a' ).removeClass('ui-icon-check ui-btn-icon-right');
                                $( '#all-courses-list' ).listview('refresh');
                            }
                            clearing = false;
                        }
                    });
                } );
			}
        </script>
<!--End of all-courses.php-->
