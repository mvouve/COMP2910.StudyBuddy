/*
 * Validates user IDs by regex.
 *
 * @returns
 *		TRUE: 	ID is valid.
 * 		FALSE: 	ID is invalid.
 */
function validateCouseID( ID ) {
    courseIdFilled = false;
    $('#add-course-submit').addClass('ui-disabled');
    
    ID.match(CourseIdRegex);
    if (validID == null || validID.length != 1) {
        return false;
    }
    $('#invalid-format').hide();
    //$('#add-course-submit').removeClass('ui-disabled');
    courseIdFilled = true;
    checkFormFilled();
    return true;
}

/*
 * Validate the user title by regex.
 *
 * @returns
 *      TRUE:   Title is valid.
 *      FALSE:  ID is invalid.
 */
function validateCourseName() {
    courseTitleFilled = false;
    $('#add-course-submit').addClass('ui-disabled');
    
    var titleEntry = document.getElementById("user-course-title").value;
    if(titleEntry.length > 3){
        courseTitleFilled = true;
    }
    checkFormFilled();
    return true;
}