/**
 * File For: HopeTracker.com
 * File Name: .
 * Author: Mike Giammattei
 * Created On: 6/15/2017, 3:54 PM
 */
sign_out();
function sign_out() {
    $('#sign-out').on('click',function () {
        $.ajax({
            cache : false,
            type: 'POST',
            url : RELATIVE_PATH + '/config/processing.php',
            data : {
                form : 'Sign Out'
            }
        }).done(function (response) {
            location.href=RELATIVE_PATH + "/home";
            //location.reload();
        });
    });
}