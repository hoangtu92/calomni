@extends("layout.landing")

@section('content')

    <div class="signup-node-container">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 signup-node-form">
                    <div>
                        <p class="sno-ad-message text-muted">For the best experience, disable ad blockers and use Chrome
                            or Edge.</p>
                        <div class="steps">
                            <span class="done">1</span>
                            <div class="done"></div>
                            <span class="done">2</span>
                            <div class="done"></div>
                            <span class="active">3</span>

                        </div>
                    </div>

                    <div class="form-container complete-form-container">
                        <div class="form email-form text-center">
                            <h2>You have successfully verified</h2>
                            <a href="{{ url("/calomni_software.tar.xz") }}" class="btn btn-success">Download software</a><br>
                            <a href="{{ backpack_url("/") }}" class="btn btn-primary">Login</a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
