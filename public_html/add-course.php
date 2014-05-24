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
                            <div id="user-course-id-div">
                                <input type="text" name="user-course-id" id="user-course-id" placeholder="COMP0000">
                            </div>

                            <label for="add-course-name">Course Title:</label>
                            <div id="user-course-title-div">
                                <input type="text" name="user-course-title" id="user-course-title" placeholder="At least 4 letter description">
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
            var idRegex = /^([A-Z]{4}[0-9]{4})$/gi;
            var userEntry;
            var invalidFormatBoolean = false;
            var btn;
            var formatMatch;
            var userNewCourseId;
            var userNewCourseTitle;
            
            var courseIdFilled;
            var courseTitleFilled;

            //On ready function so stuff loads
            function addCourseOnReady() {
                $('#add-course-submit').addClass('ui-disabled');
                $('#invalid-format').hide();

                $('#user-course-id').keyup(function (e) {
                    validateID();
                });
                
                $('#user-course-title').keyup(function (e) {
                    validateTitle();
                });
               //form submit function
                $("#add-course-submit").on( 'click touchend', function (e) {
                    userNewCourseID = $("#user-course-id").val();
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

            //Validating course ID to reg ex
            function validateID() {
                courseIdFilled = false;
                $('#add-course-submit').addClass('ui-disabled');
                
                $('#invalid-format').show();
                var validID = document.getElementById("user-course-id").value.match(idRegex);
                if (validID == null || validID.length != 1) {
                    return false;
                }
                $('#invalid-format').hide();
                //$('#add-course-submit').removeClass('ui-disabled');
                courseIdFilled = true;
                checkFormFilled();
                return true;
            }
            
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
