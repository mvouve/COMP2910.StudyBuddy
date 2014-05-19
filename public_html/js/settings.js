/* im not exactly sure what this function is supposed to do since there are no user, meeting, or course parameters getting passed
    @param ajax_URL the URI location where the ajax folder is located
    @param attending BOOLEAN true if you are attending
    @param notAttending BOOLEAN true if you are not attending
*/
function setMeetingFilter ( ajax_URL, created, userAttending, userNotAttending )
{
    $.ajax
    ({
        url: ajax_URL + 'meetings/settings.php',
        data:
        {
            method: 'set-meeting-filter'
            attending: userAttending,
            not-attending: userNotAttending
        },
        dataType: "json"
        success: function ( json )
        {
            //put code here
        } 
    });
}

/* im not exactly sure what this function is supposed to do either
    @param ajax_URL the URI location where the ajax folder is located 
*/
function getMeetingFilter ( ajax_URL, created, userAttending, userNotAttending )
{
    $.ajax
    ({
        url: ajax_URL + 'meetings/settings.php',
        data:
        {
            method: 'get-meeting-filter'
        },
        dataType: "json",
        success: function ( json )
        {
            //put code here
        }
    });
}