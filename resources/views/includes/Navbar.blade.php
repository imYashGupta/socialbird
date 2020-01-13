<nav class="hk-nav hk-nav-light">
    <a href="javascript:void(0);" id="hk_nav_close" class="hk-nav-close"><span class="feather-icon"><i data-feather="x"></i></span></a>
    <div class="nicescroll-bar">
        <div class="navbar-nav-wrap">
            <ul class="navbar-nav flex-column">
                
                <li class="nav-item">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <router-link to="/" class="nav-link">
                            <i class="ion ion-ios-paper"></i>
                            <span class="nav-link-text">Feed</span>
                            </router-link>
                        </li>
                        <li class="nav-item">
                            <router-link :to="'/user/'+username" class="nav-link">
                            <i class="ion ion-ios-person"></i>
                            <span class="nav-link-text">Profile</span>
                            </router-link>
                        </li>
                
                        <li class="nav-item">
                            <router-link class="nav-link" to="/chats">
                            <i class="ion ion-ios-chatboxes"></i>
                            <span class="nav-link-text">Messages</span>
                            </router-link>
                        </li>
                        <li class="nav-item">
                            <router-link class="nav-link" to="/logout">
                            <i class="ion ion-ios-log-out"></i>
                            <span class="nav-link-text">Logout</span>
                            </router-link>
                        </li>
                    </ul>
                </li>
                
            </ul>
            
            
            <hr class="nav-separator">
            <div class="nav-header">
                <span>Support and logs</span>
                <span>GS</span>
            </div>
            <ul class="navbar-nav flex-column">
                <li class="nav-item">
                    <router-link to="/about" class="nav-link" >
                        <i class="ion ion-ios-information-circle"></i>
                        <span class="nav-link-text">About the App</span>
                    </router-link>
                </li>
                <li class="nav-item">
                    <router-link to="/changeLog" class="nav-link" >
                        <i class="ion ion-ios-list"></i>
                        <span class="nav-link-text">Change logs</span>
                    </router-link>
                </li>
                <li class="nav-item">
                    <router-link class="nav-link" to="/feedback">
                        <i class="ion ion-ios-heart-half"></i>
                        <span class="nav-link-text">Feedback</span>
                    </router-link>
                </li>
            </ul>
        </div>
    </div>
</nav>
<div id="hk_nav_backdrop" class="hk-nav-backdrop"></div>