/* GLOBAL VARIABLES */
var meetingList = [];
var iCreated = true;
var allMeeting = true;
var iAttending = true;
var meetingListClickLock = false;

/* a method to return all the meetings that you are attending, and adds them to your my meetings list via a helper function.
    returns a 2D array of meetings, each of which contains individual meeting data.
    @param ajax_URL (string): the URI location where the ajax folder is located */

function getAllMyMeetings( ajax_URL )
{
    $.ajax
    ({
        url: ajax_URL + 'meetings/meetings.php',
        type: 'POST',
        data:
        {
            method: 'get-meetings'
        },
        dataType: "json",
        success: function ( json )
        {
            meetingList = json;
            regenerateList();
        }
    });
}
   
/* creates a new meeting
    @param ajax_URL  the URI location where the ajax folder is located
    @param courseID the course being studied at the meeting
    @param CourseDescription a description of the course
    @param meetingLocation the place where the meeting will be held
    @param startTime a datetime string informing when the meeting begins (YYYY-MM-DD HH:MM:SS)
    @param endTime a datetime string informing when the meeting ends (YYYY-MM-DD HH:MM:SS)
    @param maxBuddies the maximum number of people that a location can accomidate */

function createMeeting ( ajax_URL, courseID, courseDescription, meetingLocation, startTime, endTime, maxBuddies )
{
    $.ajax
    ({
        url: ajax_URL + 'meetings/meetings.php',
        type: 'POST',
        data:
        {
            method: 'create-meeting',
            courseID: courseID,
            description: courseDescription,
            location: meetingLocation,
            startTime: startTime,
            endTime: endTime,
            maxBuddies: maxBuddies
        },
        dataType: "json",
        success: function (json) {
            if (json.success == true) {
                //redirect user to myMeetings
                $.mobile.changePage("#page-my-meetings");
            }
            else {
                //alert: meeting was not created successfully.
                alert("Meeting not created successfully.");
            }
        }
    });
}


/* 
 * called when the creator of a meeting needs to change something about the meeting
 *
 *
 * @param ajax_URL  the URI location where the ajax folder is located
 * @param meetingID: the meeting ID, determiend which meeting is to be altered
 * @param courseID the course being studied at the meeting
 * @param CourseDescription a description of the course
 * @param meetingLocation the place where the meeting will be held
 * @param startTime a datetime string informing when the meeting begins (YYYY-MM-DD HH:MM:SS)
 * @param endTime a datetime string informing when the meeting ends (YYYY-MM-DD HH:MM:SS)
 * @param maxBuddies the maximum number of people that a location can accomidate 
 */
function editMeeting ( ajax_URL, meetingID, courseID, courseDescription, meetingLocation, startTime, endTime, maxBuddies )
{
    $.ajax
    ({
        url: ajax_URL + 'meetings/meetings.php',
        type: 'POST',
        data:
        {
            method: 'edit-meeting',
            ID: meetingID,
            courseID: courseID,
            description: courseDescription,
            location: meetingLocation,
            startTime: startTime,
            endTime: endTime,
            maxBuddies: maxBuddies
        },
        dataType: "json",
        success: function (json) {
            if (json.success == true) {
                document.getElementById('create-meeting-form').reset();
                $.mobile.changePage('#page-my-meetings')
            }
            else {
                //show an alert that the meeting was not successfully edited.
                alert("meeting was not succesfully edited.");
            }
        }
    });
}

/* allows a user to cancel a meeting that they have created
    @param ajax_URL  the URI location where the ajax folder is located
    @param meetingID: the meeting ID, determiend which meeting is to be altered */

function cancelMeeting( ajax_URL, meetingID )
{
    $.ajax
    ({
        url: ajax_URL + 'meetings/meetings.php',
        type: 'POST',
        data:
        {
            method: 'cancel-meeting',
            ID: meetingID
        },
        dataType: "json",
        success: function ( json )
        {
            //doesnt need anything to do here.
        }
    });
}

/* allows a user to join a meeting that someone else has created
    @param ajax_URL  the URI location where the ajax folder is located
    @param meetingID: the meeting ID, determiend which meeting is to be altered */

