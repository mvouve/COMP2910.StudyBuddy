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