<header>
    <img src="<?= base_url('images/logo.png') ?>" class="design-logo" alt="Aventones Logo">

    <div class="menu-cont">
        <nav class="Head" aria-label="Main menu">
            <ul>
                <li><a href="<?= base_url('allUsers') ?>" class="<?= ($active === 'users') ? 'activo' : '' ?>">Users</a></li>
                <li><a href="<?= base_url('admin/searchReport') ?>" class="<?= ($active === 'searchReport') ? 'activo' : '' ?>">Search Report</a></li>
            </ul>
        </nav>

        <div class="navigation-cont">
            <div class="user-menu">
                <img src="<?= base_url('images/user.png') ?>" class="navigation-image" alt="User icon">
                <nav class="menu-hover">
                    <ul>
                        <li><a href="<?= base_url('logout') ?>">Logout</a></li>
                        <li><a href="<?= base_url('profile') ?>">Profile</a></li>
                        <li><a href="<?= base_url('configuration') ?>">Configuration</a></li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</header>
