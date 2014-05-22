<!-- edit meetings page-->
<div data-role="page" id="page-edit-meeting">
    <?php renderPagelet( 'banner.php', array( '{{title}}' => 'Edit Meeting' ) ); ?>
    <div data-role="header">
    </div>

    <div data-role="main" id="edit-meeting-div">
        <!--div where errors appear on invalid input-->
        <div id = "edit-meeting-error"></div>
        <form id="edit-meeting-form" name="edit-meeting-form" method="post">
            <h3 id="courseID"></h3>

            <div id="edit-location-wrapper">
                <label for="edit-location">Location :</label>
                <input id="edit-location" name="edit-location" type="text"><br/>
            </div>

            <div>
                <label for="meeting-start-datetime">Start Time :</label>
                <input id="meeting-start-datetime" name="meeting-start-datetime" type="text"><br/>
            </div>

            <div id="meeting-end-datetime-wrapper">
                <label for="meeting-end-datetime">End Time :</label>
                <input id="meeting-end-datetime" name="meeting-end-datetime" type="text"><br/>
            </div>

            <div id="max-buddies-wrapper">
                <label for="max-buddies">Maximum Buddies :</label>
                <input id="max-buddies" name="max-buddies" type="text"><br/>
            </div>

            <div id="meeting-comments-wrapper">
                <label for="meeting-comments">Comments :</label>
                <textarea id="meeting-comments" name="meeting-comments"></textarea><br/>
            </div>
        </form>
    </div>
            <!-- save meeting and cancel buttons go here?-->
    <div data-role="footer" data-position="fixed" data-tap-toggle="false">
                <div data-role="navbar">
		            <ul>
			            <li><a href="#page-my-courses" data-icon="back" data-iconpos="top">Cancel</a></li>
			            <li><a href="#page-add-course" data-icon="plus" data-iconpos="top">Create Meeting</a></li>
		            </ul>
	            </div>
            </div>
</div>

<script>
    jQuery('#datetimepicker').datetimepicker();
</script>
