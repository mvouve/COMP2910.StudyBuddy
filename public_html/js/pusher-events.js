var pusher;
var channel;

function setupPusher()
{
	pusher = new Pusher('7abde25051bc963f5a03');
	channel = pusher.subscribe( 'study_buddy' );
	
	channel.bind( 'course_added', pusherCourseAdded );
}

function pusherCourseAdded( data )
{
    masterCourseListAdd( data.id, data.title, false );
    $('#all-courses-list').listview('refresh');
}