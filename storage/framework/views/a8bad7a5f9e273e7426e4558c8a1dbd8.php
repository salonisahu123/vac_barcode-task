<style>
<style>

/* =========================================================
   TOP BAR
========================================================= */

.topbar {
    width: 100%;
}

.topbar .navbar {
    width: 100%;
    margin: 0;
    padding: 0;
}

.topbar .full {
    width: 100%;
}


/* =========================================================
   RIGHT SIDE OF TOPBAR
   Bell + Profile ko ek line me rakhega
========================================================= */

.right_topbar {
    display: flex !important;
    align-items: center !important;
    justify-content: flex-end !important;

    height: 100%;
    min-height: 64px;

    padding: 0 !important;
    margin: 0 !important;
}


/* =========================================================
   NOTIFICATION BOX
========================================================= */

.notification_box {
    position: relative;

    display: flex !important;
    align-items: center !important;
    justify-content: center !important;

    height: 100%;
    min-height: 64px;

    margin: 0 18px 0 0 !important;
    padding: 0 !important;

    flex-shrink: 0;
}


/* =========================================================
   BELL BUTTON
========================================================= */

.notification_icon {
    position: relative;

    display: flex !important;
    align-items: center !important;
    justify-content: center !important;

    width: 42px;
    height: 42px;

    margin: 0 !important;
    padding: 0 !important;

    color: #ffffff !important;
    background: transparent !important;

    font-size: 23px;
    line-height: 1;

    text-decoration: none !important;
    cursor: pointer;

    border: none;
    outline: none;
}


/* Bell hover */

.notification_icon:hover,
.notification_icon:focus,
.notification_icon:active {
    color: #ffffff !important;
    background: transparent !important;
    text-decoration: none !important;
    outline: none !important;
}


/* Actual bell icon */

.notification_icon i {
    display: block;

    margin: 0 !important;
    padding: 0 !important;

    font-size: 23px;
    line-height: 1;

    color: #ffffff !important;
}


/* =========================================================
   NOTIFICATION COUNT
========================================================= */

.notification_count {
    position: absolute;

    top: 1px;
    right: 0px;

    display: flex;
    align-items: center;
    justify-content: center;

    min-width: 18px;
    height: 18px;

    padding: 0 4px;

    border-radius: 50%;

    background: #dc3545;
    color: #ffffff;

    font-size: 10px;
    font-weight: 600;
    line-height: 18px;

    text-align: center;

    box-sizing: border-box;

    z-index: 10;
}


/* =========================================================
   NOTIFICATION DROPDOWN
========================================================= */

.notification_dropdown {
    position: absolute;

    top: calc(100% - 5px);
    right: -10px;

    width: 360px;
    max-width: 90vw;
    max-height: 500px;

    background: #ffffff;

    border-radius: 8px;

    box-shadow:
        0 5px 20px rgba(0, 0, 0, 0.20);

    border: 1px solid #eeeeee;

    z-index: 99999;

    display: none;

    overflow: hidden;
}


/* Dropdown header */

.notification_dropdown_header {
    padding: 16px 15px;
    border-bottom: 1px solid #f1f1f1;
    background: #ffffff;
    color: #2b2b2b;
    font-size: 16px;
    font-weight: 700;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

/* Notification list */

#notificationList {
    max-height: 440px;

    overflow-y: auto;
    overflow-x: hidden;
}


/* Scrollbar */

#notificationList::-webkit-scrollbar {
    width: 6px;
}

#notificationList::-webkit-scrollbar-track {
    background: #f5f5f5;
}

#notificationList::-webkit-scrollbar-thumb {
    background: #cccccc;
    border-radius: 10px;
}


/* =========================================================
   LOADING
========================================================= */

.notification_loading {
    padding: 20px;

    text-align: center;

    color: #777777;

    font-size: 14px;
}


/* =========================================================
   NOTIFICATION ITEM
========================================================= */

.notification_item {
    display: flex;
    align-items: flex-start;
    padding: 15px;
    border-bottom: 1px solid #f1f1f1;
    cursor: pointer;
    background: #ffffff;
    transition: all 0.2s ease;
}

/* Hover */

.notification_item:hover {
    background: #f9f9fb;
}

/* Unread notification */

.notification_item.unread {
    background: #f4f8ff;
    border-left: 4px solid #0d6efd;
}

/* Unread hover */

.notification_item.unread:hover {
    background: #e9f2ff;
}

.notification_item_icon {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    background: #eef2f7;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #0d6efd;
    font-size: 14px;
    margin-right: 12px;
    flex-shrink: 0;
}

.notification_item_content {
    flex-grow: 1;
}

/* Message */

.notification_item_message {
    font-size: 13.5px;
    font-weight: 500;
    color: #333;
    margin-bottom: 5px;
    line-height: 1.4;
}

/* Time */

.notification_item_time {
    font-size: 11px;
    color: #999;
    font-weight: 400;
    display: flex;
    align-items: center;
    gap: 4px;
}


/* =========================================================
   SECTION TITLE
========================================================= */

