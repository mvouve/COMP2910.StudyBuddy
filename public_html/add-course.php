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
            var userNewCourseId;
            var userNewCourseTitle;
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
                $('#user-course-title').keyup(function ( e ) 
                {
                    validateCouseTitle();
                });
                
                // Adds button listener to the add-course-submit-button.
                $("#add-course-submit").on( 'click touchend', function ( e ) 
                {
                    userNewCourseID = $("#add-course-id").val();
                    userNewCourseTitle = $("#user-course-title").val();
					$('#add-course-submit').addClass('ui-disabled');
                    createCourse( ajaxURL, userNewCourseID, userNewCourseTitle );
                    e.stopImmediatePropagation();
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

            /*
			 * Validates user IDs by regex.
			 *
			 * @returns
			 *		TRUE: 	ID is valid.
			 * 		FALSE: 	ID is invalid.
			 */
            function validateCouseID() {
                courseIdFilled = false;
                $('#add-course-submit').addClass('ui-disabled');
                
                var validID = document.getElementById("add-course-id").value.match(CourseIdRegex);
                if (validID == null || validID.length != 1) {
                    return false;
                }
                $('#invalid-format').hide();
                //$('#add-course-submit').removeClass('ui-disabled');
                courseIdFilled = true;
                checkFormFilled();
                return true;
            }
            
            /*
             * Validate the user title by regex.
             *
             * @returns
             *      TRUE:   Title is valid.
             *      FALSE:  ID is invalid.
             */
            function validateCouseTitle() {
                courseTitleFilled = false;
                $('#add-course-submit').addClass('ui-disabled');
                
                var titleEntry = document.getElementById("user-course-title").value;
                if(titleEntry.length > 3){
                    courseTitleFilled = true;
                }
                checkFormFilled();
                return true;
            }
            
            /*
             * Checks if both the courseID and the Form Feilds are Valid.
             */
            function checkFormFilled(){
                if(courseIdFilled == true && courseTitleFilled == true){
                    $('#add-course-submit').removeClass('ui-disabled');
                }
            }
            

        </script>
    </body>
<!--End of add-courses.php-->
