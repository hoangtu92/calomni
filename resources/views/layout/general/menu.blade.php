@if(isset($announcements))
    <div id="top">
        <div class="announcements">
            @foreach($announcements as $announcement)
                <div>{!! $announcement->content !!}</div>
            @endforeach
        </div>
    </div>
@endif
<nav class="navbar navbar-default menu">
    <div class="container">
        <div class="navbar-header">
            <button aria-expanded="false" class="navbar-toggle collapsed" data-target="#navbar-menu"
                    data-toggle="collapse" type="button">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/">
                <img alt="{{ env("APP_NAME") }}" class="logo logo-white" src="{{ asset("images/logo.png") }}">
                <img alt="{{ env("APP_NAME") }}" class="logo logo-blue" src="{{ asset("images/logo-blue.png") }}">
            </a>
        </div>
        <div class="collapse navbar-collapse" id="navbar-menu">
            <ul class="nav navbar-nav navbar-right">

                <li><a class="link-style" href="#">Menu 1</a></li>

                <li><a class="link-style" href="#">Menu 2</a></li>

                <li><a class="link-style" href="#">Menu 3</a></li>

                <li><a class="link-style" href="#">Menu 4</a></li>

                <li><a class="link-style" href="#">Menu 5</a></li>


                @if (Route::has('login'))
                    @auth

                    @else
                        @if (Route::has('register'))
                            <li><a class="pull-right-md nav-join-link" href="{{ route("sign_up_host_verification") }}">
                                    <button class="btn btn-primary nav-join" id="become-a-host-btn">Become a Service Host</button>
                                </a></li>
                        @endif
                    @endauth
                @endif

            </ul>
        </div>
    </div>
</nav>

<script>
    const becomeHostButton = document.getElementById("become-a-host-btn");
    if (becomeHostButton) {
        becomeHostButton.addEventListener("click", function () {
            //analytics.identify(analytics.user().anonymousId(), {become_a_host_clicked: true});
        })
    }
</script>
