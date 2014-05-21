/* a method to return all the meetings that you are attending.
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
            for( var i = 0; i < json.length; ++i )
            {
                var meetingID = json.id;
                var meetingCourse = json.courseID;
                var meetingLoc = json.location;
                var meetingStartTime = json.startDate;
                var meetingCancelled = json.cancelled;
                var meetingFilter = json.filter;            // filter will determine which mode people will be able to use for a meeting and how it displays in lists

                //populate the list of all meetings with a helper function
                addMeetingToList ( meetingID, meetingCourse, meetingLoc, meetingStartTime, meetingCancelled, meetingFilter );
            }
        }
    });
}

/* a method to return the details for one specific meeting
    returns an array containing a course description string, end date string, max buddies int, and an array of buddies currently signed up to the meeting
    @param ajax_URL (string): 
    @param meetingID (INT): a numeric unique ID for a meeting */

function getMeetingDetails ( ajax_URL, meetingID )
{
    $.ajax
    ({
        url: ajax_URL + 'meetings/meeting-details.php',
        type: 'POST',
        data:
        {
            method: 'get-meetings',
            id: meetingID
        },
        dataType: "json",
        success: function ( json )
        {
            var meetingDesc = json.description;
            var meetingEndDate = json.endDate;
            var meetingMaxBuddies = json.maxBuddies;
            var meetingBuddies = json.buddies //an array of displayNames

            //call a helper function in order to populate the edit meetings page

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
        success: function ( json )
        {
            //to do later
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
        success: function ( json )
        {
            if( json.success == true )
            {
                document.getElementById( 'create-meeting-form' ).reset();
                $.mobile.changePage( '#page-my-meetings' )
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
            //to do later
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
        success: function ( json )
        {
            //to do later
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
            //to do later
        }
    });
}

/*---------------------------------- HELPER FUNCTIONS BELOW ---------------------------------------*/
/* used to add the details of a particular meeting to a HTML form, for editing meetings
    @param meetingID the unique ID assigned to a meeting */

function populateMeetingDetails ( description, meetingEndDate, meetingMaxBuddies, meetingBuddies )
{
    //select a form element and assign json data to it
    var element = document.getElementById("course-dropdown");
    element.setAttribute("value", /* json data */);

    var element = document.getElementById("location-dropdown");
    element.setAttribute("value", /* json data */);

    var element = document.getElementById("meeting-datetime");
    element.setAttribute("value", /* json data */);

    var element = document.getElementById("max-buddies");           //note: must not allow user to change this to a value lower than the current # of buddies.
    element.setAttribute("value", /* json data */);

    var element = document.getElementById("meeting-comments");
    element.setAttribute("value", /* json data */);
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
    //make sure my-meetings-list is in a container with  data-role="collapsible" so that we get the nice drop down effect for meeting info.
    //get the element to get meetings added to it
    var meetingList = document.getElementById('my-meetings-list');
    $('#my-meetings-list').listview();


    //call an ajax function for add additional information from the server (if needed) and assign it to variables
    
    
    //use createElement() to make a div with data-role="collapsible" to store the course information
    var listElement = document.createElement("div");
    listElement.setAttribute("data-role", "collapsible")

    //add information into this new collapsible div
    listElement.innerHTML=

    //add information to the meetingList varable as a child node (i guess)
}
    
/*   --- CALVIN'S DEMO STUFF
$( '#i-created' ).on( 'click tap', function(e)
{
    iCreated = !iCreated;

    regenerateList();
});

function regenerateList()
{
    for( i = 0; i < courses.length; i += 1 )
    {
        if ( iCreated && courses[i].creator === me )
        {
            addMeetingToList(();
        }
        ...
    }
}
*/

/*
$( '#i-created' ).on( 'click tap', function(e)
    {


        var templist;
        for(blabla)
        {
            if(beepboop.filter == '2')
            {
                //add to list
            }
        }
        //remove current list
        //append new list
        //refresh
    });
$( '#all-meeting' ).on( 'click tap', function(e)
    {
        //remove current list
        //append original list from request
        //refresh
    });
$( '#i-attending' ).on( 'click tap', function(e)
    {
        var templist;
        for(blabla)
        {
            if(beepboop.filter == '1')
            {
                //add to list
            }
        }
        //remove current list
        //append new list
        //refresh
    });

function regenerateList(iCreated,allMeeting,iAttending)
{    
    var templist;
    for(blablabla)
    {
        if(iCreated)
        {
            if(bla.filter == '2')
            {
                addMeetingToList(bla);
            }
        }
        if(allMeeting)
        {
            while(templist.length != 0)
            {
                removeMeetingfromList(templist[i]);
            }
            while(list.length != templist.length)
            {
                addMeetingToList(list[i]);
            }
        }
        if(iAttending)
        {

        }
    }
}

function addMeetingToList()
{

}

function removeMeetingFromList()
{

}
*/

