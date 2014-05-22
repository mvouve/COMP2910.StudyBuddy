
//temporary user course list
var myCoursesServerResponse = {};
//indicates if course's visibality is being toggled
var beingToggled = {};
//html unorded list where the user courses are displayed
var myCoursesList;
//indicates weather the user is in remove mode.
//if not in remove mode, toggle visability mode is assumed
var removeMode = false;
/* Fetch user course list from server
    @param ajax_URL the URI location where the ajax folder is located */

function getUserCourses( ajax_URL )
{
    $.ajax
    ({
        url: ajax_URL + 'courses/user-courses.php',
        type: 'POST',
        data:
        {
            method: "get-courses"
        },
        dataType: "json",
        success: function ( json )
        {
            for( var i = 0; i < json.length; ++i )
            {
                //add to temporary user course list
                myCoursesServerResponse[json[i].id] = { 'title':json[i].title,
                                                        'visible':json[i].visible };
                //create an entry in the beingToggled list
				beingToggled[json[i].id] = false;
				
                //create the list item and add it to myCoursesList manually
                var newLI = document.createElement('li');
                newLI.setAttribute( 'class', 'ui-li-has-alt' );
                newLI.innerHTML = '<a href="#"><h3>' + json[i].id + '</h3><p>' + json[i].title + '</p></a>'
                                + '<a href="#" id="my-course-'+json[i].id+'" class="the-button ui-btn"></a>';
                myCoursesList.appendChild(newLI);
				
                $( '#my-course-'+json[i].id ).addClass( json[i].visible?'ui-icon-eye':'ui-icon-no-eye' );

				// If visible, bind to channel
				if ( json[i].visible )
				{
					bindToCourse( json[i].id );
				}

                /* When an item is clicked, either
                    -remove course from user course list, if in remove mode OR
                    -toggle course's visability otherwise
                */
                $('#my-course-'+json[i].id).on( 'click touchend', function(e)
                {
                    if( removeMode )
                    {
						/* CLICK TO REMOVE */
                        removeUserCourse( ajaxURL, e.target.id.substring('my-course-'.length),
                            'my' );
                    }
                    else
                    {
                        /* CLICK TO TOGGLE VISIBILITY */
						toggleVisibility ( ajaxURL, e.target.id.substring('my-course-'.length) );
                    }
                } );
            }

            $('#my-courses-list').listview('refresh');
        }
    });
}

//temporary all courses list
var allCoursesServerResponse = {};

/* Fetch master course list from the server
    @param ajax_URL the URI location where the ajax folder is located */
function getCourseList( ajax_URL )
{
    $.ajax
    ({
        url: ajax_URL + 'courses/courses.php',
        type: 'POST',
        data:
        {
            method: "get-courses"
        },
        dataType: "json",
        success: function (json)
        {
            for (var i = 0; i < json.length; i++)
            {
                //add to temporary all courses list
                allCoursesServerResponse[json[i].id] = { 'title':json[i].title,
                                                         'inCourse':json[i].inCourse };

                //calls a separate function to add this data to the HTML
                masterCourseListAdd(ajax_URL, json[i].id, json[i].title, json[i].inCourse);
            }
            $( '#all-courses-list' ).listview( 'refresh' );
        }
    });
}

//indicates weather there is a clearing of all courses in progress
var clearing = false;
//indicates weather there is a pending operation on a course
var loading = {};
//html unorded list where all courses are displayed
var allCoursesList;
/* Adds course data to list elements in HTML 
    @param id the 4-letter and 4-number course code
    @param title a brief description / the name of the course
    @param inCourse boolean, true if the user in the course*/