function joinMeeting ( ajax_URL, meetingID )
{
    $.ajax
    ({
        url: ajax_URL + 'meetings/meetings.php',
        type: 'POST',
        data:
        {
            method: 'join-meeting',
            id: meetingID
        },
        dataType: "json",
        success: function (json) {
            //collapse the div
            $("#meeting-" + meetingID).trigger("collapse");
            //re-expand the div to programatically refresh the div
            $("#meeting-" + meetingID).trigger("expand");
        }
    });
}

/* allows a user to remove their userID from being associated with a meeting and reduces the number
    of buddies attending a meeting by 1.
    @param ajax_URL  the URI location where the ajax folder is located
    @param meetingID: the meeting ID, determiend which meeting is to be altered */

function leaveMeeting ( ajax_URL, meetingID )
{
    $.ajax
    ({
        url: ajax_URL + 'meetings/meetings.php',
        type: 'POST',
        data:
        {
            method: 'leave-meeting',
            id: meetingID
        },
        dataType: "json",
        success: function ( json )
        {
            //collapse the div
            $("#meeting-" + meetingID).trigger("collapse");
            //re-expand the div to programatically refresh the div
            $("#meeting-" + meetingID).trigger("expand");
        }
    });
}

/*---------------------------------- HELPER FUNCTIONS BELOW ---------------------------------------*/
/* used to add the details of a particular meeting to a HTML form, for editing meetings
    @param meetingID the unique ID assigned to a meeting */

function populateEditMeetingFields ( courseID, meetingLoc, description, meetingStartDate, meetingEndDate, meetingMaxBuddies, meetingID )
{
    //select a form element and assign json data to it

    var element = document.getElementById("course-edit-dropdown");
    element.innerHTML = courseID;

    var element = document.getElementById("edit-location");
    element.setAttribute("value", meetingLoc);

    var element = document.getElementById("meeting-start-datetime");
    element.setAttribute("value", meetingStartDate);

    var element = document.getElementById("meeting-end-datetime");
    element.setAttribute("value", meetingEndDate);

    var element = document.getElementById("edit-max-buddies");
    element.setAttribute("value", meetingMaxBuddies);

    var element = document.getElementById("edit-meeting-comments");
    element.innerHTML = description;
    
    var element = document.getElementById("meeting-id");
    element.setAttribute("value", meetingID );

}

/* used to add a meeting to a list of meetings
    @param meetingID: a numeric meeting ID, unique to each meeting
    @param meetingCourse: the course being studied at the meeting
    @param meetingLoc: the location where the meeting will be held
    @param meetingStartTime: the starting date time of the meeting
    @param meetingCancelled: a boolean value
                true: indicates a meeting is cancelled
                false: indicates     the meeting is available
    @param meetingFilter: a numeric value ( 0, 1, or 2 ) which detemines a user's relationship to any given meeting
                0: not attending
                1: attending
                2: meeting creator */

