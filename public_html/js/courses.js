/* Fetch user course list from server by ajax */

function getCourses(ajax_URL)
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

/* Add a course to the master course list */

function createCourse(ajax_URL, courseID)
{
    $.ajax
    ({
        url: ajax_URL + '/courses/courses.php',
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