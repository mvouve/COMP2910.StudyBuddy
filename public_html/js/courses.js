/* Fetch user course list from server by ajax */

function getUserCourses(ajax_URL)
{
    $.ajax
    ({
        url: ajax_URL + '/courses/user-courses.php',
        data:
        {
            method: get-courses
        },
        dataType: json,
        success: function (json)
        {
            //PLACEHOLDER
        }
    });
}

/* Fetch master course list from the server*/
function getCourseList(ajax_URL)
{
    $.ajax
    ({
        url: ajax_URL + '/courses/courses.php',
        data:
        {
            method: get-courses,
        },
        dataType: json,
        success: function (json)
        {
            //PLACEHOLDER
        }
    })
}
/* Add a course to the master course list */

function createCourse(ajax_URL, courseID, description)
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
        success: function (json)
        {
            //PLACEHOLDER
        }
    });
}

/* removes a course from the user list */
function addCourse(ajax_URL, courseID)
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
        success: function (json)
        {
            //PLACEHOLDER
        }
    });

}

/* removes a course from the user list */
function removeCourse (ajax_URL, courseID)
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
        success: function (json)
        {
            //PLACEHOLDER
        }
    });
}

/* toggle course watch visibility */
function toggleVisibility (ajax_URL, courseID)
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
        success: function (json)
        {
            //PLACEHOLDER
        }
    });
}