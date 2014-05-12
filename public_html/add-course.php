<?php require_once( 'config.php' ); ?>
<?php require_once( PHP_INC_PATH . 'common.php' ); ?>
<?php
    $user = User::instance();
    if ( !$user->isLoggedIn() )
    {
        include( 'login.php' );
        die();
    }
?>
<?php $sliderHeader = array( '{{customHeadTags}}' => '
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
        <script type="text/javascript" src="js/jquery.slidepanel.js"></script>
        <link rel="stylesheet" type="text/css" href="css/jquery.slidepanel.css">
    ');

    $email = $_SESSION['email'];
    $display_name = $_SESSION['display_name'];
?>
<?php renderPagelet( 'header.php', array( '{{customHeadTags}}' => '' ) ); ?>

    <body>
        <div data-role="page" data-theme="a">
            <?php define('HAS_MENU',1);
                  renderPagelet( 'banner.php', array( '{{title}}' => 'Account Settings' ) ); ?>

            <div data-role="content" data-theme="a">
                <div class="center">
                    <p>Add Course</p>
                    <p><?php echo $email; ?></p>
                </div>

                <div>
                    <div data-role="form">
                        <label for="newCourseID">New Course ID: <span id="invalid-format" style="color: #FF0000">Please enter in the format COMP0000</span></label>
                        <div id="newCourseID">
                            <input type="text" name="newCourseID" id="newCourseID">
                        </div>

                        <label for="newCourseTitle">New Course Title:</label>
                        <div id="newCourseTitle">
                            <input type="text" name="newCourseTitle" id="newCourseTitle">
                        </div>

                        <a href="#" data-role="button" id="add-submit">Add</a>
                        <input type="hidden" name="method" value="add" />

                    </div>
                </div>

            </div>
        </div>

        <script>

            var iDFormat = /^([A-Z]{4}[0-9]{4})$/
            var userEntry = document.getElementById("newCourseID");

            $(document).ready(
                function(){
                    $('#invalid-format').hide()
                }
            );   

            $("newCourseID").keyup(validateID());

            function validateID() {
                if (iDFormat.test(userEntry)) {
                    alert('PLACEHOLDER, needs to send to server');
                }
                else {
                    $('#invalid-format').show();
                }
            };
        </script>
    </body>
