<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
    </ul>
    <ul class="navbar-nav ml-auto">
        <!-- <li class="nav-item dropdown notification-menu">
            <a class="nav-link" id="notificationDropdown" data-toggle="dropdown" href="#">
                <i class="far fa-bell"></i>
                <?php if (count($notifications) > 0) : ?>
                    <span class='badge badge-warning navbar-badge'><?= count($notifications); ?></span>
                <?php else : ?>
                    <span class='badge badge-warning navbar-badge' style="display:none;"></span>
                <?php endif; ?>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right" aria-labelledby="notificationDropdown">
                <?php if (empty($notifications)) : ?>
                    <span class="dropdown-item dropdown-header">You don't have new notifications</span>
                <?php else : ?>
                    <span class="dropdown-item dropdown-header"><?= count($notifications); ?> Notifications</span>
                    <div class="dropdown-divider"></div>
                    <?php foreach ($notifications as $item) : ?>
                        <?php if ($item['is_read'] !== TRUE) : ?>
                            <a href="#" class="dropdown-item text-sm" onclick="markNotif(<?= $item['id_notification'] ?>, <?= $item['ticket_id'] ?>)">
                                <i class="fas fa-envelope mr-2"></i> <?= $item['notification']; ?>
                            </a>
                            <div class="dropdown-divider"></div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </li> -->
        <li class="nav-item dropdown user-menu">
            <a href="#" class="nav-link dropdown-toggle" id="userMenuDropdown" data-toggle="dropdown">
                <img src="<?php echo base_url('assets/back') ?><?= $this->session->avatar; ?>" class="user-image img-circle elevation-1" alt="User Image">
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right" aria-labelledby="userMenuDropdown">
                <a href="#" class="dropdown-item text-sm">
                    <div class="media align-items-center">
                        <div class="avatar-wrapper2">
                            <img src="<?php echo base_url('assets/back') ?><?= $this->session->avatar; ?>" alt="User Avatar" class="img-size-32 img-circle">
                        </div>
                        <div class="media-body ml-3">
                            <h4 class="dropdown-item-title text-sm mb-0">
                                <?= $this->session->fullname; ?>
                            </h4>
                            <p class="text-sm text-muted mb-0"><?= $this->session->email; ?></p>
                        </div>
                    </div>
                </a>
                <div class="dropdown-divider"></div>
                <a href="<?php echo base_url('dashboard/admin') ?>" class="dropdown-item text-sm">
                    Dashboard
                </a>
                <div class="dropdown-divider"></div>
                <a href="<?php echo base_url('user/account_admin') ?>" class="dropdown-item text-sm">
                    Account Settings
                </a>
                <div class="dropdown-divider"></div>
                <a href="<?php echo base_url('auth/logout') ?>" class="dropdown-item text-sm">
                    Logout
                </a>
            </div>
        </li>
    </ul>
</nav>
<script type="text/javascript">
    // var refreshId = setInterval(function() {
    //     $.ajax({
    //         url: "<?php echo base_url('helpdesk/notification/fetch_notifications'); ?>",
    //         type: 'GET',
    //         dataType: 'json',
    //         success: function(data) {
    //             var notificationList = '';
    //             var unreadCount = 0;

    //             if (data.notifications.length > 0) {
    //                 data.notifications.forEach(function(notification) {
    //                     if (notification.is_read !== true) {
    //                         unreadCount++;
    //                         notificationList += '<a href="#" class="dropdown-item text-sm" onclick="markNotif(' + notification.id_notification + ', ' + notification.ticket_id + ')">';
    //                         notificationList += '<i class="fas fa-envelope mr-2"></i> ' + notification.notification + '</a>';
    //                         notificationList += '<div class="dropdown-divider"></div>';
    //                     }
    //                 });
    //                 $('#notificationDropdown + .dropdown-menu').html(notificationList);
    //                 if (unreadCount > 0) {
    //                     $('#notificationDropdown .navbar-badge').text(unreadCount).show();
    //                 } else {
    //                     $('#notificationDropdown .navbar-badge').hide();
    //                 }
    //             } else {
    //                 $('#notificationDropdown .navbar-badge').hide();
    //                 $('#notificationDropdown + .dropdown-menu').html('<span class="dropdown-item dropdown-header">You don\'t have new notifications</span>');
    //             }
    //         },
    //         error: function(xhr, ajaxOptions, thrownError) {
    //             console.error("Error fetching notifications:", xhr.status, xhr.responseText, thrownError);
    //         }
    //     });
    // }, 5000);

    function markNotif(id, ticket_id) {
        var url = "<?php echo base_url('helpdesk/notification/mark_notification_as_read') ?>";
        console.log("Constructed URL:", url);
        console.log("Sending ID:", id);

        $.ajax({
            type: "post",
            url: url,
            data: {
                id: id,
                <?php echo $this->security->get_csrf_token_name(); ?>: '<?php echo $this->security->get_csrf_hash(); ?>'
            },
            dataType: "json",
            success: function(response) {
                console.log("Success response", response);
                if (response.error) {
                    toastr.error(response.error);
                }
                if (response.success) {
                    toastr.success(response.success);
                    setTimeout(function() {
                        window.location.href = "<?= base_url('helpdesk/ticket/detail_ticket_admin/') ?>" + ticket_id;
                    }, 1000);
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                console.log("Error response", xhr.status, xhr.responseText, thrownError);
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });
    }
</script>