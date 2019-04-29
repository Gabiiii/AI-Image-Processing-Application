<header>
    <div class="container-fluid position-relative no-side-padding">

        <a href="{{route('home')}}" class="logo">AIMAGE</a>

        <div class="menu-nav-icon" data-nav-menu="#main-menu"><i class="ion-navicon"></i></div>

        <ul class="main-menu visible-on-click" id="main-menu">
            <li><a href="{{ route('home') }}">홈</a></li>
            <!-- <li><a href="{{ route('post.index') }}">Posts</a></li> -->
            @guest
                <li><a href="{{ route('login') }}">로그인</a></li>
                <li> <a href="{{ route('register') }}">계정등록</a></li>

            @else
                @if(Auth::user()->role->id == 1)
                    <li><a href="{{ route('admin.dashboard') }}">포스트</a></li>
                @endif
                @if(Auth::user()->role->id == 2)
                    <li><a href="{{ route('author.post.index') }}">포스트</a></li>
                @endif
            <li>
                    <a class="dropdown-item" href="{{ route('logout') }}"
                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                        
                        <span>로그아웃</span>
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </li>
            @endguest


        </ul><!-- main-menu -->

        <div class="src-area">
            <form method="GET" action="{{ route('search') }}">
                <button class="src-btn" type="submit"><i class="ion-ios-search-strong"></i></button>
                <input class="src-input" value="{{ isset($query) ? $query : '' }}" name="query" type="text" placeholder="Type of search">
            </form>
        </div>

    </div><!-- conatiner -->
</header>