function masterCourseListAdd ( ajax_URL, id, title, inCourse )
{
    //create an entry in loading list
    loading[id] = false;
    
    //create the list item and add it to allCoursesList
    var newLI = document.createElement('li');
    newLI.setAttribute( 'class', 'ui-li-has-alt' );
    newLI.innerHTML = '<a href="#"><h3>' + id + '</h3><p>' + title + '</p></a>'
                      + '<a href="#" id="all-course-'+id+'" class="ui-btn"></a>';
    allCoursesList.appendChild(newLI);
    //add the check mark if user is in the course
    if( inCourse )
    {
        $('#all-course-' + id).removeClass('ui-icon-plus');
        $('#all-course-' + id).addClass('ui-icon-check');
    }
    else
    {
        $('#all-course-' + id).removeClass('ui-icon-check');
        $('#all-course-' + id).addClass('ui-icon-plus');
    }
    
    // Add Event Handler to added List Item
    $('#all-course-' + id).on('click touchend', function (e)
    {
        if( allCoursesServerResponse[id].inCourse )
        {
            //remove course from user course list if in Course
            removeUserCourse(ajaxURL, id, 'all');
        }
        else
        {
            //add it to user course list otherwise
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
        type: "POST",
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

    //cancel opertaion if another relevant operation is underway
    if( loading[courseID] || clearing )
    {
        return;
    }
    
    loading[courseID] = true;

    //hide check
    $('#' + target.id).removeClass('ui-icon-check ui-icon-plus ui-icon-eye ui-icon-delete ui-btn-icon-right');

    //show loading image
    target.innerHTML = target.innerHTML +
        '<img class="course-loading" src="css/images/ajax-loader.gif" alt="loading...">';

    $.ajax
    ({
        url: ajax_URL + 'courses/user-courses.php',
        type: 'POST',
        data:
        {
            method: "add-course",
            id: courseID
        },
        dataType: "json",
        success: function ( json )
        {
            allCoursesServerResponse[courseID].inCourse = true;
			/* helper function, adds the course to the HTML */
			addToUserCourses (courseID, allCoursesServerResponse[courseID].title);
            
            //remove loading image
            target.removeChild(target.getElementsByTagName("img")[0]);
            
            loading[courseID] = false;

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
        }
    });
}

/* Adds course data to list elements in HTML 
    @param id the 4-letter and 4-number course code
    @param title a brief description / the name of the course*/
function addToUserCourses ( id, title )
{
    //show check mark in all courses list
    $('#all-course-' + id).addClass('ui-icon-check');
    
    //add to temporary user course list
    myCoursesServerResponse[id] = { 'title':allCoursesServerResponse[id].title,
                                    'visible':true };
    
    //create an entry in the beingToggled list
	beingToggled[id] = false;
	
	// If visible, bind to course channel
	if ( myCoursesServerResponse[id].visible )
	{
		bindToCourse( id );
	}
    
    //create the list item and add it to myCoursesList manually
    var newLI = document.createElement('li');
    newLI.setAttribute( 'class', 'ui-li-has-alt' );
    newLI.innerHTML = '<a href="#"><h3>' + id + '</h3><p>' + title + '</p></a>'
                    + '<a href="#" id="my-course-'+id+'" class="the-button ui-btn"></a>';
    myCoursesList.appendChild(newLI);
				
    $( '#my-course-'+id ).addClass( myCoursesServerResponse[id].visible?'ui-icon-eye':'ui-icon-no-eye' );

    /* When an item is clicked, either
        -remove course from user course list, if in remove mode OR
        -toggle course's visability otherwise
    */
    $('#my-course-'+id).on( 'click touchend', function(e)
    {
        if( removeMode )
        {
		    /* CLICK TO REMOVE */
            removeUserCourse( ajaxURL, e.target.id.substring('my-course-'.length), 'my' );
        }
        else
        {
            /*CLICK TO TOGGLE VISIBILITY */
			toggleVisibility ( ajaxURL, e.target.id.substring('my-course-'.length) );
        }
    } );
	
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
    
    //cancel opertaion if another relevant operation is underway
    if( loading[courseID] || clearing )
    {
        return;
    }
    
    loading[courseID] = true;

    //hide check
    target.parentNode.setAttribute('data-icon', 'false');
    $('#' + target.id).removeClass('ui-icon-check ui-icon-eye ui-icon-delete ui-btn-icon-right');

    //show loading image
    target.innerHTML = target.innerHTML +
        '<img class="course-loading" src="css/images/ajax-loader.gif" alt="loading...">';

    $.ajax
    ({
        url: ajax_URL + 'courses/user-courses.php',
        type: 'POST',
        data:
        {
            method: "remove-course",
            id: courseID
        },
        datatype: "json",
        success: function ( json )
        {			
            allCoursesServerResponse[courseID].inCourse = false;
			/* helper function called to remove HTML elements referencing this course */
			removeFromUserCourses ( courseID );
            //remove loading image
            target.removeChild(target.getElementsByTagName("img")[0]);

            loading[courseID] = false;

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

        }
    });
}

/* helper function. Removes list elements in HTML
	@param courseID the 4-letter and 4-number course code */
function removeFromUserCourses ( id )
{
    //remove check
    $('#all-course-' + id).removeClass('ui-icon-check');
    $('#all-course-' + id).addClass('ui-icon-plus');

    //remove the list item of the course from the unordered list
    var element = document.getElementById( 'my-course-' + id );
    element.parentNode.parentNode.removeChild( element.parentNode );
	
	// Remove course channel binding if it's set
	if ( myCoursesServerResponse[id].visible )
	{
		unbindFromCourse( id );
	}
	
    //delete entry from temporary all courses list
    delete myCoursesServerResponse[id];
  
    $('#my-courses-list').listview('refresh');
}

/* toggle course watch visibility 
    @param ajax_URL the URI location where the ajax folder is located
    @param courseID the 4-letter and 4-number course code */
function toggleVisibility ( ajax_URL, courseID )
{
    //cancel opertaion if course is already being toggled at the moment
	if ( beingToggled[ courseID ] )
	{
		return;
	}
	
	beingToggled[ courseID ] = true;

	// Hide Icon
	$( '#my-course-' + courseID ).removeClass('ui-icon-eye ui-icon-no-eye');
	$( '#my-course-' + courseID ).html($( '#my-course-' + courseID ).html() + 
        '<img class="course-loading" src="css/images/ajax-loader.gif" alt="loading...">');
    
    // Toggle visibility on server
    $.ajax
    ({
        url: ajax_URL + 'courses/user-courses.php',
        type: 'POST',
        data:
        {
            method: "toggle-visibility",
            id: courseID
        },
        datatype: "json",
        success: function ( json )
        {
            //teggle visible for the entry in temporary user courses list
            myCoursesServerResponse[courseID].visible = !myCoursesServerResponse[courseID].visible;
			
			// Remove Loading Image
			$( '#my-course-' + courseID + ' img' ).remove();
			
			// If the course is now watched, show the eye icon.
			if ( myCoursesServerResponse[courseID].visible )
			{
				// Remove course channel binding if it's set
				bindToCourse( courseID );
					
				// Set Icon to eye
				$( '#my-course-' + courseID ).removeClass('ui-icon-no-eye');
				$( '#my-course-' + courseID ).addClass('ui-icon-eye');
			}
			else
			{
				// Remove course channel binding if it's set
				unbindFromCourse( courseID );

                // Set Icon to no-eye
				$( '#my-course-' + courseID ).removeClass('ui-icon-eye');
				$( '#my-course-' + courseID ).addClass('ui-icon-no-eye');
			}
            
			beingToggled[ courseID ] = false;
            
            //make sure there are no images in the list so it can be refreshed
			var refresh = true;
            for( var key in beingToggled )
            {
                if( beingToggled[key] )
                {
                    refresh = false;
                    break;
                }
            }
            //refresh if safe
            if( refresh )
			    $('#my-courses-list').listview('refresh');
        }
    });
}
