-- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- --

/* a method to return all the meetings that you are attending.
@param ajax_URL the URI where the ajax folder is located */

function getMeetings(ajax_URL)
{
    $.ajax
    ({
        url: ajax_URL + 'meetings/meetings.php',
        method: get - meetings,
        success: function (json) {
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
   
   /* 
	method: get-meetings
	Returns: array [ id = int,
   creatorID = int,
   courseID = string,
   description = string,
   location = string,
   startTime = date,
   endTime = date,
   maxBuddies = int,
   buddies = array[ displayName ],
   attending = true | false
  ]
------------------------------------------------------------------------------------------------------------
	method: create-meeting
	course-id: string (eg. COMP1510)
	description: string
	location: string
	start-time: string (YYYY-MM-DD HH:MM:SS)
	end-time: string
	max-buddies: int
	Returns: success: true | false
------------------------------------------------------------------------------------------------------------
	method: edit-meeting
	id: int
	course-id: string
	description: string
	location: string
	start-time: string
	end-time: string
	max-buddies: int
	Returns: success: true | false
------------------------------------------------------------------------------------------------------------
	method: cancel-meeting
	id: int
	Returns: success: true | false
------------------------------------------------------------------------------------------------------------
	method: join-meeting
	id: int
	Returns: success: true | false
------------------------------------------------------------------------------------------------------------
------------------------------------------------------------------------------------------------------------
	method: leave-meeting
	id: int
	Returns: success: true | false
------------------------------------------------------------------------------------------------------------*/
