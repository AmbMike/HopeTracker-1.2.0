/*
 * Copyright (c) 2018.
 */

/** Reset Activity Session Status. Current session to 1 and not complete activities. */
function resetActivitySession(){
    'use strict';
    var confirmed = confirm('Are you sure you\'d like to delete all the logged in user\'s complete activities and reset the current session back to 1?');

    if(confirmed === true){
        $.get(RELATIVE_PATH +'/ajax-loads/debugs.php',{debug : 'resetCourseSession',cache : false}, function (response) {
            $('#toggleWidthErrorWindow .error-output').text(response);
        });
    }
}

function resetCourseIntro(){
    'use strict';
    var confirmed = confirm('Are you sure you\'d like to reset the course intro?');

    if(confirmed === true){
        $.get(RELATIVE_PATH +'/ajax-loads/debugs.php',{debug : 'resetCourseIntro',cache : false}, function (response) {
            $('#toggleWidthErrorWindow .error-output').text(response);
        });
    }
}