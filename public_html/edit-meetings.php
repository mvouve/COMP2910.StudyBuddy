<!-- edit meetings page-->
<div data-role="page" id="page-edit-meeting">
    <?php renderPagelet( 'banner.php', array( '{{title}}' => 'Edit Meeting' ) ); ?>
    <div data-role="header">
    </div>

    <div data-role="main" id="edit-meeting-div">
        <!--div where errors appear on invalid input-->
        <div id = "edit-meeting-error"></div>
        <form id="edit-meeting-form" name="edit-meeting-form" method="post">
            
            <div id="course-edit-dropdown-wrapper">
                <label for="course-edit-dropdown">Course :</label>
                <select id="course-edit-dropdown" name="course-edit-dropdown"></select><br/>
            </div>
            
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
                <label for="edit-max-buddies">Maximum Buddies :</label>
                <input id="edit-max-buddies" name="edit-max-buddies" type="text"><br/>
            </div>

            <div id="meeting-comments-wrapper">
                <label for="edit-meeting-comments">Comments :</label>
                <textarea id="edit-meeting-comments" name="meeting-comments"></textarea><br/>
            </div>
            <!-- REMOVE THIS LATER FOR TESTING ONLY! -->
            <label for="meeting-id" style="color:red">Meeting ID !!!TO BE REMOVED: FOR TESTING ONLY!!!</label>
            <input id="meeting-id" name="meeting-id">
        </form>
    </div>
            <!-- save meeting and cancel buttons go here?-->
    <div data-role="footer" data-position="fixed" data-tap-toggle="false">
                <div data-role="navbar">
		            <ul>
			            <li><a href="#page-my-meetings" data-icon="back" data-iconpos="top">Cancel</a></li>
			            <li><a href="#page-edit-meeting" data-icon="plus" data-iconpos="top" id="edit-meeting-submit">Create Meeting</a></li>
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
    $('#edit-meeting-submit').on( 'click tap', submitEditMeeting );
    
        /*
     * Populate courses when the user clicks courses.
     */
    $('#course-edit-dropdown').focus( function()
    {
        document.getElementById('course-edit-dropdown').innerHTML = '';
        for( var key in myCoursesServerResponse )
        {
            if( myCoursesServerResponse[key].visible )
            {
                var opt = '<option value="' + key + '">' + key + '</option>';
                $('#course-edit-dropdown').append( opt );
            }
        }
    } );
</script>
