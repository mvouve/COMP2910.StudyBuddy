

var myCoursesServerResponse = {};
var myCoursesList;
var removeMode = false;
/* Fetch user course list from server
    @param ajax_URL the URI location where the ajax folder is located */

function getUserCourses( ajax_URL )
{
    $.ajax
    ({
        url: ajax_URL + 'courses/user-courses.php',
        data:
        {
            method: "get-courses"
        },
        dataType: "json",
        success: function ( json )
        {
            for( var i = 0; i < json.length; ++i )
            {
                myCoursesServerResponse[json[i].id] = { 'title':json[i].title, 'visible':json[i].visible };

                var newLI = document.createElement('li');
                newLI.setAttribute( 'data-icon', (json[i].visible?'eye':'false') );
                newLI.innerHTML = '<a href="#" id="my-course-'+json[i].id+'">' + json[i].id + '<br>' + json[i].title + '</a>';
                myCoursesList.appendChild(newLI);
                $('#my-course-'+json[i].id).on( 'click tap', function(e)
                {
                    alert('clicked shit');
                    if( removeMode )
                    {
                        removeUserCourse( ajaxURL, e.target.id.substring('my-course-'.length), 'my' );
                    }
                    else
                    {
                        
                    }
                } );
            }
            $('#my-courses-list').listview('refresh');
        }
    });
}

var allCoursesServerResponse = {};
/* Fetch master course list from the server
    @param ajax_URL the URI location where the ajax folder is located */
function getCourseList( ajax_URL )
{
    $.ajax
    ({
        url: ajax_URL + 'courses/courses.php',
        data:
        {
            method: "get-courses"
        },
        dataType: "json",
        success: function (json)
        {
            for (var i = 0; i < json.length; i++)
            {
                allCoursesServerResponse[json[i].id] = { 'title':json[i].title, 'inCourse':json[i].inCourse };

                //calls a separate function to add this data to the HTML
                masterCourseListAdd(ajax_URL, json[i].id, json[i].title, json[i].inCourse);
            }
            $( '#all-courses-list' ).listview( 'refresh' );
        }
    });
}

var clearing = false;
var loading = {};
/* Adds course data to list elements in HTML 
    @param id the 4-letter and 4-number course code
    @param title a brief description / the name of the course
    @param inCourse boolean, true if the user in the course*/
function masterCourseListAdd ( ajax_URL, id, title, inCourse )
{
    loading[id] = false;
    var newLI = document.createElement('li');
    newLI.innerHTML = '<a href="#" id="all-course-' + id + '" class="ui-btn" style="vertical-align: middle;">' + id + '<br>' + 
                      title + '</a>';
    allCoursesList.appendChild(newLI);
    if( inCourse )
    {
        newLI.setAttribute( 'data-icon', 'check');
        $('#all-course-' + id).addClass('ui-icon-check ui-btn-icon-right');
    }
    else
    {
        newLI.setAttribute( 'data-icon', 'false');
        $('#all-course-' + id).removeClass('ui-icon-check ui-btn-icon-right');
    }
    
    // Add Event Handler to added List Item
    $('#all-course-' + id).on('click tap', function (e)
    {
        if( allCoursesServerResponse[id].inCourse )
        {
            removeUserCourse(ajaxURL, id, 'all');
        }
        else
        {
            addUserCourse(ajaxURL, id, 'all');
        }
    });
}

/* Add a course to the master course list
    @param ajax_URL the URI location where the ajax folder is located
    @param courseID the 4-letter and 4-number course code
    @param description a brief description / the name of the course */
function createCourse( ajax_URL, courseID, description )
{
    $.ajax
        ({
            url: ajax_URL + 'courses/courses.php',
            data:
            {
                method: "add-course",
                id: courseID,
                title: description
            },
            dataType: "json",
            success: function (json) {
                if(json.success == true){
                    document.getElementById("user-course-form").reset();
					allCoursesServerResponse[courseID] = { 'title':description, 'inCourse':true };
					addToUserCourses( courseID, description );
                    $.mobile.changePage("#page-all-courses");
                }
            }
        });
}

/* adds a course to the user list in the database
    @param ajax_URL the URI location where the ajax folder is located
    @param courseID the 4-letter and 4-number course code 
    @param mode valid entries are 'my' or 'master
        my: specifies removal from an individual user course list
        all: specifies removal from the master course list*/
