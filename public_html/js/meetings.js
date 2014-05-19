-- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- --

/* a method to return all the meetings that you are attending.
@param ajax_URL the URI location where the ajax folder is located */

function getMeetings( ajax_URL )
{
    $.ajax
    ({
        url: ajax_URL + 'meetings/meetings.php',
        data:
        {
            method: 'get-meetings'
        },
        dataType: "json",
        success: function ( json ) {
            var meetingID = json.id;
            var meetingCreator = json.creatorID;
            var meetingCourse = json.courseID;
            var meetingDesc = json.description;
            var meetingLoc = json.location;
            var meetingStartTime = json.startTime;
            var meetingEndTime = json.endTime;
            var meetingMaxBuddies = json.maxBuddies;
            var meetingBuddies = json.buddies;
            var meetingAttending = json.attending;

            //Do something with all this data now
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
        data:
        {
            method: 'create-meeting',
            course-id: courseID,        //problem: javascript does not like a hyphen in course-id. Change this once Calvin changes the back end name, i guess.
            description: courseDescription,
            location: meetingLocation, 
            start-time: startTime,      //ditto
            end-time: endTime,          //ditto
            max-buddies: maxBuddies    //ditto
        },
        dataType: "json",
        success: function ( json )
        {
            //to do later
        }
    });
}


/* called when the creator of a meeting needs to change something about the meeting
    @param ajax_URL  the URI location where the ajax folder is located
    @param meetingID: the meeting ID, determiend which meeting is to be altered
    @param courseID the course being studied at the meeting
    @param CourseDescription a description of the course
    @param meetingLocation the place where the meeting will be held
    @param startTime a datetime string informing when the meeting begins (YYYY-MM-DD HH:MM:SS)
    @param endTime a datetime string informing when the meeting ends (YYYY-MM-DD HH:MM:SS)
    @param maxBuddies the maximum number of people that a location can accomidate */
function editMeeting ( ajax_URL, meetingID, courseID, courseDescription, meetingLocation, startTime, endTime, maxBuddies )
{
    $.ajax
    ({
        url: ajax_URL + 'meetings/meetings.php',
        data:
        {
            method: 'edit-meeting',
            id: meetingID,
            course-id: courseID,        //problem: javascript does not like a hyphen in course-id. Change this once Calvin changes the back end name, i guess.
            description: courseDescription,
            location: meetingLocation, 
            start-time: startTime,      //ditto
            end-time: endTime,          //ditto
            max-buddies: maxBuddies    //ditto
        },
        dataType: "json",
        success: function ( json )
        {
            //to do later
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
/*------------------------------------------------------------------------------------------------------------
	method: leave-meeting
	id: int
	Returns: success: true | false
------------------------------------------------------------------------------------------------------------*/
