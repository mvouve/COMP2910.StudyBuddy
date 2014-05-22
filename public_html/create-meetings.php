<!-- create meetings page-->
<div data-role="page" id="page-create-meeting">
    <?php renderPagelet( 'banner.php', array( '{{title}}' => 'Create Meeting' ) ); ?>

    <div data-role="content" data-theme="a">
        <div id="create-meeting-error"></div>
        <form id="create-meeting-form" name="create-meeting-form" method="post">
            <div id="course-dropdown-wrapper">
                <label for="course-dropdown">Course :</label>
                <select id="course-dropdown" name="course-dropdown"></select><br/>
            </div>

            <div id="location-dropdown-wrapper">
                <label for="location-dropdown">Location :</label>
                <input type="text" id="location-dropdown" name="location-dropdown" list="locations">
                <datalist id="locations">
                    <option>EhPod</option>
                </datalist>
                <br/>
            </div>

            
                <label for="create-meeting-start-datetime">Start Time :</label>
                <input id="create-meeting-start-datetime" name="create-meeting-start-datetime" type="text"><br/>
            


                <label for="create-meeting-end-datetime">End Time :</label>
                <input id="create-meeting-end-datetime" name="create-meeting-end-datetime" type="text"><br/>


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
			            <li><a href="#page-my-meetings" data-icon="back" data-iconpos="top">Cancel</a></li>
			            <li><a href="#page-create-meeting" id="create-meeting-submit" data-icon="plus" data-iconpos="top" >Create Meeting</a></li>
		            </ul>
	            </div>
            </div>
</div>

<script>
    $('#create-meeting-start-datetime').datetimepicker({
                                                        inline: true
                                                        });
    $('#create-meeting-end-datetime').datetimepicker({
                                                      inline: true
                                                      });
    /*
     * Populate courses when the user clicks courses.
     */
    $('#course-dropdown').focus( function()
    {
        document.getElementById('course-dropdown').innerHTML = '';
        for( var key in myCoursesServerResponse )
        {
            if( myCoursesServerResponse[key].visible )
            {
                var opt = '<option value="' + key + '">' + key + '</option>';
                $('#course-dropdown').append( opt );
            }
        }
    } );
    /*
     * Event handler for the button to create a meeting.
     */
    $( '#create-meeting-submit' ).on( 'click tap', submitCreateMeeting );
    
    /*
     * Creates a meeting.
     */
    function submitCreateMeeting()
    {
        // Ready parameters.
        var courseID          = document.getElementById( 'course-dropdown' ).value;
        var maxBuddies        = document.getElementById( 'max-buddies' ).value;
        var courseDescription = document.getElementById( 'meeting-comments' ).value;
        var startTime         = document.getElementById( 'create-meeting-start-datetime' ).value;
        var endTime           = document.getElementById( 'create-meeting-end-datetime' ).value;
        var meetingLocation   = document.getElementById( 'location-dropdown' ).value;
        var errorDiv          = document.getElementById( 'create-meeting-error' );
        
        // Check for valid fields.
        if( validateMeetingParams( courseID, 
                                maxBuddies, 
                                courseDescription, 
                                startTime,
                                endTime,
                                meetingLocation,
                                errorDiv
                                ))
        {
            
            
            // Call ajax function to create meeting.
            createMeeting ( ajaxURL, 
                            courseID, 
                            courseDescription, 
                            meetingLocation, 
                            startTime, 
                            endTime, 
                            maxBuddies 
                        );
        }
        return;
    }
</script>
