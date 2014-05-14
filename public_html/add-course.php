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
                        <form id="new-course-form" name="new-course-form" method="POST">
                            <label for="newCourseID">New Course ID: <span id="invalid-format" style="color: #FF0000">Please enter in the format COMP0000</span> </label>
                            <div id="new-course-id-div">
                                <input type="text" name="new-course-id" id="new-course-id">
                            </div>

                            <label for="new-course-title">New Course Title:</label>
                            <div id="new-course-title-div">
                                <input type="text" name="new-course-title" id="new-course-title">
                            </div>

                            <a href="#" data-role="button" id="add-submit">Add</a>
                            <input type="hidden" name="method" value="add" />
                        </form>
                    </div>
                </div>

            </div>
        </div>

        <script>
            var idRegex = /^([A-Z]{4}[0-9]{4})$/i;
            var userEntry;
            var invalidFormatBoolean = false;
            var btn;
            var formatMatch;
            var newCourse;

            //On ready function so stuff loads
            function addCourseOnReady() {
                $('#invalid-format').hide();

                $('#new-course-id').keyup(function (e) {
                    validateID();
                });
                btn = $('#add-submit');
                
                //form submit function
                $("#add-submit").on( 'click tap', function (e) {
                    // AJAX MADNESS HERE
                }
            }

            //Validating course ID to reg ex
            function validateID() {
                $('#invalid-format').show();
				console.log( document.getElementById( 'new-course-id').value );
                var validID = document.getElementById("new-course-id").value.match(idRegex);
                if (validID == null || validID.length != 1) {
                    return false;
                }
                alert(validID);
                return true;
            }
                                     
            function onCourseCreate(result){
                //PLACEHOLDER
            }
        </script>
    </body>
<!--End of add-courses.php-->
