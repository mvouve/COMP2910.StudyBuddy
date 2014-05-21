<!--Beginning of my-courses.php-->
        <div data-role="page" data-theme="a" id="page-my-courses">
            <?php renderPagelet( 'banner.php', array( '{{title}}' => 'My courses' ) ); ?>
		    <form id="get-my-courses-form" name="get-my-courses-form" method="POST">
				<input type="hidden" name="method" value="get-courses" />
			</form>
            <div data-role="content" class="listview-wrapper">
                <ul data-role="listview" data-filter="true" id="my-courses-list" data-split-icon="false">
	                <!--li data-icon="false"><a href="#">BUSA2720<br>Business in a Networked Economy</a></li>
	                <li data-icon="false"><a href="#">COMP1116<br>Business Communications 1</a></li>
	                <li data-icon="false"><a href="#">COMP1100<br>CST Program Fundamentals</a></li>
	                <li data-icon="false"><a href="#">COMP1111<br>Essential Skills for Computing</a></li>
	                <li data-icon="false"><a href="#">COMP1113<br>Applied Mathematics</a></li>
    	            <li data-icon="false"><a href="#">COMP1510<br>Programming Methods</a></li>
    	            <li data-icon="false"><a href="#">COMP1536<br>Introduction to Web Development</a></li-->
                </ul>
            </div>
            <div data-role="footer" data-position="fixed" data-tap-toggle="false">
                <div class="sb-navbar" data-role="navbar">
		            <ul>
			            <li><a href="#page-all-courses" id="add-course-button" data-icon="plus" data-iconpos="top">Add Courses</a></li>
			            <li><a href="#" id="remove-course-button" data-icon="minus" data-iconpos="top">Remove Courses</a></li>
		            </ul>
	            </div>
            </div>
        </div>
        <script>
			var removeClicked = false;
            function myCourseOnReady()
            {
                myCoursesList = document.getElementById('my-courses-list');
				removeClicked = false;
                removeMode = false;
				$('#my-courses-list').listview();
                            
                $('#remove-course-button').on( 'click tap', function(e)
                {
					if ( removeClicked === true )
					{
						return;
					}
				
					removeClicked = true;
					
					// Hacky Reset for Remove button duoble click bug fix
					setTimeout( function() { removeClicked = false; }, 400 );
				
                    if( removeMode )
                    {
                        $('#my-courses-list .the-button').removeClass('ui-btn-icon-right ui-icon-delete');
                        updateTrackedCheckMarks();
				        $('#my-courses-list').listview('refresh');
                        $('#remove-course-button').html('Remove Courses');                    
                    }
                    else
                    {
                        $('#my-courses-list .the-button').removeClass('ui-icon-eye ui-icon-no-eye');
                        $('#my-courses-list .the-button').addClass('ui-icon-delete');
				        $('#my-courses-list').listview('refresh');
                        $('#remove-course-button').html('Finish');
                    }
                    removeMode = !removeMode;
                    setTimeout(function(){$('#remove-course-button').removeClass( 'ui-btn-active' );},200);
                    $('#remove-course-button').removeClass( 'ui-btn-active' );
                });

                $('#add-course-button').on( 'click tap', function(e)
                {
                    if(  removeMode  )
                    {
                        $('#my-courses-list a').removeClass('ui-btn-icon-right ui-icon-delete');
                        updateTrackedCheckMarks();
				        $('#my-courses-list').listview('refresh');
                        $('#remove-course-button').html('Remove Courses');
                        removeMode = false;
                    }
                });
                
            }

            function updateTrackedCheckMarks()
            {
                for( var key in myCoursesServerResponse )
                {
                    if( myCoursesServerResponse[key].visible )
                    {
                        $('#my-course-'+key).parent().attr('data-icon', 'eye');
                        $('#my-course-'+key).addClass('ui-btn-icon-right ui-icon-eye');
                    }
                }
            }

            
        </script>
<!--End of my-courses.php-->