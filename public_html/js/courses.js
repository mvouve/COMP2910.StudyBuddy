/* Fetch user course list from server
    @param ajax_URL the URI location where the ajax folder is located */

function getUserCourses( ajax_URL )
{
    $.ajax
    ({
        url: ajax_URL + '/courses/user-courses.php',
        data:
        {
            method: get-courses
        },
        dataType: json,
        success: function ( json )
        {
            var courseArray = json;
            for ( i = 0 ; courseArray.length ; i++ )
            {
                var courseID = courseArray[i].id;
                var courseTitle = courseArray[i].title; 

                //calls a separate function to add this data to the HTML
                addToUserCourses(courseID, courseTitle);
            }
        }
    });
}


/* Adds course data to list elements in HTML 
    @param id the 4-letter and 4-number course code
    @param title a brief description / the name of the course*/
function addToUserCourses (id, title)
{
    var list = getElementById('my-courses-list');
    var listItem = document.createElmeent('li');

    //create inner anchor element in list item and set its attribute and data
    var anchor = document.createElement('a');
    anchor.setAttribute('href', '#');
    anchor.innerHTML='' + id + '<br/>' + title;

    //put the anchor element inside the list item element
    listItem.innerHTML = anchor;
}

/* Fetch master course list from the server
    @param ajax_URL the URI location where the ajax folder is located */
function getCourseList( ajax_URL )
{
    $.ajax
    ({
        url: ajax_URL + '/courses/courses.php',
        data:
        {
            method: get - courses
        },
        dataType: json,
        success: function (json) {
            var courseArray = json;
            for (i = 0; courseArray.length; i++) {
                var courseID = courseArray[i].id;
                var courseTitle = courseArray[i].title;
                var userInCourse = courseArray[i].inCourse;

                //calls a separate function to add this data to the HTML
                masterCourseListAdd(courseID, courseTitle, userInCourse);
            }
        }
    });
}

/* Adds course data to list elements in HTML 
    @param id the 4-letter and 4-number course code
    @param title a brief description / the name of the course
    @param inCourse boolean, true if the user in the course*/
function masterCourseListAdd (id, title, inCourse)
{
    var list = getElementById(/*PLACEHOLDER_FOR_LIST_ID*/);         //*****REPLACE PLACEHOLDER ID IN THIS LINE
    var listItem = document.createElmeent('li');

    //create inner anchor element in list item and set its attribute and data
    var anchor = document.createElement('a');
    anchor.setAttribute('href', '#');
    anchor.innerHTML='' + id + '<br/>' + title;

    //put the anchor element inside the list item element
    listItem.innerHTML = anchor;

    //MUST STILL DEAL WITH IN_COURSE BOOLEAN; BUTTON IS NOT IMPLEMENTED AS OF WRITING
}

/* Add a course to the master course list
    @param ajax_URL the URI location where the ajax folder is located
    @param courseID the 4-letter and 4-number course code
    @param description a brief description / the name of the course */
function createCourse( ajax_URL, courseID, description )
{
        $.ajax
        ({
            url: ajax_URL + '/courses/courses.php',
            data:
            {
                method: add-course,
                id: courseID,
                title: description
        },
        dataType: json,
        success: function ( json )
        {
            //PLACEHOLDER
        }
    });
}

/* adds a course to the user list in the 
    @param ajax_URL the URI location where the ajax folder is located
    @param courseID the 4-letter and 4-number course code */
function addUserCourse( ajax_URL, courseID )
{
    $.ajax
    ({
        url: ajax_URL + '/courses/user-courses.php',
        data:
        {
            method: add-course,
            id: courseID
        },
        dataType: json,
        success: function ( json )
        {
            //PLACEHOLDER
        }
    });

}

/* removes a course from the user list 
    @param ajax_URL the URI location where the ajax folder is located
    @param courseID the 4-letter and 4-number course code */
function removeUserCourse ( ajax_URL, courseID )
{
    $.ajax
    ({
        url: ajax_URL + '/courses/user-courses.php',
        data:
        {
            method: remove-course,
            id: courseID
        },
        datatype: json,
        success: function ( json )
        {
            //PLACEHOLDER
        }
    });
}

/* toggle course watch visibility 
    @param ajax_URL the URI location where the ajax folder is located
    @param courseID the 4-letter and 4-number course code */
function toggleVisibility ( ajax_URL, courseID )
{
    $.ajax
    ({
        url: ajax_URL + '/courses/user-courses.php',
        data:
        {
            method: toggle-visibility,
            id: courseID
        },
        datatype: json,
        success: function ( json )
        {
            //PLACEHOLDER
        }
    });
}