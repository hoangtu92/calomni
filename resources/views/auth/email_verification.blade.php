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
                            <span class="active">2</span>
                            <div></div>
                            <span>3</span>
                        </div>
                    </div>

                    <div class="form-container email-form-container">
                        <div class="form email-form text-center">
                            <h2>Got it!</h2>

                            @if (session('resent'))
                                <div class="alert alert-success" role="alert">
                                    {{ __('A fresh verification link has been sent to your email address.') }}
                                </div>
                            @endif

                            <p>Check your email for next steps.</p>

                            {{ __('If you did not receive the email') }},
                            <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                                @csrf
                                <button type="submit" class="btn-link p-0 m-0 align-baseline">{{ __('click here to request another') }}</button>.
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
