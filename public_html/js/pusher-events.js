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
	channels[course].bind( 'meeting_changed', pusherMeetingChanged );
}

// Unbind pusher from a course-specific private channel
function unbindFromCourse( course )
{
	pusher.unsubscribe( 'private-' + course );
	channels.splice( course, 1 );
}

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

function pusherMeetingAdded( data )
{
}

function pusherMeetingCancelled( data )
{
}

function pusherMeetingChanged( data )
{
}