.notification_section_title {
    padding: 10px 15px;
    background: #fafbfe;
    color: #6c757d;
    font-size: 11px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    border-bottom: 1px solid #f1f1f1;
}


/* =========================================================
   PROFILE SECTION
========================================================= */

.icon_info {
    display: flex !important;

    align-items: center !important;

    height: 100%;

    margin: 0 !important;
    padding: 0 !important;

    flex-shrink: 0;
}


/* Profile UL */

.icon_info .user_profile_dd {
    display: flex !important;

    align-items: center !important;

    height: 100%;

    margin: 0 !important;
    padding: 0 !important;

    list-style: none;
}


/* Profile LI */

.icon_info .user_profile_dd > li {
    display: flex !important;

    align-items: center !important;

    height: 100%;

    margin: 0 !important;
    padding: 0 !important;

    list-style: none;
}


/* =========================================================
   PROFILE BUTTON
========================================================= */

.icon_info .user_profile_dd .dropdown-toggle {
    display: flex !important;

    align-items: center !important;

    height: 64px;

    margin: 0 !important;

    padding: 0 18px !important;

    cursor: pointer;

    text-decoration: none !important;
}


/* Profile Image */

.icon_info .user_profile_dd .dropdown-toggle img {
    width: 40px !important;
    height: 40px !important;

    object-fit: cover;

    margin-right: 10px;
}


/* User Name */

.icon_info .user_profile_dd .name_user {
    white-space: nowrap;

    font-size: 14px;

    color: #ffffff;
}


/* =========================================================
   PROFILE DROPDOWN
========================================================= */

.icon_info .user_profile_dd .dropdown-menu {
    z-index: 99999;
}


/* =========================================================
   RESPONSIVE
========================================================= */

@media (max-width: 768px) {

    .right_topbar {
        min-height: 60px;
    }

    .notification_box {
        min-height: 60px;

        margin-right: 10px !important;
    }

    .notification_icon {
        width: 38px;
        height: 38px;

        font-size: 21px;
    }

    .notification_icon i {
        font-size: 21px;
    }

    .icon_info .user_profile_dd .dropdown-toggle {
        height: 60px;

        padding: 0 10px !important;
    }

    .icon_info .user_profile_dd .name_user {
        font-size: 12px;
    }

    .notification_dropdown {
        right: -10px;

        width: 320px;
        max-width: 90vw;
    }
}


/* =========================================================
   VERY SMALL SCREEN
========================================================= */

@media (max-width: 480px) {

    .notification_box {
        margin-right: 5px !important;
    }

    .icon_info .user_profile_dd .name_user {
        display: none;
    }

    .icon_info .user_profile_dd .dropdown-toggle {
        padding: 0 8px !important;
    }

    .notification_dropdown {
        position: fixed;

        top: 65px;
        right: 10px;
        left: 10px;

        width: auto;
        max-width: none;
    }
}

</style>
</style>

<div class="topbar">
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="full">

            <button type="button" id="sidebarCollapse" class="sidebar_toggle">
                <i class="fa fa-bars"></i>
            </button>

            <div class="right_topbar">
               <div class="notification_box">

                    <a href="javascript:void(0);"
                    class="notification_icon"
                    id="notificationBell">

                        <i class="fa fa-bell"></i>

                        <span class="notification_count"
                            id="notificationCount"
                            style="<?php echo e(Auth::user()->unreadNotifications->count() > 0 ? '' : 'display:none;'); ?>">
                            <?php echo e(Auth::user()->unreadNotifications->count()); ?>

                        </span>

                    </a>

                    <!-- Notification Dropdown -->
                    <div class="notification_dropdown" id="notificationDropdown">

                        <div class="notification_dropdown_header">
                            <strong>Notifications</strong>
                        </div>

                        <div id="notificationList">

                            <div class="notification_loading">
                                Loading...
                            </div>

                    </div>

                </div>

            </div>
                <div class="icon_info">
                    <ul class="user_profile_dd">
                        <li>
                           
                            
                            <a class="dropdown-toggle" data-toggle="dropdown">

                                <img class="img-responsive rounded-circle"
                                     src="<?php echo e(!empty(Auth::user()->employee->image)
                                            ? asset('uploads/employees/' . Auth::user()->employee->image)
                                            : asset('images/layout_img/user_img.jpg')); ?>"
                                     style="width:40px; height:40px; object-fit:cover;">
                            
                                <span class="name_user"><?php echo e(Auth::user()->name); ?></span>
                            
                            </a>

                            <div class="dropdown-menu">

                                <form id="logout-form"
                                      action="<?php echo e(route('logout')); ?>"
                                      method="POST"
                                      style="display: none;">
                                    <?php echo csrf_field(); ?>
                                </form>

                                <a class="dropdown-item"
                                   href="#"
                                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    Logout <i class="fa fa-sign-out"></i>
                                </a>

                            </div>
                        </li>
                    </ul>
                </div>
            </div>

        </div>
    </nav>
</div>





<!-- Notification Popup  js-->

<script>

