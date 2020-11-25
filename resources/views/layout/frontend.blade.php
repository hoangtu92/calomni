<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

@include("layout.general.head")

<body class="{{ $bodyClass ?? '' }}">




@yield("content")

@include("layout.general.footer")

<script src="{{ asset("js/jquery-2.1.1.js") }}"></script>
<script src="{{ asset("js/bootstrap.min.js") }}"></script>
<script src="{{ asset("js/jquery.easy-ticker.min.js") }}"></script>
<script>
    window.onload = function () {
        checkConsent();
    };

    function hasConsented() {
        var name = "storj_cookie_consent=";
        var decodedCookie = decodeURIComponent(document.cookie);
        var ca = decodedCookie.split(';') || [];

        return ca.some(cookie => {
            return cookie.trim().indexOf(name) === 0;
        });
    }

    function checkConsent() {
        if (hasConsented()) {
            document.cookie = "storj_cookie_consent=true;";
            var consentBanner = document.getElementById("consent-banner");

            if (consentBanner) {
                consentBanner.style.display = "none";
            }
        }
    }
</script>

@yield("scripts")

<script>
@if(isset($announcements) && count($announcements) > 0)

    $('.announcements').easyTicker({
    visible: 1,
    interval: 3000,
    mousePause: 0,
    //height: 34,
    controls: {
    up: document.querySelector('.upClick'),
    down: 'z'
    }
    });


    var timeouts = [];
    $(".announcements").find("a").each(function () {
    timeouts.push($(this).data("timeout"))
    });

    function up(index){
    if(typeof index === 'undefined') index = 0;
    if(typeof timeouts[index] !== 'undefined'){
    setTimeout(function () {
    document.querySelector('.upClick').click();
    index++;
    up(index);
    }, timeouts[index]*1000)

    }
    else up(0);

    }

    up();
@endif
</script>
</body>
</html>
