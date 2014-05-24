<!--Beginning of add-courses.php-->
<!-- NOTE TO SELF: removed error message divs, need to readd them -->
<?php
    $email = $_SESSION['email'];
    $display_name = $_SESSION['display_name'];
?>
        <div data-role="page" data-theme="a" id="page-add-course">
            <?php renderPagelet( 'banner.php', array( '{{title}}' => 'Add Course' ) ); ?>

            <div data-role="content" data-theme="a">
                <form id="add-course-form" name="add-course-form" method="POST">
                    
                    <!-- Course ID -->
                    <div id="add-course-id-div">
                        <label for="add-course-id">Course ID:</label>
                        <input type="text" name="add-course-id" id="add-course-id" placeholder="COMP0000">
                    </div>
                    
                    <!-- Course Name -->
                    <div id="user-course-name-div">
                        <label for="add-course-name">Course Title:</label>
                        <input type="text" name="user-course-name" id="user-course-name" placeholder="At least 4 letter description">
                    </div>

                    <a href="#" data-role="button" id="add-course-submit">Add</a>
                    <input type="hidden" name="method" value="add" />
                </form>
                <a href="page-all-courses" data-role="button" id="add-course-cancel">Cancel</a>
            </div>
            
        </div>

        <script>
            var CourseIdRegex = /^([A-Z]{4}[0-9]{4})$/gi;
            var courseIdFilled;
            var courseTitleFilled;

            //On ready function so stuff loads
            function addCourseOnReady() 
            {
                // Submit button is disabled by default to prevent spam.
                $('#add-course-submit').addClass('ui-disabled');
                
                // Add listener to the course-id-title.
                $('#add-course-id').keyup(function ( e ) 
                {
                    validateCouseID();
                });
                
                // Add listener to user-course-title.
                $( '#user-course-title' ).keyup( function ( e ) 
                {
                    var ID      = document.getElementById("add-course-id").value;
                    var title   = document.getElementById("add-course-name").value;
                    
                    $('#add-course-submit').addClass('ui-disabled');
                    
                    if ( validateCourseTitle( title ) )
                    {
                        if( validateCourseID( ID ) )
                        {
                            $('#add-course-submit').removeClass('ui-disabled');
                        }
                            
                    }
                        
                });
                
                // Adds button listener to the add-course-submit-button.
                $("#add-course-submit").on( 'click touchend', function ( e ) 
                {
                    var userNewCourseID = $("#add-course-id").val();
                    var userNewCourseTitle = $("#user-course-title").val();
					$('#add-course-submit').addClass('ui-disabled');
                    createCourse( ajaxURL, userNewCourseID, userNewCourseTitle );
                    
                    // Prevent ghost-click in JQuery Mobile.
                    e.stopImmediatePropagation();
                    
                    // Stops anchor from trying to redirect.
                    e.preventDefault();
                });
                
                // Add listener to the course cancel button. 
                $("add-course-cancel").on( 'click touchend', function ( e ) 
                {
                    document.getElementById("user-course-form").reset();
					$('#add-course-submit').addClass('ui-disabled');
                    $.mobile.changePage("#page-all-courses");
                    return false;
                    
                });
            }

 
            

        </script>
    </body>
<!--End of add-courses.php-->
