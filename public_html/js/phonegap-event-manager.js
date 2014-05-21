var eventQueue = [];

function getEvents()
{
	var tempArray = eventQueue.slice();
	eventQueue = {};
	
	return tempArray;
}

function addMeetingNotification( meetingID, courseID, location, meetingStartTime)
{
	var event = {
					method: 'add-notification',
					id:      meetingID,
					title:   'StudyBuddy Reminder: ' + courseID,
					message: 'Your study meeting for courseID starts in 30 minutes in the ' + location + "!",
					date:    new Date( meetingStartTime.getTime() - 60 * 1000 * 30 )
				};
				
	eventQueue[ eventQueue.length ] = event;
}