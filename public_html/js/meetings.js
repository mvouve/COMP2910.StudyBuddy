/* GLOBAL VARIABLES */
var meetingList = {};
var iCreated = false;
var allMeeting = false;
var iAttending = false;

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
            id: meetingID,
            courseId: courseID,
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
            id: userID
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

function populateEditMeetingFields ( courseID, meetingLoc, description, meetingStartDate, meetingEndDate, meetingMaxBuddies )
{
    //select a form element and assign json data to it
	
    var element = document.getElementById("courseID");
    element.innerHTML(courseID);

    var element = document.getElementById("edit-location");
    element.setAttribute("value", meetingLoc);

    var element = document.getElementById("meeting-start-datetime");
    element.setAttribute("value", meetingStartDate);

    var element = document.getElementById("meeting-end-datetime");
    element.setAttribute("value", meetingEndDate);

    var element = document.getElementById("max-buddies");
    element.setAttribute("value", meetingMaxBuddies);

    var element = document.getElementById("meeting-comments");
    element.setAttribute("value", description);
	
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

function addMeetingToList ( meetingID, meetingCourse, meetingLoc, meetingStartTime, meetingCancelled, meetingFilter )
{
    //to clarify things for myself i will draw a crude sketch of the heirarchy here since there are going to be a LOT OF ELEMENTS
    //DIV: meetingList
    //    DIV: ListElement #1 data-role="collapsible"
    //       h1: ListHeader
    //       div: listBody
    //          p: meeting detail #1
    //          p: meeting detail #2
    //                  ...
    //          p: meeting detail #n
    //          div: buttonBar
    //              if (meetingFilter == 2) {button: edit meeting, button: cancel meeting}
    //                          Marc says "The edit button needs to send an id to the edit meeting page.
    //                                     This might need to be done with a session variable."
    //              if (meetingFilter != 2 && <not attending> && <meeting not cancelled>) {button: join meeting}
    //              if (meetingFilter != 2 && <attending>) {button: leave meeting}
    //    DIV: ListElement #2 data-role="collapsible"
    //       h1: ListHeader
    //       div: listBody
    //          p: meeting detail #1
    //          p: meeting detail #2
    //                  ...
    //          p: meeting detail #n
    //          div: buttonBar
    //              if (meetingFilter == 2) {button: edit meeting, button: cancel meeting}
    //              if (meetingFilter != 2 && <not attending> && <meeting not cancelled>) {button: join meeting}
    //              if (meetingFilter != 2 && <attending>) {button: leave meeting}
    //     ...
    //    DIV: ListElement #n data-role="collapsible"
    //       h1: ListHeader
    //       div: listBody
    //          p: meeting detail #1
    //          p: meeting detail #2
    //                  ...
    //          p: meeting detail #n
    //          div: buttonBar
    //              if (meetingFilter == 2) {button: edit meeting, button: cancel meeting}
    //              if (meetingFilter != 2 && <not attending> && <meeting not cancelled>) {button: join meeting}
    //              if (meetingFilter != 2 && <attending>) {button: leave meeting}



    //assign the meetings list element to a variable
    var meetingList = document.getElementById( 'my-meetings-list' );
    
    //use createElement() to make a div with data-role="collapsible" to store the course information
    var listElement = document.createElement( "div" );
    listElement.setAttribute( "data-role", "collapsible" );
    
    //set the div id for the list element which will contain all the data for a meeting
    listElement.setAttribute( "id", "meeting-" + meetingID );


    //create a header to store main information on a meeting
    var listHeader = document.createElement( "h1" );
    listHeader.innerHTML( "Course: " + meetingCourse + "<br/>" + "Location: " + meetingLoc + "<br/>" + "Date: " + meetingStartTime );

    //create a div element to store detailed/supplementary information on a meeting
    var listBody = document.createElement( "div" );

    //create a div container for buttons which will appear at the bottom of the expanded accordion
    var buttonBar = document.createElement( "div" );
    
    //add information to the meetingList varable as a child node (i guess)
    listElement.appendChild(listHeader);
    listElement.appendChild(listBody);
    listElement.appendChild(buttonBar);
    meetingList.appendChild(listElement);

    $('#meeting-' + meetingID).bind( 'expand', function () 
    {
        // need some code here to remove any existing children from the parent list element that may exist from previous expands
        this.empty();

        //ajax call to retrueve information from the server and call a function to create meeting details
        $.ajax
        ({
            url: ajax_URL + 'meetings/meetings.php',
            type: 'POST',
            data:
            {
                method: 'get-meeting-details',
                id: meetingID
            },
            dataType: "json",
            success: function ( json )
            {
                var meetingDesc = json.description;
                var meetingEndTime = json.endDate;
                var meetingMaxBuddies = json.maxBuddies;
                var meetingBuddies = "";
                
                for ( var i = 0 ; i<json.buddies.length ; i++ )
                {
                    meetingBuddies = "" + json.buddies[i] + "<br/>";
                }

                /* call a function to create meeting details and append them to a parent element */
                createMeetingDetails( '#meeting-' + meetingID, meetingDesc, meetingEndTime, meetingMaxBuddies, meetingBuddies)

                //create buttons based on the user's relationship to this meeting
                if ( meetingFilter == 2 )
                {
                    //button: edit meeting, button: cancel meeting
                    var editButton = document.createElement( "button" );
                    editButton.innerHTML( "Edit Meeting" );
                    editButton.on( 'click tap', function()
                    {
                        //call populate fields method for editing
                        /* populateEditMeetingFields ( courseID, meetingLoc, description, meetingStartDate, meetingEndDate, meetingMaxBuddies, meetingComments ) */
                        populateEditMeetingFields ( meetingCourse, meetingLoc, meetingDesc, meetingStartTime, meetingEndTime, meetingMaxBuddies )
                        //move the user to the edit meetings page.
                    });

                    var cancelButton = document.createElement( "button" );
                    cancelButton.innerHTML( "Edit Meeting" );
                    cancelButton.on( 'click tap', function()
                    {
                        //call the cancel meetings function.
                    });

                    buttonBar.appendChild(editButton);
                    buttonBar.appendChild(cancelButton);
                }
                else if ( ( meetingFilter == 0 ) && ( meetingCancelled == false ) )
                {
                    //button: join meeting
                    var joinButton = document.createElement( "button" );
                    joinButton.innerHTML( "Edit Meeting" );
                    joinButton.on( 'click tap', function()
                    {
                        //call the join meeting function.
                    });
                    buttonBar.appendChild(joinButton);
                }
                else if ( ( meetingFilter == 1 ) && ( meetingCancelled == false ) )
                {
                    //button: leave meeting
                    var leaveButton = document.createElement( "button" );
                    leaveButton.innerHTML( "Edit Meeting" );
                    leaveButton.on( 'click tap', function()
                    {
                        //call the leave meeting function.
                    });
                    buttonBar.appendChild(leaveButton);
                }
            }
        });
    });
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
	$("#my-meeting-list").html("");
	for( i = 0; i < meetingList.length; i += 1 )
	{
		if(allMeeting && meetingList.filter == 0)
		{
			addMeetingToList(meetingList[i].ID,
							 meetingList[i].courseID,
							 meetingList[i].location,
							 meetingList[i].startDate,
							 meetingList[i].cancelled,
							 meetingList[i].filter);
		}
		else if( iCreated && meetingList.filter == 2)
		{
			addMeetingToList(meetingList[i].ID,
							 meetingList[i].courseID,
							 meetingList[i].location,
							 meetingList[i].startDate,
							 meetingList[i].cancelled,
							 meetingList[i].filter);
		}
		else if( iAttending && meetingList.filter == 1)
		{
			addMeetingToList(meetingList[i].ID,
							 meetingList[i].courseID,
							 meetingList[i].location,
							 meetingList[i].startDate,
							 meetingList[i].cancelled,
							 meetingList[i].filter);
		}
	}
}

/*This function will check the toggles and add the meetings that match the criteria to the list.
*/    
function myMeetingOnReady(){

    $( '#i-created' ).on( 'touchend', function(e)
        {
            iCreated = !iCreated;
			
			$('#i-created').toggleClass("toggled");
            regenerateList();
            return false;
        });
    $( '#not-attending' ).on( 'touchend', function(e)
        {
            allMeeting = !allMeeting;
			
			$('#not-attending').toggleClass("toggled");
            regenerateList();
            return false;
        });
    $( '#i-attending' ).on( 'touchend', function(e)
        {
            iAttending = !iAttending;
			
			$('#i-attending').toggleClass("toggled");
            regenerateList();
			return false;
        });
}


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
 * Validates form input.
 * 
 * @returns true on valid false on invalid.
 */
function validateCreateMeeting()
{
    var errorDiv = document.getElementById('create-meeting-error');
    var retval = true;
    
    // Reset error div.
    errorDiv.innerHTML = '';
    
    // Checks that there is a course.
    if( !document.getElementById('course-dropdown').value.match( /^([A-Z]{4}[0-9]{4})$/gi ) )
    {
        errorDiv.innerHTML += formatError( 'invalid course!' );
        
        retval = false;
    }
    
    // Checks that the number of buddies entered is an int.
    if( !document.getElementById('max-buddies').value.match( /^[0-9]+$/) )
    {
        errorDiv.innerHTML += formatError( 'You must specify maximum number of buddies' );
        
        retval = false;
    }
    
    // Check that there is a meeting comment set.
    if( document.getElementById('meeting-comments').value.length < 1 )
    {
        errorDiv.innerHTML += formatError( 'You must enter a comment' );
        
        retval = false;
    }
    
    //Check that the dates are valid.
    var startDate = document.getElementById( 'create-meeting-start-datetime' );
    var endDate   = document.getElementById( 'create-meeting-end-datetime' );
    if( !validateDates( startDate, endDate, errorDiv ) )
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
    if( startDate.length > 1 || endDate.length > 1 )
    {
        errorDiv.innerHTML += formatError( 'Please enter start and end'
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
    // Check for valid fields.
    if( validateCreateMeeting() )
    {
        // Ready parameters.
        var courseID          = document.getElementById( 'course-dropdown' ).value;
        var maxBuddies        = document.getElementById( 'max-buddies' ).value;
        var courseDescription = document.getElementById( 'meeting-comments' ).value;
        var startTime         = document.getElementById( 'create-meeting-start-datetime' ).value;
        var endTime           = document.getElementById( 'create-meeting-end-datetime' ).value;
        var meetingLocation   = document.getElementById( 'location-dropdown' ).value;
        
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
 * Validates form input.
 * TODO: Make this function more generalised so it can be merged.
 * 
 * @returns true on valid false on invalid.
 */
function validateEditMeeting()
{
    var errorDiv = document.getElementById('edit-meeting-error');
    var retval = true;
    
    // reset the error div.
    errorDiv.innerHTML = '';
    
    // Checks that there is a course.
    if( !document.getElementById('course-dropdown').value.match( /^([A-Z]{4}[0-9]{4})$/gi ) )
    {
        errorDiv.innerHTML += formatError( 'invalid course!' );
        
        retval = false;
    }
    
    // Checks that the number of buddies entered is an int.
    if( !document.getElementById('max-buddies').value.match( /^[0-9]+$/) )
    {
        errorDiv.innerHTML += formatError( 'You must specify maximum number of buddies' );
        
        retval = false;
    }
    
    // Check that there is a meeting comment set.
    if( document.getElementById('meeting-comments').value.length < 1 )
    {
        errorDiv.innerHTML += formatError( 'You must enter a comment' );
        
        retval = false;
    }
    
    //Check that the dates are valid.
    var startDate = document.getElementById( 'create-meeting-start-datetime' );
    var endDate   = document.getElementById( 'create-meeting-end-datetime' );
    if( !validateDates( startDate, endDate, errorDiv ) )
    {
        retval = false;
    }
    
    return retval;
}