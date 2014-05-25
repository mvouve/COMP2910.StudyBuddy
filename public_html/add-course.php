<!--Beginning of add-courses.php-->
<!-- NOTE TO SELF: removed error message divs, need to readd them -->
<?php
    $email = $_SESSION['email'];
    $display_name = $_SESSION['display_name'];
?>
        <div data-role="page" data-theme="a" id="page-add-course">
            <?php renderPagelet( 'banner.php', array( '{{title}}' => 'Add Course' ) ); ?>

            <div data-role="content" data-theme="a">
                <div id="add-course-error"></div>
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

                    <input type="hidden" name="method" value="add" />
                </form>
            </div>
            <div data-role="footer" data-position="fixed" data-tap-toggle="false">
                <div data-role="navbar">
                    <ul>
                        <li><a href="#page-all-courses" data-icon="back" data-iconpos="top">Cancel</a></li>
                        <li><a href="#page-add-course" id="add-course-submit" data-icon="plus" data-iconpos="top" >Add Course</a></li>
                    </ul>
                </div>
            </div>
        </div>
            

        <script>
            var CourseIdRegex = /^([A-Z]{4}[0-9]{4})$/gi;

            //On ready function so stuff loads
            function addCourseOnReady() 
            {
                // Adds button listener to the add-course-submit-button.
                $("#add-course-submit").on( 'click touchend', function ( e ) 
                {
                    var CourseID    = $("#add-course-id").val();
                    var CourseName  = $("#user-course-name").val();
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
                });
            }

 
            

        </script>
    </body>
<!--End of add-courses.php-->
