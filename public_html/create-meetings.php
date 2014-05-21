<!-- create meetings page-->
<div data-role="page" id="page-create-meeting">
    <?php renderPagelet( 'banner.php', array( '{{title}}' => 'Create Meeting' ) ); ?>

    <div data-role="content" data-theme="a">
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
            
            <div id="create-meeting-submit-wrapper">
                <a href="#" data-role="button" id="create-meeting-submit">Create Meeting</a>
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
    $('#create-meeting-start-datetime').datetimepicker({
                                                        format: 'YYYY-MM-DD HH:MM:ss',
                                                        inline: true
                                                        });
    $('#create-meeting-end-datetime').datetimepicker({
                                                      format: 'YYYY-MM-DD HH:MM:ss',
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
     * When user types in the comment section validate the comment.
     * Needs to be completed when 
     */
    //$('#meeting-comments').keyup( function() { validateCreateMeeting() } );
    //$('#max-buddies').keyup( function() { validateCreateMeeting() } );
    //$('#course-dropdown').change( function() { validateCreateMeeting() } );
    $( '#create-meeting-submit' ).on( 'click tap', function(){ submitCreateMeeting() } );
    
    
    function validateCreateMeeting()
    {
        if( !document.getElementById('course-dropdown').value.match( /^([A-Z]{4}[0-9]{4})$/gi ) )
        {
            return false;
        }
        if( !document.getElementByI('max-buddies').value.match( /^[0-9]$/) )
        {
            return false;
        }
        if( document.getElementById('meeting-comments').value.length < 1 )
        {
            return false;
        }
        
        var startDate = document.getElementById( 'create-meeting-start-datetime' );
        var endDate   = document.getElementById( 'create-meeting-end-datetime' );
        if( !validateDates( startDate, endDate ) )
        {
            return false;
        }
    }
    
    function validateDates( startDate, endDate )
    {
        return;
    }
    
    
    function submitCreateMeeting()
    {
        if( validateCreateMeeting() )
        {
            var course              = document.getElementById( 'course-dropdown' ).value;
            var maxBuddies          = document.getElementById( 'max-buddies' ).value;
            var courseDescription   = document.getElementById( 'meeting-comments' ).value;
            var startTime           = document.getElementById( 'create-meeting-start-datetime' ).value;
            var endTime             = document.getElementById( 'create-meeting-end-datetime' ).value;
            var meetingLocation     = document.getElementById( 'location-dropdown' ).value;
            
            createMeeting ( '<?php echo( AJAX_URL ) ?>', 
                            courseID, courseDescription, 
                            meetingLocation, startTime, 
                            endTime, maxBuddies 
                           );
        }
        return;
    }
        
</script>
