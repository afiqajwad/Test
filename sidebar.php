<?php
    $currentrole = null;
    
    if(isset($_SESSION['student'])){
        $currentrole = 'student';
    }

    if(isset($_SESSION['admin'])){
        if($_SESSION['admin']->email == 'admin@admin.admin'){
            $currentrole = 'superadmin';
        }else{
            $currentrole = 'staff';
        }
    }

    $sidebarMenu = (object) [
        (object) array(
            'label' => 'Dashboard',
            'icon' => 'pie-chart',
            'path' => 'student-dashboard',
            'role' => 'student'
        ),
        (object) array(
            'label' => 'Profile',
            'icon' => 'user',
            'path' => 'student-profile',
            'role' => 'student'
        ),
        (object) array(
            'label' => 'My Room',
            'icon' => 'home',
            'path' => 'student-room',
            'role' => 'student'
        ),
        (object) array(
            'label' => 'Apply House',
            'icon' => 'file-text',
            'path' => 'student-college',
            'role' => 'student'
        ),
        (object) array(
            'label' => 'Report House Defect',
            'icon' => 'file-text',
            'path' => 'student-complain',
            'role' => 'student'
        ),
        (object) array(
            'label' => 'House Display',
            'icon' => 'file-text',
            'path' => 'student-display_image',
            'role' => 'student'
        ),
        (object) array(
            'label' => 'Log Out',
            'icon' => 'log-out',
            'path' => 'student-logout',
            'role' => 'student'
        )
    ];

    if($currentrole == 'superadmin'){
        $sidebarMenu = (object) [
            (object) array(
                'label' => 'Dashboard',
                'icon' => 'pie-chart',
                'path' => 'admin-dashboard',
                'role' => 'admin'
            ),
            (object) array(
                'label' => 'House Manager',
                'icon' => 'user',
                'path' => 'admin-staff',
                'role' => 'admin'
            ),
            (object) array(
                'label' => 'Student List',
                'icon' => 'users',
                'path' => 'admin-resident',
                'role' => 'admin'
            ),
            (object) array(
                'label' => 'Manage House',
                'icon' => 'home',
                'path' => 'admin-college',
                'role' => 'admin'
            ),
            (object) array(
                'label' => 'Log Out',
                'icon' => 'log-out',
                'path' => 'admin-logout',
                'role' => 'admin'
            ),
        ];
    }

    if($currentrole == 'staff'){
        $sidebarMenu = (object) [
            (object) array(
                'label' => 'Resident Complain',
                'icon' => 'file-text',
                'path' => 'admin-my-resident-complain',
                'role' => 'admin'
            ),
            (object) array(
                'label' => 'Resident List',
                'icon' => 'users',
                'path' => 'admin-my-resident',
                'role' => 'admin'
            ),
            (object) array(
                'label' => 'Log Out',
                'icon' => 'log-out',
                'path' => 'admin-logout',
                'role' => 'admin'
            ),
        ];
    }
?>

<nav id="sidebar" class="sidebar js-sidebar">
    <div class="sidebar-content js-simplebar">
        <a class="sidebar-brand" href="index.html">
            <span class="align-middle">House Booking</span>
        </a>

        <ul class="sidebar-nav">
            <?php
                foreach($sidebarMenu as $menu){
                    if(constant("roleContext") != $menu->role) continue;

                    echo '
                        <li class="sidebar-item '.(constant("currentFilename") == $menu->path ? 'active' : '').'">
                            <a class="sidebar-link" href="'.$menu->path.'">
                                <i class="align-middle" data-feather="'.$menu->icon.'"></i>
                                <span class="align-middle">'.$menu->label.'</span>
                            </a>
                        </li>
                    ';
                }
            ?>
        </ul>
    </div>
</nav>