function addMeetingToList ( meetingID, meetingCourse, meetingLoc, meetingStartTime, meetingCancelled, meetingFilter, icon )
{
    var listItem = '<li data-role="collapsible" id = "meeting-' + meetingID + '"><a href="#"  class="the-button ui-btn"' 
                            + '<h1>Course: ' + meetingCourse 
                            + '<br>Location: ' + meetingLoc + '</h1>'
                            + '<p>Start Date: '  + getHumanDate( meetingStartTime ) 
                            + '</p></a><div id="meeting-details-' + meetingID + '"></div></li>';
    $( '#my-meetings-list' ).append(listItem);
    $( '#meeting-' + meetingID ).addClass('ui-icon-' + icon + ' ui-btn-icon-right');
    
    
    $( '#meeting-' + meetingID ).on( 'click tap', function ()
    {
        if( meetingListClickLock )
        {
            return;
        }
 
        meetingListClickLock = true;
        setTimeout( function() { meetingListClickLock = false; }, 600 );
        
    
            $.ajax
            ({
                url: ajaxURL + 'meetings/meetings.php',
                type: 'POST',
                data:
                {
                    method: 'get-meeting-details',
                    ID: meetingID
                },
                dataType: "json",
                success: function ( json )
                {
                    var meetingDesc = json.discription;
                    var meetingEndTime = json.endDate;
                    var meetingMaxBuddies = json.maxBuddies;
                    var currentBuddies = json.buddies.length
                    var meetingBuddies = "";
                    
                    for ( var i = 0 ; i < currentBuddies; i++ )
                    {
                        meetingBuddies += json.buddies[i] + "<br/>";
                        
                    }
                    
                    console.log( meetingEndTime );
                    var meetingDetailsStr = '<p class="my-meeting-end-date">End Date: ' + getHumanDate( meetingEndTime ) + '</p>'
                                          + '<p class="my-meeting-desc">Comments: ' + meetingDesc + '</p>'
                                          + '<p class="my-meeting-buddies-count">Buddies: '
                                                + currentBuddies + '/' + meetingMaxBuddies + '</p>'
                                          + '<div class="my-meeting-buddies"><p>' + meetingBuddies + '</p></div>'
                                          + '<div data-role="controlgroup" data-type="horizontal" id="meeting-button-' + meetingID + '"></div>';
                    document.getElementById( 'meeting-details-' + meetingID ).innerHTML = meetingDetailsStr;
                    
                    // Buttons for meeting master.
                    if( meetingFilter == 2 )
                    {
                        var buttonGroup = '<a href="#" id="edit-meeting-' + meetingID + '" data-role="button">Edit Meeting</a>';
                        document.getElementById( 'meeting-button-' + meetingID ).innerHTML = buttonGroup;
                        $('#edit-meeting-' + meetingID ).button();
                        
                        $('#edit-meeting-' + meetingID ).on('click touchend', function()
                        {
                            populateEditMeetingFields( meetingCourse, 
                                                       meetingLoc, 
                                                       meetingDesc, 
                                                       meetingStartTime, 
                                                       meetingEndTime, 
                                                       meetingMaxBuddies, 
                                                       meetingID );
                            $.mobile.changePage('#page-edit-meeting');
                        });
                    }
                    
                    else if( meetingFilter == 1 )
                    {
                        var buttonGroup = '<a href="#" id="leave-meeting-' + meetingID + '" data-role="button">Leave Meeting</a>';
                        document.getElementById( 'meeting-button-' + meetingID ).innerHTML = buttonGroup;
                        $('#leave-meeting-' + meetingID ).button();
                        
                        $('#leave-meeting-' + meetingID ).on('click touchend', function()
                        {
                            leaveMeeting( ajaxURL, meetingID );
                            getAllMyMeetings( ajaxURL );
                        });
                        
                    }
                    
                    else
                    {
                        if( meetingMaxBuddies > currentBuddies )
                        {
                            var buttonGroup = '<a href="#" id="join-meeting-' + meetingID +'" data-role="button">Join Meeting</a>';
                            document.getElementById( 'meeting-button-' + meetingID ).innerHTML = buttonGroup;
                            $('#join-meeting-' + meetingID ).button();
                            $('#join-meeting-' + meetingID ).on('click touchend', function()
                            {
                                joinMeeting ( ajaxURL, meetingID );
                                getAllMyMeetings( ajaxURL );
                            });
                        }
                        else
                        {
                            var buttonGroup = '<h3>Meeting Full</h3>';
                            document.getElementById( 'meeting-button-' + meetingID ).innerHTML = buttonGroup;
                            
                        }
                        
                        
                        
                    }
                }
            });
        $('#meeting-details-' + meetingID ).slideToggle();
    });
    $('#meeting-details-' + meetingID ).hide();
}

/*call a function to create meeting details and append them to a parent element
    @param meetingIDContainer the parent element ID to which elements created here will be appended
    @param meetingDesc the meeting description
    @param maxbuddies: the max Number of buddies
    @param meetingbuddies: an Array of users attending this meeting */
function createMeetingDetails( meetingIDContainer, meetingDesc, meetingEndDate, meetingMaxBuddies, meetingBuddies)
{
    var containerDiv = document.getElementById( meetingIDContainer );

    var descElement = document.createElement( "p" );
    descElement.innerHTML( "Description: " + meetingDesc );
    containerDiv.appendChild( descElement );

    var endElement = document.createElement( "p" );
    endElement.innerHTML( "End Date: " + meetingEndDate );
    containerDiv.appendChild( endElement );

    var maxBuddiesElement = document.createElement( "p" );
    maxBuddiesElement.innerHTML( "Max Buddies: " + meetingMaxBuddies );
    containerDiv.appendChild( maxBuddiesElement );

    var buddiesElement = document.createElement( "p" );
    buddiesElement.innerHTML( "Buddies: " + "<br/>" + meetingBuddies );
    containerDiv.appendChild( buddiesElement );
}

