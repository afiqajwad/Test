<?php
    $studentLogin = ($_SESSION['student'] ?? null);

    $adminEmail = '';
    $totalNotification = 0;
    $profilePicture = 'img/photos/default_avatar.jpeg';

    //# Notification Student
    if(!empty($studentLogin)){
        $profile = fetchRow("SELECT * FROM `student` WHERE `matricno` = '".$studentLogin->matricno."'");
        $notiCollection = fetchRows("SELECT * FROM `notification` WHERE `matricno` = '".$studentLogin->matricno."'");

        if($profile){
            $profile = json_decode(json_encode($profile), false);

            if(isset($profile->profile_picture) && !empty($profile->profile_picture)){
                $profilePicture = 'img/photos/'.$profile->profile_picture;
            }
        }

        foreach($notiCollection as $n){
            if($n['status'] == null){
                $totalNotification++;
            }
        }
    }

    //# Notification Admin
    if(isset($_SESSION['admin'])){
        $adminEmail = $_SESSION['admin']->email;
        $notiCollection = fetchRows("SELECT * FROM `notification` WHERE `matricno` = '".$adminEmail."'");   

        foreach($notiCollection as $n){
            if($n['status'] == null){
                $totalNotification++;
            }
        }
    }
?>
<nav class="navbar navbar-expand navbar-light navbar-bg">
    <a class="sidebar-toggle js-sidebar-toggle">
        <i class="hamburger align-self-center"></i>
    </a>

    <div class="navbar-collapse collapse">
        <ul class="navbar-nav navbar-align">
            <li class="nav-item dropdown">

                <a class="nav-icon dropdown-toggle" href="#" id="alertsDropdown" data-bs-toggle="dropdown">
                    <div class="position-relative">
                        <i class="align-middle" data-feather="bell"></i>
                        <?php echo ($totalNotification == 0 ? '' : '<span class="indicator">'.$totalNotification.'</span>'); ?>
                    </div>
                </a>

                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end py-0" aria-labelledby="alertsDropdown">
                    <div class="dropdown-menu-header">
                        <?php echo $totalNotification; ?> New Notifications
                    </div>

                    <div class="list-group">
                        <?php 
                            foreach($notiCollection as $n){
                                $notiRedirect = '';
                                $messageText = '';

                                if($n['status'] != null){
                                    continue;
                                }

                                if(isset($_SESSION['student'])){
                                    $notiRedirect = './student-readnoti?id='.$n['id'];
                                    $messageText = $n['message'];
                                }

                                if(isset($_SESSION['admin'])){
                                    $notiRedirect = './admin-readnoti?id='.$n['id'];
                                    $messageText = explode('<~>',$n['message'])[0];
                                }

                                echo '<a href="'.$notiRedirect.'" class="list-group-item">
                                    <div class="row g-0 align-items-center">
                                        <div class="col-2">
                                            <i class="text-warning" data-feather="bell"></i>
                                        </div>
                                        <div class="col-10">
                                            <div class="text-dark">'.$messageText.'</div>
                                            <div class="text-muted small mt-1">'.$n['created_date'].'</div>
                                        </div>
                                    </div>
                                </a>';
                            }
                        ?>
                    </div>

                    <div class="dropdown-menu-footer">
                        <a href="#" class="text-muted">Show all notifications</a>
                    </div>
                </div>
            </li>
            
            <li class="nav-item dropdown">
                <a class="nav-icon dropdown-toggle d-inline-block d-sm-none" href="#" data-bs-toggle="dropdown">
                    <i class="align-middle" data-feather="settings"></i>
                </a>

                <a class="nav-link dropdown-toggle d-none d-sm-inline-block" href="#" data-bs-toggle="dropdown">
                    <img style="object-fit: cover;" src="<?php echo $profilePicture; ?>" class="avatar img-fluid rounded me-1" alt="Charles Hall" />
                    <span class="text-dark"><?php echo (!empty($profile->matricno) ? $profile->matricno : $adminEmail); ?></span>
                </a>

                <div class="dropdown-menu dropdown-menu-end">
                    <?php if(!$isAdmin){ ?>
                        <a class="dropdown-item" href="./student-profile"><i class="align-middle me-1" data-feather="user"></i> Profile</a>
                        <a class="dropdown-item" href="./student-login"><i class="align-middle me-1" data-feather="log-out"></i> Log Out</a>
                    <?php }else{ ?>
                        <a class="dropdown-item" href="./admin-logout"><i class="align-middle me-1" data-feather="log-out"></i> Log Out</a>
                    <?php } ?>
                </div>
            </li>
        </ul>
    </div>
</nav>