<!--Beginning of add-courses.php-->
<!-- NOTE TO SELF: removed error message divs, need to readd them -->
<?php
    $email = $_SESSION['email'];
    $display_name = $_SESSION['display_name'];
?>
        <div data-role="page" data-theme="a" id="page-add-course">
            <?php renderPagelet( 'banner.php', array( '{{title}}' => 'Add Course' ) ); ?>

            <div data-role="content" data-theme="a">
                <div>
                    <div data-role="form">
                        <form id="add-course-form" name="add-course-form" method="POST">
                            <label for="add-course-id">Course ID: 
							<span id="invalid-format" style="color: #FF0000">Please verify your format</span> </label>
                            <div id="add-course-id-div">
                                <input type="text" name="add-course-id" id="add-course-id" placeholder="COMP0000">
                            </div>

                            <label for="add-course-name">Course Title:</label>
                            <div id="user-course-name-div">
                                <input type="text" name="user-course-name" id="user-course-name" placeholder="At least 4 letter description">
                            </div>

                            <a href="#" data-role="button" id="add-course-submit">Add</a>
                            <input type="hidden" name="method" value="add" />
                        </form>
                    </div>
                    <a href="page-all-courses" data-role="button" id="cancel-add-course">Cancel</a>
                </div>

            </div>
        </div>

        <script>
            var CourseIdRegex = /^([A-Z]{4}[0-9]{4})$/gi;
            var userNewCourseId;
            var userNewCourseTitle;
            var courseIdFilled;
            var courseTitleFilled;

            //On ready function so stuff loads
            function addCourseOnReady() {
                $('#add-course-submit').addClass('ui-disabled');
                $('#invalid-format').hide();

                $('#add-course-id').keyup(function (e) {
                    validateID();
                });
                
                $('#user-course-title').keyup(function (e) {
                    validateTitle();
                });
               //form submit function
                $("#add-course-submit").on( 'click touchend', function (e) {
                    userNewCourseID = $("#add-course-id").val();
                    userNewCourseTitle = $("#user-course-title").val();
					$('#add-course-submit').addClass('ui-disabled');
                    createCourse("<?php echo AJAX_URL; ?>", userNewCourseID, userNewCourseTitle);
                    e.stopImmediatePropagation();
                    e.preventDefault();
                }); 
                $("#cancel-add-course").on( 'click touchend', function (e) {
                    document.getElementById("user-course-form").reset();
					$('#add-course-submit').addClass('ui-disabled');
                    $.mobile.changePage("#page-all-courses");
                    return false;
                    
                });
            }

            /*
			 * Validates user IDs.
			 *
			 * @returns
			 *		TRUE: 	ID is valid.
			 * 		FALSE: 	ID is invalid.
			 */
            function validateID() {
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
             * Validate the user title by REGEX
             *
             *
             */
            function validateTitle() {
                courseTitleFilled = false;
                $('#add-course-submit').addClass('ui-disabled');
                
                var titleEntry = document.getElementById("user-course-title").value;
                if(titleEntry.length > 3){
                    courseTitleFilled = true;
                }
                checkFormFilled();
                return true;
            }
            //Verify both fields are filled
            function checkFormFilled(){
                if(courseIdFilled == true && courseTitleFilled == true){
                    $('#add-course-submit').removeClass('ui-disabled');
                }
            }
            

        </script>
    </body>
<!--End of add-courses.php-->