/* goes through the meetingList array and adds it to the HTML list if called*/
function regenerateList()
{    
	var count = 0;

	$("#my-meetings-list").html("");
	for( i = 0; i < meetingList.length; i++ )
	{
		if(allMeeting && meetingList[i].filter == 0)
		{
			var icon = ( meetingList[i].cancelled ) ? 'cancel' : 'bars';
			count += 1;
		
			addMeetingToList(meetingList[i].ID,
							 meetingList[i].courseID,
							 meetingList[i].location,
							 meetingList[i].startDate,
							 meetingList[i].cancelled,
							 meetingList[i].filter,
                             icon );
		}
		else if( iCreated && meetingList[i].filter == 2)
		{
			var icon = ( meetingList[i].cancelled ) ? 'cancel' : 'star';
			count += 1;
		
			addMeetingToList(meetingList[i].ID,
							 meetingList[i].courseID,
							 meetingList[i].location,
							 meetingList[i].startDate,
							 meetingList[i].cancelled,
							 meetingList[i].filter,
                             icon );
		}
		else if( iAttending && meetingList[i].filter == 1)
		{
			var icon = ( meetingList[i].cancelled ) ? 'cancel' : 'check';
			count += 1;
		
			addMeetingToList(meetingList[i].ID,
							 meetingList[i].courseID,
							 meetingList[i].location,
							 meetingList[i].startDate,
							 meetingList[i].cancelled,
							 meetingList[i].filter,
                             icon );
		}
	}
    $('#my-meetings-list').listview('refresh');
	
	if ( meetingList.length > 0 )
	{
		$( "#my-meeting-no-courses" ).hide();
	}
	else
	{
		$( "#my-meeting-no-courses" ).show();
	}
}

/*This function will check the toggles and add the meetings that match the criteria to the list.
*/    
function myMeetingOnReady(){
    $('#my-meetings-list').listview();
    getAllMyMeetings( ajaxURL );
    
	$( "#my-meeting-no-courses" ).hide();
	
    $( '#i-created' ).on( 'click touchend', function(e)
        {
            iCreated = !iCreated;

            if( iCreated )
            {
			    $('#i-created').attr( 'data-icon', 'star' );
                $('#i-created').removeClass( 'ui-icon-no-star' );
                $('#i-created').addClass( 'ui-icon-star' );
                $('#i-created').addClass('toggled');
            }
            else
            {
			    $('#i-created').attr( 'data-icon', 'no-star' );
                $('#i-created').removeClass( 'ui-icon-star' );
                $('#i-created').addClass( 'ui-icon-no-star' );
                $('#i-created').removeClass('toggled');
            }

            regenerateList();
            
            return false;
            
        });
    $( '#not-attending' ).on( 'click touchend', function(e)
        {
            allMeeting = !allMeeting;

            if( allMeeting )
            {
			    $('#not-attending').attr( 'data-icon', 'bars' );
                $('#not-attending').removeClass( 'ui-icon-no-bars' );
                $('#not-attending').addClass( 'ui-icon-bars' );
                $('#not-attending').addClass('toggled');
            }
            else
            {
			    $('#not-attending').attr( 'data-icon', 'no-bars' );
                $('#not-attending').removeClass( 'ui-icon-bars' );
                $('#not-attending').addClass( 'ui-icon-no-bars' );
                $('#not-attending').removeClass('toggled');
            }

            regenerateList();
            
            return false;
        });
    $( '#i-attending' ).on( 'click touchend', function(e)
        {
            iAttending = !iAttending;
            
            if( iAttending )
            {
			    $('#i-attending').attr( 'data-icon', 'check' );
                $('#i-attending').removeClass( 'ui-icon-no-check' );
                $('#i-attending').addClass( 'ui-icon-check' );
                $('#i-attending').addClass('toggled');
            }
            else
            {
			    $('#i-attending').attr( 'data-icon', 'no-check' );
                $('#i-attending').removeClass( 'ui-icon-check' );
                $('#i-attending').addClass( 'ui-icon-no-check' );
                $('#i-attending').removeClass('toggled');
            }

            regenerateList();
            
			return false;
        });

        //
        alterPickerTimes(".datetime-picker");
        //
}


   

    
    
