<nav class="navbar navbar-expand-xl navbar-dark fixed-top hk-navbar">
            <a id="navbar_toggle_btn" class="navbar-toggle-btn nav-link-hover" href="javascript:void(0);"><i class="ion ion-ios-menu"></i></a>
            <router-link to="/" class="navbar-brand" >
                <h2 class="  text-white" style="font-family: 'Sacramento', cursive;">TheSquadSpace</h2>
            </router-link>
            <ul class="navbar-nav hk-navbar-content">
                <li class="nav-item">
                    <a id="navbar_search_btn" class="nav-link nav-link-hover" href="javascript:void(0);"><i class="ion ion-ios-search"></i></a>
                </li>
                 
                <notification-list></notification-list>
                <li class="nav-item dropdown dropdown-authentication">
                    <a class="nav-link dropdown-toggle no-caret" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <div class="media">
                            <div class="media-img-wrap">
                                <div class="avatar">
                                    <img v-if="authuser.images!=null" :src="authuser.images" alt="user" class="avatar-img rounded-circle">
                                    <span v-else class="avatar-text  rounded-circle" :class="'avatar-text-'+authuser.avatar">
                                        <span class="initial-wrap">
                                            <span v-if="authuser.firstname">@{{ authuser.firstname.charAt(0)+authuser.lastname.charAt(0) }}</span>
                                        </span>
                                    </span>
                                </div>
                                <span class="badge badge-success badge-indicator"></span>
                            </div>
                            <div class="media-body">
                                <span>@{{ authuser.fullname }}<i class="zmdi zmdi-chevron-down"></i></span>
                            </div>
                        </div>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" data-dropdown-in="flipInX" data-dropdown-out="flipOutX">
                        <router-link class="dropdown-item" :to="'/user/'+username"><i class="dropdown-icon zmdi zmdi-account"></i><span>Profile</span></router-link>
                        
                        <router-link class="dropdown-item" to="/chats"><i class="dropdown-icon zmdi zmdi-email"></i><span>Inbox</span></router-link>
                        
                        <div class="dropdown-divider"></div>
                       
                        <div class="dropdown-divider"></div>
                        <router-link class="dropdown-item" to="/logout"><i class="dropdown-icon zmdi zmdi-power"></i><span>Log out</span></router-link>
                    </div>
                </li>
            </ul>
        </nav>
        <search-form></search-form>