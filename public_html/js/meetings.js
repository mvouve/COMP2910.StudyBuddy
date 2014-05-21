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



    //get the element to get meetings added to it
    var meetingList = document.getElementById( 'my-meetings-list' );
    
    //use createElement() to make a div with data-role="collapsible" to store the course information
    var listElement = document.createElement( "div" );
    listElement.setAttribute( "data-role", "collapsible" );
    listElement.setAttribute( "class", "list-element" );


    //create a header to store main information on a meeting
    var listHeader = document.createElement("h1");
    listHeader.innerHTML( "Course: " + meetingCourse + "<br/>" + "Location: " + meetingLoc + "<br/>" + "Date: " + meetingStartTime );

    //create a div element to store detailed/supplementary information on a meeting
    var listBody = document.createElement("div");
    
    //add information to the meetingList varable as a child node (i guess)
    listElement.appendChild(listHeader);
    listElement.appendChild(listBody);
    meetingList.appendChild(listElement);

    $('.list-element').bind('expand', function () 
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
                var meetingEndDate = json.endDate;
                var meetingMaxBuddies = json.maxBuddies;
                var meetingBuddies = json.buddies //an array of displayNames


                for ( var i = 0 ; i<json.buddies.length ; i++ )
                {
                    meetingBuddies = "" + meetingBuddies + json.buddies[i] + "<br/>";
                }

                /*call a function to create meeting details and append them to a parent element
                    @param meetingDesc the meeting description
                    @param maxbuddies: the max Number of buddies
                    @param meetingbuddies: an Array of users attending this meeting */
                createMeetingDetails( meetingDesc, meetingEndDate, meetingMaxBuddies, meetingBuddies)
            }
        });
    });
}

/*call a function to create meeting details and append them to a parent element
    @param parentID the parent element ID
    @param meetingDesc the meeting description
    @param maxbuddies: the max Number of buddies
    @param meetingbuddies: an Array of users attending this meeting */
function createMeetingDetails( meetingDesc, meetingEndDate, meetingMaxBuddies, meetingBuddies)
{
    var descElement = document.createElement("p");
    descElement.innerHTML("Description: " + meetingDesc);

    var endElement = document.createElement("p");
    endElement.innerHTML("End Date: " + meetingEndDate);

    var maxBuddiesElement = document.createElement("p");
    maxBuddiesElement.innerHTML("Max Buddies: " + meetingMaxBuddies);

    var buddiesElement = document.createElement("p");
    buddiesElement.innerHTML("Buddies: " + "<br/>" + meetingBuddies);
}

/*This function will check the toggles and add the meetings that match the criteria to the list.
*/    
function myMeetingOnReady(){
    var iCreated = false;
    var allMeeting = false;
    var iAttending = false;

    $( '#i-created' ).on( 'click tap', function(e)
        {
            iCreated = !iCreated;
            regenerateList();
        });
    $( '#all-meeting' ).on( 'click tap', function(e)
        {
            allMeeting = !allMeeting;
            regenerateList();
        });
    $( '#i-attending' ).on( 'click tap', function(e)
        {
            iAttending = !iAttending;
            regenerateList();
        });

    function regenerateList()
    {    
        for( j = 0; j < meetingList.length; i+=1)
        {
               removeMeeting(course[i]);
        }
        for( i = 0; i < meetingList.length; i += 1 )
        {
            if(allMeeting && meetingList.filter == 0)
            {
                addMeetingToList(meetingList[i].meetingID,
                                 meetingList[i].meetingCourse,
                                 meetingList[i].meetingLoc,
                                 meetingList[i].meetingStartTime,
                                 meetingList[i].meetingCancelled,
                                 meetingList[i].meetingFilter);
            }
            else if( iCreated && meetingList.filter == 2)
            {
                addMeetingToList(meetingList[i].meetingID,
                                 meetingList[i].meetingCourse,
                                 meetingList[i].meetingLoc,
                                 meetingList[i].meetingStartTime,
                                 meetingList[i].meetingCancelled,
                                 meetingList[i].meetingFilter);
            }
            else if( iAttending && meetingList.filter == 1)
            {
                addMeetingToList(meetingList[i].meetingID,
                                 meetingList[i].meetingCourse,
                                 meetingList[i].meetingLoc,
                                 meetingList[i].meetingStartTime,
                                 meetingList[i].meetingCancelled,
                                 meetingList[i].meetingFilter);
            }
        }
    }
}

fucntion removeMeeting()
{
    //TO BE FILLED
}
