<header>
    <img src="<?= base_url('images/logo.png') ?>" class="design-logo" alt="Aventones Logo">

    <div class="menu-cont">
        <nav class="Head" aria-label="Main menu">
            <ul>
                <li><a href="<?= base_url('searchRides/searchRides') ?>" class="<?= ($active === 'home') ? 'activo' : '' ?>">Home</a></li>
                <li><a href="<?= base_url('bookings') ?>" class="<?= ($active === 'bookings') ? 'activo' : '' ?>">Bookings</a></li>
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
