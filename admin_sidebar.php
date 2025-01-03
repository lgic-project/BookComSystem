<section id="sidebar">
    <a href="#" class="brand">
        <i class='bx bxs-smile'></i>
        <span class="text">Bookly</span>
    </a>
    <ul class="side-menu top">
        <li class="active">
            <a href="admin_dashboard.php">
                <i class='bx bxs-dashboard'></i>
                <span class="text">Dashboard</span>
            </a>
        </li>
        <li>
            <a href="admin_add_book.php">
                <i class='bx bxs-file-plus'></i>
                <span class="text">Add Book</span>
            </a>
        </li>
        <li>
            <a href="admin_searchbooks.php">
                <i class='bx bx-search-alt-2'></i>
                <span class="text">Search Book</span>
            </a>
        </li>
        <li>
            <a href="#">
                <i class='bx bxs-folder-minus'></i>
                <span class="text">Delete Book</span>
            </a>
        </li>
        <li>
            <a href="admin_orderprocess.php">
                <i class='bx bxs-group'></i>
                <span class="text">Order</span>
            </a>
        </li>
        <li>
            <a href="admin_stat.php">
                <i class='bx bx-line-chart'></i>
                <span class="text">Report</span>
            </a>
        </li>
    </ul>
    <ul class="side-menu">
        <li>
            <a href="admin_profile.php">
                <i class='bx bx-user-circle'></i>
                <span class="text">Profile</span>
            </a>
        </li>
        <li>
            <a href="admin_logout.php" class="logout">
                <i class='bx bxs-log-out-circle'></i>
                <span class="text">Logout</span>
            </a>
        </li>
    </ul>
</section>

<style>
    :root {
        --main-color: #4b49AC;
        --second-color: #98BDFF;
        --light-blue: #7DA0FA;
        --light-purple: #7978E9;
        --light-red: #F3797E;
    }

    a {
        text-decoration: none;
    }

    li {
        list-style: none;
    }



    html {
        overflow-x: hidden;
    }



    body {
        background: white;
        overflow-x: hidden;
    }

    #sidebar {
        position: fixed;
        top: 0;
        left: 0;
        width: 200px;
        height: 100%;
        background: white;
        color: var(--main-color);
        z-index: 2000;
        transition: .3s ease;
        overflow-x: hidden;
        scrollbar-width: none;
    }

    #sidebar .brand {
        font-size: 24px;
        font-weight: 700;
        height: 56px;
        display: flex;
        align-items: center;
        color: var(--main-color);
        position: sticky;
        top: 0;
        left: 0;
        z-index: 500;
        padding-bottom: 20px;
        box-sizing: content-box;
    }

    #sidebar .brand .bx {
        min-width: 60px;
        display: flex;
        justify-content: center;
    }

    #sidebar .side-menu {
        width: 100%;
        margin-top: 48px;
    }

    #sidebar .side-menu li {
        height: 48px;
        background: transparent;
        margin-left: 6px;
        padding: 4px;
    }




    #sidebar .side-menu li a {
        width: 100%;
        height: 100%;
        background: rgb(255, 255, 255);
        display: flex;
        align-items: center;
        border-radius: 5px;
        font-size: 16px;
        color: rgb(48, 48, 96);
        white-space: nowrap;
        overflow-x: hidden;
    }

    #sidebar.hide .side-menu li a {
        width: calc(48px - (4px * 2));
        transition: width .3s ease;
    }

    #sidebar .side-menu li a.logout {
        color: red;
    }

    #sidebar .side-menu.top li a:hover {
        color: white;
        background: var(--main-color);
    }

    #sidebar .side-menu li a .bx {
        margin: auto 6px;
        display: flex;
        justify-content: center;
    }

    /* SIDEBAR */





    /* CONTENT */
    #content {
        position: relative;
        width: calc(100% - 200px);
        left: 200px;
    }

    #content nav,
    #sidebar .brand {
        box-shadow: 0 10px 15px rgba(0, 0, 0, 0.1), 0 4px 6px rgba(0, 0, 0, 0.05);

    }

    /* NAVBAR */
    #content nav {
        position: fixed;
        height: 76px;
        width: 100%;
        background: white;
        color: var(--main-color);
        padding: 0 60px;
        display: flex;
        align-items: center;
        justify-content: space-around;
        padding-left: 300px;
        top: 0;
    }

    #content nav .nav-link-2 .profile img {
        width: 36px;
        height: 36px;
        object-fit: cover;
        border-radius: 50%;
    }


    #content #main-content {
        margin-top: 8rem;
        margin-right: 8REM;
    }

    #content #main-content h2 {
        margin-left: 50px;
        font-size: x-large;

    }

    /* SIDEBAR */
</style>