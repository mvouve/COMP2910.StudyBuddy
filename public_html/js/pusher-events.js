var pusher;
var channels = new Array();

function setupPusher()
{
	pusher = new Pusher( '7abde25051bc963f5a03', { authEndpoint: ajaxURL + 'pusher_auth.php' });
	channels['study_buddy'] = pusher.subscribe( 'study_buddy' );
	
	channels['study_buddy'].bind( 'course_added', pusherCourseAdded );
}

// Bind pusher to a course-specific private channel
function bindToCourse( course )
{
	channels[course] = pusher.subscribe( 'private-' + course );
	channels[course].bind( 'meeting_added', pusherMeetingAdded );
	channels[course].bind( 'meeting_cancelled', pusherMeetingCancelled );
	channels[course].bind( 'meeting_editted', pusherMeetingChanged );
}

// Unbind pusher from a course-specific private channel
function unbindFromCourse( course )
{
	pusher.unsubscribe( 'private-' + course );
    delete channels[ course ];
}

function unbindFromAllCourses()
{
    console.log( JSON.stringify( channels ) );

	for ( var id in channels )
	{
        console.log( id );
		if ( id != 'study_buddy' )
		{
			unbindFromCourse( id );
		}
	}
}

// Pusher Callback on Course Creation
function pusherCourseAdded( data )
{
    var isCreator = ( data.creator == uid );
    
    $.post( ajaxURL + 'courses/courses.php',
                        {
                            method: 'silent-add',
                            id: data.id,
                            title: data.title
                        },
                        function( data ) {},
                        "json");
    
    allCoursesServerResponse[data.id] = { 'title':data.title, 'inCourse':isCreator };
    masterCourseListAdd( ajaxURL, data.id, data.title, isCreator );
    $('#all-courses-list').listview('refresh');
}

/*
 * Pusher Callback on meeting creation
    @param data  this is an array containing:
        ID: the ID of the meeting
        courseID: the ID of course
        creatorID: unique user ID fo the meeting creator
        location: the meeting location
        startTime: meeting start time
 */
function pusherMeetingAdded( data )
{
	var filterSetting;

	// Filter: 0 not attending, 1 attending, 2 created
	if ( data.creator == uid )
	{
		filterSetting = 2;
	}
	else
	{
		filterSetting = 0;
	}
	
	// add this meeting data to the meetingList array
    meetingList[ meetingList.length ] = {
		ID: data.ID,
		location: data.location,
		startDate: data.startTime,
		canceled: false,
		courseID: data.courseID,
		filter: filterSetting
	};
	
	// Set Local Notification
	if ( data.creator == uid )
	{
		var date = new Date( data.startTime );
		addMeetingNotification( data.ID, data.courseID, data.location, date );
	}
	
    // regenerate the list by the regenerate function
    regenerateList();
}

/*
 * Pusher Callback on a Meeting being Cancelled.
     @param data  this is an array containing:
        ID: the ID of the meeting
 */
function pusherMeetingCancelled( data )
{
	console.log( "CALLBACK" );

	//go into meeting list and look for meeting with this ID and set its cancelled property/flag to true
    for ( var i = 0 ; i < meetingList.length ; i++ )
    {
        if ( meetingList[i].ID == data.ID)
        {
			console.log( "MEETING FOUND" );
            meetingList[i].canceled = true;
			cancelMeetingNotification( data.ID );
			break;
        }
    }
    // regenerate the list
    regenerateList();
}

/*
 * Pusher Callback on Meeting editted.
     @param data  this is an array containing:
        ID: the ID of the meeting
        courseID: the ID of course
        creatorID: unique user ID fo the meeting creator
        location: the meeting location
        startTime: meeting start time
 */
function pusherMeetingChanged( data )
{
	//look through meeting list array, find the meeting with this ID
    //change its values to the new ones
    //regenerate the list.
	//go into meeting list and look for meeting with this ID and set its cancelled property/flag to true
    for ( var i = 0 ; i < meetingList.length ; i++ )
    {
        if ( meetingList[i].ID == data.ID)
        {
            meetingList[i] = data;
			var date = new Date( data.startTime );
			
			editMeetingNotification( data.ID, data.courseID, data.location, date );
			
			break;
        }
    }
    // regenerate the list
    regenerateList();
}