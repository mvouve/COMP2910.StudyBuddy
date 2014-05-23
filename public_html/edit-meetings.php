<!-- edit meetings page-->
<div data-role="page" id="page-edit-meeting">
    <?php renderPagelet( 'banner.php', array( '{{title}}' => 'Edit Meeting' ) ); ?>
    <div data-role="header">
    </div>

    <div data-role="content" id="edit-meeting-div">
        <!--div where errors appear on invalid input-->
        <div id = "edit-meeting-error"></div>
        <form id="edit-meeting-form" name="edit-meeting-form" method="post">
            
            <div id="course-edit-dropdown-wrapper">
                <label for="course-edit-dropdown">Course :</label>
                <h3 id="course-edit-dropdown" name="course-edit-dropdown"></h3><br/>
            </div>
            
            <div id="edit-location-wrapper">
                <label for="edit-location">Location :</label>
                <input id="edit-location" name="edit-location" type="text"><br/>
            </div>

            <div>
                <label for="meeting-start-datetime">Start Time :</label>
                <input id="meeting-start-datetime" class="datetime-picker" name="meeting-start-datetime" type="text"><br/>
            </div>

            <div id="meeting-end-datetime-wrapper">
                <label for="meeting-end-datetime">End Time :</label>
                <input id="meeting-end-datetime" class="datetime-picker" name="meeting-end-datetime" type="text"><br/>
            </div>

            <div id="max-buddies-wrapper">
                <label for="edit-max-buddies">Maximum Buddies :</label>
                <input id="edit-max-buddies" name="edit-max-buddies" type="text"><br/>
            </div>

            <div id="meeting-comments-wrapper">
                <label for="edit-meeting-comments">Comments :</label>
                <textarea id="edit-meeting-comments" name="edit-meeting-comments"></textarea><br/>
            </div>
            <input id="meeting-id" name="meeting-id" type="hidden">
        </form>
        <input id="cancel-meeting-button" type="button" value="Cancel Meeting"/>
    </div>
            <!-- save meeting and cancel buttons go here?-->
    <div data-role="footer" data-position="fixed" data-tap-toggle="false">
                <div data-role="navbar">
		            <ul>
			            <li><a href="#page-my-meetings" data-icon="back" data-iconpos="top">Cancel</a></li>
			            <li><a href="#page-edit-meeting" data-icon="plus" data-iconpos="top" id="edit-meeting-submit">Edit Meeting</a></li>
		            </ul>
	            </div>
            </div>
</div>

<script>

    $('#meeting-end-datetime').datetimepicker({
        inline: true
    });

    $('#meeting-start-datetime').datetimepicker({
        inline: true
    });
    $('#edit-meeting-submit').on('click tap', submitEditMeeting);

    //cancelling meeting
    $('#cancel-meeting-button').on('click touchend', function () {
        cancelMeeting( ajaxURL, document.getElementById ( "meeting-id" ).attributes( "value" ) );
        jQuery.mobile.changePage( '#my-meetings' );
    });

    /*
    * Populate courses when the user clicks courses.
    */
    $('#course-edit-dropdown').focus(function () {
        document.getElementById('course-edit-dropdown').innerHTML = '';
        for (var key in myCoursesServerResponse) {
            if (myCoursesServerResponse[key].visible) {
                var opt = '<option value="' + key + '">' + key + '</option>';
                $('#course-edit-dropdown').append(opt);
            }
        }
    });
</script>