function addUserCourse( ajax_URL, courseID, mode )
{
    var target = document.getElementById(mode + '-course-' + courseID);
    if( loading[courseID] || clearing )
    {
        return;
    }
    else
    {
        loading[courseID] = true;
    }
    
    var parentLI = target.parentNode;

    //hide check
    parentLI.setAttribute('data-icon', 'false')
    $('#' + target.id).removeClass('ui-icon-check ui-icon-eye ui-icon-delete ui-btn-icon-right');

    //show loading image
    target.innerHTML = target.innerHTML + '<img class="course-loading" src="css/images/ajax-loader.gif" alt="loading...">';

    $.ajax
    ({
        url: ajax_URL + 'courses/user-courses.php',
        data:
        {
            method: "add-course",
            id: courseID
        },
        dataType: "json",
        success: function ( json )
        {
			/* helper function, adds the course to the HTML */
			addToUserCourses (courseID);
            
            //remove loading image
            target.removeChild(target.getElementsByTagName("img")[0]);
            //make sure there are no images in the list so it can be refreshed
            var refresh = true;
            for( var key in loading )
            {
                if( loading[key] )
                {
                    refresh = false;
                    break;
                }
            }
            //refresh if safe
            if( refresh )
                $('#all-courses-list').listview('refresh');

            loading[courseID] = false;
        }
    });

}

/* Adds course data to list elements in HTML 
    @param id the 4-letter and 4-number course code
    @param title a brief description / the name of the course*/
function addToUserCourses ( id, title )
{
    $('#all-course-' + id).addClass('ui-icon-check ui-btn-icon-right');
    $('#all-course-' + id).parent().attr('data-icon', 'check');
    
    myCoursesServerResponse[id] = { 'title':allCoursesServerResponse[id].title, 'visible':true };

    var newLI = document.createElement('li');
    newLI.setAttribute( 'data-icon', (myCoursesServerResponse[id].visible?'eye':'false') );
    newLI.innerHTML = '<a href="#" id="my-course-'+id+'">' + id + '<br>' + myCoursesServerResponse[id].title + '</a>';
    myCoursesList.appendChild(newLI);

    $('#my-courses-list').listview('refresh');
}

/* removes a course from the user list in the database
    @param ajax_URL the URI location where the ajax folder is located
    @param courseID the 4-letter and 4-number course code 
    @param mode valid entries are 'my' or 'master
        my: specifies removal from an individual user course list
        all: specifies removal from the master course list*/
function removeUserCourse ( ajax_URL, courseID, mode )
{
    var target = document.getElementById(mode + '-course-' + courseID);
    
    if( loading[courseID] || clearing )
    {
        return;
    }
    else
    {
        loading[courseID] = true;
    }
    
    var parentLI = target.parentNode;

    //hide check
    parentLI.setAttribute('data-icon', 'false')
    $('#' + target.id).removeClass('ui-icon-check ui-icon-eye ui-icon-delete ui-btn-icon-right');
    //show loading image
    target.innerHTML = target.innerHTML + '<img class="course-loading" src="css/images/ajax-loader.gif" alt="loading...">';

    $.ajax
    ({
        url: ajax_URL + 'courses/user-courses.php',
        data:
        {
            method: "remove-course",
            id: courseID
        },
        datatype: "json",
        success: function ( json )
        {			
			/* helper function called to remove HTML elements referencing this course */
			removeFromUserCourses ( courseID );
            //remove loading image
            target.removeChild(target.getElementsByTagName("img")[0]);
            //make sure there are no images in the list so it can be refreshed
            var refresh = true;
            for( var key in loading )
            {
                if( loading[key] )
                {
                    refresh = false;
                    break;
                }
            }
            //refresh if safe
            if( refresh )
                $('#all-courses-list').listview('refresh');

            loading[courseID] = false;
        }
    });
}

/* helper function. Removes list elements in HTML
	@param courseID the 4-letter and 4-number course code */
function removeFromUserCourses ( id )
{
    $('#all-course-' + id).removeClass('ui-icon-check ui-btn-icon-right');
    $('#all-course-' + id).parent().attr('data-icon', 'false');
    
    delete myCoursesServerResponse[id];

    var element = document.getElementById( 'my-course-' + id );
    element.parentNode.parentNode.removeChild( element.parentNode );
  
    $('#my-courses-list').listview('refresh');
}

/* toggle course watch visibility 
    @param ajax_URL the URI location where the ajax folder is located
    @param courseID the 4-letter and 4-number course code */
function toggleVisibility ( ajax_URL, courseID )
{
    $.ajax
    ({
        url: ajax_URL + 'courses/user-courses.php',
        data:
        {
            method: "toggle-visibility",
            id: courseID
        },
        datatype: "json",
        success: function ( json )
        {
            //PLACEHOLDER, backklog for next sprint
        }
    });
}