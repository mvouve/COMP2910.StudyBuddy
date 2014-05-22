var eventQueue = [];

function getEvents()
{
	var tempArray = eventQueue.slice();
	eventQueue = [];
	
	return tempArray;
}

function addMeetingNotification( meetingID, courseID, location, meetingStartTime )
{
	var event = {
					method: 'add-notification',
					id:      meetingID,
					title:   'StudyBuddy Reminder: ' + courseID,
					message: 'Your study meeting for ' + courseID + ' starts in 30 minutes in ' + location + "!",
					date:    new Date( meetingStartTime.getTime() - 60 * 1000 * 30 )
				};
				
	eventQueue[ eventQueue.length ] = event;
}

function cancelMeetingNotification( meetingID )
{
    var event = {
                    method: 'cancel-notification',
                    id: meetingID
                };
                
    eventQueue[ eventQueue.length ] = event;
}

function editMeetingNotification( meetingID, courseID, location, meetingStartTime )
{
    cancelMeetingNotification( meetingID );
    addMeetingNotification( meetingID, courseID, location, meetingStartTime)
}