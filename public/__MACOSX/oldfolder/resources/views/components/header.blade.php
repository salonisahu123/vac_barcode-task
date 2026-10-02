<div class="topbar">
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="full">

            <button type="button" id="sidebarCollapse" class="sidebar_toggle">
                <i class="fa fa-bars"></i>
            </button>

            <div class="right_topbar">
                <div class="icon_info">
                    <ul class="user_profile_dd">
                        <li>
                           
                            
                            <a class="dropdown-toggle" data-toggle="dropdown">

                                <img class="img-responsive rounded-circle"
                                     src="{{ !empty(Auth::user()->employee->image)
                                            ? asset('uploads/employees/' . Auth::user()->employee->image)
                                            : asset('images/layout_img/user_img.jpg') }}"
                                     style="width:40px; height:40px; object-fit:cover;">
                            
                                <span class="name_user">{{ Auth::user()->name }}</span>
                            
                            </a>

                            <div class="dropdown-menu">

                                <form id="logout-form"
                                      action="{{ route('logout') }}"
                                      method="POST"
                                      style="display: none;">
                                    @csrf
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