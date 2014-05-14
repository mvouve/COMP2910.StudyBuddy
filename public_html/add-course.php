<!--Beginning of add-courses.php-->
<?php
    $email = $_SESSION['email'];
    $display_name = $_SESSION['display_name'];
?>
        <div data-role="page" data-theme="a" id="page-add-course">
            <?php renderPagelet( 'banner.php', array( '{{title}}' => 'Account Settings' ) ); ?>

            <div data-role="content" data-theme="a">
                <div class="center">
                    <p>Add Course</p>
                    <p><?php echo $email; ?></p>
                </div>

                <div>
                    <div data-role="form">
                        <form id="user-course-form" name="user-course-form" method="POST">
                            <label for="userCourseID">user Course ID: <span id="invalid-format" style="color: #FF0000">Please enter in the format COMP0000</span> </label>
                            <div id="user-course-id-div">
                                <input type="text" name="user-course-id" id="user-course-id">
                            </div>

                            <label for="user-course-title">user Course Title:</label>
                            <div id="user-course-title-div">
                                <input type="text" name="user-course-title" id="user-course-title">
                            </div>

                            <a href="#" data-role="button" id="add-course-submit">Add</a>
                            <input type="hidden" name="method" value="add" />
                        </form>
                    </div>
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

            //On ready function so stuff loads
            function addCourseOnReady() {
                $('#invalid-format').hide();

                $('#user-course-id').keyup(function (e) {
                    validateID();
                });
                btn = $('#add-submit');
                
                //form submit function
                $("#add-submit").on( 'click tap', function (e) {
                    // AJAX MADNESS HERE
                });
            }

            //Validating course ID to reg ex
            function validateID() {
                $('#invalid-format').show();
                var validID = document.getElementById("user-course-id").value.match(idRegex);
				//console.log( (validID == null?'null':validID[0]) );
                if (validID == null || validID.length != 1) {
                    //$(":button:contains('add-submit')").prop("disabled", true).addClass("ui-state-disabled");
                    return false;
                }
                else{
                    $('#invalid-format').hide();
                    //$(":button:contains('add-submit')").prop("disabled", false).addClass("ui-state-enabled");
                }
                return true;
            }
            
            //form submit function
            $("#add-course-submit").on( 'click tap', function (e) {
                userNewCourseID = $("#user-course-id").val();
                userNewCourseTItle = $("#user-course-title").val();
                createCourse("<?php echo AJAX_URL; ?>", userNewCourseId, userNewCourseTitle);
                e.stopImmediatePropagation();
                e.preventDefault();
            });
                                     
            function onCourseCreate(result){
                //PLACEHOLDER
            }
        </script>
    </body>
<!--End of add-courses.php-->