/*
 * Validates form input.
 * 
 * @returns true on valid false on invalid.
 */
function validateMeetingParams( courseID, 
                               maxBuddies, 
                               courseDescription, 
                               startTime,
                               endTime,
                               meetingLocation,
                               errorDiv )
{
    var retval = true;
    
    // Reset error div.
    errorDiv.innerHTML = '';
    
    // Checks that there is a course.
    if( !courseID.match( /^([A-Z]{4}[0-9]{4})$/gi ) )
    {
        errorDiv.innerHTML += formatError( 'invalid course!' );
        
        retval = false;
    }
    
    // Checks that the number of buddies entered is an int.
    if( !maxBuddies.match( /^[0-9]+$/) )
    {
        errorDiv.innerHTML += formatError( 'You must specify maximum number of buddies' );
        
        retval = false;
    }
    
    // Check that there is a meeting comment set.
    if( courseDescription.length < 1 )
    {
        errorDiv.innerHTML += formatError( 'You must enter a comment' );
        
        retval = false;
    }
    
    //Check that the dates are valid.
    if( !validateDates( startTime, endTime, errorDiv ) )
    {
        retval = false;
    }
    
    return retval;
}

/*
 * At this point just formats a string into a paragraph in a "error" class div.
 *
 * @param str the string to be added to the div.
 *
 * @returns a string in a paragraph tag in a error class div.
 */
function formatError( str )
{
    return '<div class="error"><p>' + str + '</p></div>';
}
    
/*
 * Validates the date fields.
 * 
 * @param start date string.
 * @param end date string.
 * 
 * @returns true on valid, string on invalid.
 */
function validateDates( startDate, endDate, errorDiv )
{
    // Verifies that something has been entered in the date box.
    if( startDate.length < 1 || endDate.length < 1 )
    {
        errorDiv.innerHTML += formatError( 'Please enter start and end '
             + 'dates for your meeting!' );
    }         
    
    var start = new Date( startDate );
    var end   = new Date( endDate );
    
    // Must end in the future!
    if( end.getTime() < Date.now() )
    {
        
        errorDiv.innerHTML += formatError( 'meeting ends in the past!' );
        
        return false;
    }
    
    // The meeting must end after it starts.
    if( end.getTime() < start.getTime() )
    {
        errorDiv.innerHTML += formatError( 'meeting must start before' 
            + 'it ends.' );
        
        return false;
    }
    
    return true;
}
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

/*
 * Creates a meeting.
 */
function submitEditMeeting()
{
    // Ready parameters.
    var courseID          = document.getElementById( 'course-edit-dropdown' ).innerHTML;///////////////////////////////
    var maxBuddies        = document.getElementById( 'edit-max-buddies' ).value;
    var courseDescription = document.getElementById( 'edit-meeting-comments' ).value;
    var startTime         = document.getElementById( 'meeting-start-datetime' ).value;
    var endTime           = document.getElementById( 'meeting-end-datetime' ).value;
    var meetingLocation   = document.getElementById( 'edit-location' ).value;
    var errorDiv          = document.getElementById( 'edit-meeting-error' );
    var meetingID         = document.getElementById( 'meeting-id' ).value;
    
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
        
        
        // Call ajax function to edit meeting.
        editMeeting ( ajaxURL, 
                      meetingID,
                      courseID,
                      courseDescription,
                      meetingLocation,
                      startTime,
                      endTime,
                      maxBuddies )
    }
    return;
}

function getHumanDate( d )
{
    date = new Date( d );
    
    return date.toDateString();
}

/* allow 15 minute increments in the date time piker */

function generateTimes ()
{
    var times = [];
    var i = 0;

    for ( h = 0 ; h < 24 ; h++ )
    {
        for ( m = 0 ; m < 60 ; m += 15 )
        {
            min = m;
            if ( m == 0 )
            {
                // displays 0 as 00 minutes
                min = "00";
            }
            var timeString = "" + h + ":" + min;
            times[i] = timeString;
            i++;
        }
    }
    return times;
}

function alterPickerTimes ( dateTimePickerID )
{
    jQuery( dateTimePickerID ).datetimepicker
    ({
        inline: true,
        allowTimes:generateTimes()
    });
}