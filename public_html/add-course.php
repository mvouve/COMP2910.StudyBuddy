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
                        <label for="newCourseID">New Course ID: <span id="invalid-format" style="color: #FF0000">Please enter in the format COMP0000</span></label>
                        <div id="new-course-id">
                            <input type="text" name="new-course-id" id="new-course-id">
                        </div>

                        <label for="new-course-title">New Course Title:</label>
                        <div id="new-course-title">
                            <input type="text" name="new-course-title" id="new-course-title">
                        </div>

                        <a href="#" data-role="button" id="add-submit">Add</a>
                        <input type="hidden" name="method" value="add" />

                    </div>
                </div>

            </div>
        </div>

        <script>

            var iDFormat = /^([A-Z]{4}[0-9]{4})$/
            var userEntry = document.getElementById("new-course-id");
            $('#new-course-id').keyup( function(e){
                validateID();
            } );
            $('#invalid-format').hide();


            function validateID() {
                $('#invalid-format').show();
                if (iDFormat.value.match(userEntry)!=null) {
                    alert('PLACEHOLDER, needs to send to server');
                }
                else {
                    $('#invalid-format').show();
                }
            }
        </script>
    </body>