document.addEventListener('DOMContentLoaded', function () {

    const bell = document.getElementById('notificationBell');
    const dropdown = document.getElementById('notificationDropdown');

    if (!bell || !dropdown) {
        return;
    }

    /*
    |--------------------------------------------------------------------------
    | Bell Click
    |--------------------------------------------------------------------------
    */

    bell.addEventListener('click', function () {

        if (dropdown.style.display === 'block') {

            dropdown.style.display = 'none';

            return;
        }

        dropdown.style.display = 'block';

        loadNotifications();
    });

        document.addEventListener('click', function (event) {

    if (
        !bell.contains(event.target) &&
        !dropdown.contains(event.target)
    ) {
        dropdown.style.display = 'none';
    }

});

    /*
    |--------------------------------------------------------------------------
    | Load Notifications
    |--------------------------------------------------------------------------
    */

    function loadNotifications() {

        const notificationList =
            document.getElementById('notificationList');

        const countElement =
            document.getElementById('notificationCount');

        if (!notificationList || !countElement) {
            return;
        }

        notificationList.innerHTML =
            '<div class="notification_loading">Loading...</div>';


        fetch("<?php echo e(url('/notifications')); ?>", {
            method: 'GET',
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            credentials: 'same-origin'
        })
        .then(response => {

            if (!response.ok) {
                throw new Error(
                    'HTTP error: ' + response.status
                );
            }

            return response.json();
        })
        .then(data => {

            let html = '';


            /*
            |--------------------------------------------------------------------------
            | UNREAD
            |--------------------------------------------------------------------------
            */

            if (
                data.unread &&
                data.unread.length > 0
            ) {

                html += `
                    <div class="notification_section_title">
                        Unread
                    </div>
                `;

                data.unread.forEach(notification => {

                    html += `
                        <div class="notification_item unread"
                             data-id="${notification.id}"
                             data-task-id="${notification.task_id || ''}">
                             
                             <div class="notification_item_icon">
                                 <i class="fa fa-bell"></i>
                             </div>
                             
                             <div class="notification_item_content">
                                <div class="notification_item_message">
                                    ${notification.message}
                                </div>
    
                                <div class="notification_item_time">
                                    <i class="fa fa-clock-o"></i> ${notification.created_at}
                                </div>
                             </div>

                        </div>
                    `;
                });
            }


            /*
            |--------------------------------------------------------------------------
            | READ
            |--------------------------------------------------------------------------
            */

            if (
                data.read &&
                data.read.length > 0
            ) {

                html += `
                    <div class="notification_section_title">
                        Seen
                    </div>
                `;

                data.read.forEach(notification => {

                    html += `
                        <div class="notification_item"
                             data-id="${notification.id}"
                             data-task-id="${notification.task_id || ''}">

                             <div class="notification_item_icon" style="background:#f8f9fa; color:#adb5bd;">
                                 <i class="fa fa-check"></i>
                             </div>
                             
                             <div class="notification_item_content">
                                <div class="notification_item_message" style="color:#6c757d; font-weight:400;">
                                    ${notification.message}
                                </div>
    
                                <div class="notification_item_time">
                                    <i class="fa fa-clock-o"></i> ${notification.created_at}
                                </div>
                             </div>

                        </div>
                    `;
                });
            }


            /*
            |--------------------------------------------------------------------------
            | EMPTY
            |--------------------------------------------------------------------------
            */

            if (html === '') {

                html = `
                    <div class="notification_loading">
                        No notifications
                    </div>
                `;
            }


            notificationList.innerHTML = html;
            notificationList.querySelectorAll('.notification_item').forEach(function (item) {

    item.addEventListener('click', function () {

        const notificationId = this.dataset.id;

        fetch("<?php echo e(url('/notifications')); ?>/" + notificationId + "/read", {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>',
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            credentials: 'same-origin'
        })
        .then(response => {

            if (!response.ok) {
                throw new Error('HTTP error: ' + response.status);
            }

            return response.json();
        })
        .then(data => {

            if (data.status === true) {

                // Notification ko dobara load karo
                // Ab ye Seen section me aayegi
                loadNotifications();
            }

        })
        .catch(error => {

            console.error(
                'Mark notification as read error:',
                error
            );

        });

    });

});


            /*
            |--------------------------------------------------------------------------
            | UPDATE BELL COUNT
            |--------------------------------------------------------------------------
            */

            const unreadCount =
                Number(data.unread_count || 0);

            if (unreadCount > 0) {

                countElement.innerText =
                    unreadCount;

                countElement.style.display =
                    'flex';

            } else {

                countElement.style.display =
                    'none';
            }

        })
        .catch(error => {

            console.error(
                'Notification loading error:',
                error
            );

            notificationList.innerHTML = `
                <div class="notification_loading">
                    Unable to load notifications
                </div>
            `;
        });
    }


    /*
    |--------------------------------------------------------------------------
    | PAGE LOAD PAR BELL COUNT
    |--------------------------------------------------------------------------
    */

    loadNotifications();

});

</script><?php /**PATH C:\laragon\www\vac-barcode-task\resources\views/components/header.blade.php ENDPATH**/ ?>