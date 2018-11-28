<?php
/**
 * File For: HopeTracker.com
 * File Name: footer.php.
 * Author: Mike Giammattei
 * Created On: 5/16/2017, 5:05 PM
 */;
?> <?php if(isset($_SESSION['Admin Logged'])): ?><footer class="main-footer"><div class="pull-right hidden-xs"> HopeTracker</div> <strong>Copyright &copy; <?php echo date('Y'); ?> <a href="/">Ambrosia Treatment Centers</a>.</strong> All rights reserved.</footer><aside class="control-sidebar control-sidebar-dark"><ul class="nav nav-tabs nav-justified control-sidebar-tabs"><li class="active"><a href="#control-sidebar-home-tab" data-toggle="tab"><i class="fa fa-home"></i></a></li><li><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-gears"></i></a></li></ul><div class="tab-content"><div class="tab-pane active" id="control-sidebar-home-tab"><h3 class="control-sidebar-heading">Recent Activity</h3><ul class="control-sidebar-menu"><li><a href="javascript:;"><i class="menu-icon fa fa-birthday-cake bg-red"></i><div class="menu-info"><h4 class="control-sidebar-subheading">Langdon's Birthday</h4><p>Will be 23 on April 24th</p></div></a></li></ul><h3 class="control-sidebar-heading">Tasks Progress</h3><ul class="control-sidebar-menu"><li><a href="javascript:;"><h4 class="control-sidebar-subheading"> Custom Template Design <span class="pull-right-container"><span class="label label-danger pull-right">70%</span></span></h4><div class="progress progress-xxs"><div class="progress-bar progress-bar-danger" style="width: 70%"></div></div></a></li></ul></div><div class="tab-pane" id="control-sidebar-stats-tab">Stats Tab Content</div><div class="tab-pane" id="control-sidebar-settings-tab"><form method="post"><h3 class="control-sidebar-heading">General Settings</h3><div class="form-group"> <label class="control-sidebar-subheading">Report panel usage <input type="checkbox" class="pull-right" checked></label><p> Some information about this general settings option</p></div></form></div></div></aside><div class="control-sidebar-bg"></div></div> <?php endif;  ?><script src="/<?php echo RELATIVE_PATH ?>HopeAdmin/plugins/jQuery/jquery-2.2.3.min.js"></script><script src="/<?php echo RELATIVE_PATH ?>HopeAdmin/bootstrap/js/bootstrap.min.js"></script><script src="/<?php echo RELATIVE_PATH ?>HopeAdmin/plugins/iCheck/icheck.min.js"></script><script src="/<?php echo RELATIVE_PATH ?>HopeAdmin/dist/js/app.min.js"></script><script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script><script>
    $.widget.bridge('uibutton', $.ui.button);
</script><script src="/<?php echo RELATIVE_PATH ?>HopeAdmin/site/public/js/bootstrapValidator.js"></script><script src="/<?php echo RELATIVE_PATH ?>HopeAdmin/plugins/select2/select2.js"></script><script src="/<?php echo RELATIVE_PATH ?>HopeAdmin/site/public/js/main.js"></script><script>
    $(function () {
        $('input').iCheck({
            checkboxClass: 'icheckbox_square-blue',
            radioClass: 'iradio_square-blue',
            increaseArea: '20%' // optional
        });

        if($('.flagged-action-btn').length > 0){
            deleteFlaggedPost()
        }

    });

    function deleteFlaggedPost() {
        $('.flagged-action-btn').on('click', function () {

            var r =  confirm("Are you sure you want to delete this post?");
            if (r === true) {

                let $this = $(this);
                let postType = $this.data('delete-flag-post-type');
                let postId = $this.data('delete-flag-post-id');
                let flagId = $this.data('delete-flag-id');
                if (r === true) {
                    var ajaxData = {
                        form : "Delete Flagged Post",
                        cache : false,
                        postType : postType,
                        postId : postId,
                        flagId : flagId

                    };
                    $('#flagged-action-success').html(" ");
                    $.post("/" + '<?php echo RELATIVE_PATH ?>config/processing.php',ajaxData,function (response) {
                       if(response.status === "Success"){
                           var htmlSuccess;

                           $this.closest('tr').remove();
                            htmlSuccess = '<div class="alert alert-success alert-dismissible ">\n' +
                               '                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>\n' +
                               '                        <h4><i class="icon fa fa-check"></i> Success!</h4>\n' +
                               '                        You\'ve just delete the flagged post.\n' +
                               '                    </div>';
                           $('#flagged-action-success').html(htmlSuccess);
                           $('#flagged-action-success').slideDown(500);
                       }else{
                            htmlSuccess = '<div class="alert alert-danger alert-dismissible ">\n' +
                               '                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>\n' +
                               '                        <h4><i class="icon fa fa-check"></i> Failed!</h4>\n' +
                               '                        The post did not delete successfully. Please try again.\n' +
                               '                    </div>';
                           $('#flagged-action-success').html(htmlSuccess);
                           $('#flagged-action-success').slideDown(500);
                       }
                    },'json');
                }

            }
        });
    }

</script></body></html>