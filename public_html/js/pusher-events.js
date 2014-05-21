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
 */
function pusherMeetingAdded( data )
{
	
}

/*
 * Pusher Callback on a Meeting being Cancelled.
 */
function pusherMeetingCancelled( data )
{
	
}

/*
 * Pusher Callback on Meeting editted.
 */
function pusherMeetingChanged( data )
{
	
}