@php
    if(DB::table('organizations')->where('owner_url', explode('/',url()->current())[2])->exists()){
        $org = DB::table('organizations')->where('owner_url', explode('/',url()->current())[2])->first();
    }
    if(App\Organization::where('custom_domain', explode('/',url()->current())[2])->exists()){
        $org = App\Organization::where('custom_domain', explode('/',url()->current())[2])->first();
    }
@endphp
@extends('layouts.login', ['title' => $org->name_e.' - Forget Password'])

@section('content')
    <div class="limiter">
        <div class="container-login100"
             style="background:url({{ asset(!empty($org->front_image) && !empty(App\Photo::findOrFail($org->front_image)->file) ? str_replace(' ', '%20', App\Photo::findOrFail($org->front_image)->file) : '') }})">
            <div class="overlay_login"></div>

            <div class="wrap-login100 reset_pass">

                @if(Request::is('admin/password/reset'))
                    <form class="login100-form validate-form" method="post" action="{{ route('password.email') }}">
                        @csrf

                        <div class="login100-pic js-tilt pulse" data-tilt>
                            <img src="{{ asset(!empty($org->image_id) && !empty(App\Photo::findOrFail($org->image_id)->file) ? App\Photo::findOrFail($org->image_id)->file : 'trust.png') }}"
                                 alt="IMG">
                        </div>

                        <span class="login100-form-title">
					Forget Password
				</span>
                        @if($errors->has('email'))
                            <div class="alert alert-danger">
                                <strong style="font-weight: 400;">{{ $errors->first('email') }}</strong>
                            </div>
                        @endif
                        @if ($errors->has('reset'))
                            <div class="alert alert-danger">
                                <strong style="font-weight: 400;">{{ $errors->first('reset') }}</strong>
                            </div>
                        @endif
                        <div class="wrap-input100 validate-input" data-validate="Valid email is required: ex@abc.xyz">
                            <input class="input100" type="text" name="email" placeholder="Email"
                                   value="{{ old('email') }}">
                            <span class="focus-input100"></span>
                            <span class="symbol-input100">
						<i class="fa fa-envelope" aria-hidden="true"></i>
					</span>
                        </div>


                        <div class="container-login100-form-btn">
                            <button class="login100-form-btn">
                                Forget
                            </button>
                        </div>

                        <div class="text-center p-t-136">
                            <a class="txt2" href="{{ route('login') }}">
                                Back to login
                                <i class="fa fa-long-arrow-right m-l-5" aria-hidden="true"></i>
                            </a>
                        </div>
                    </form>
                @else
                    <form class="login100-form validate-form" method="post" action="{{ url('password/email') }}">
                        @csrf
                        <span class="login100-form-title">
					Forget Password
				</span>
                        @if($errors->has('email'))
                            <div class="alert alert-danger">
                                <strong style="font-weight: 400;">{{ $errors->first('email') }}</strong>
                            </div>
                        @endif
                        @if ($errors->has('reset'))
                            <div class="alert alert-danger">
                                <strong style="font-weight: 400;">{{ $errors->first('reset') }}</strong>
                            </div>
                        @endif

                        <div class="wrap-input100 validate-input" data-validate="Valid email is required: ex@abc.xyz">
                            <input class="input100" type="text" name="email" placeholder="Email"
                                   value="{{ old('email') }}">
                            <span class="focus-input100"></span>
                            <span class="symbol-input100">
						<i class="fa fa-envelope" aria-hidden="true"></i>
					</span>
                        </div>


                        <div class="container-login100-form-btn">
                            <button class="login100-form-btn">
                                Forget
                            </button>
                        </div>

                        <div class="text-center p-t-136">
                            <a class="txt2" href="{{ route('login') }}">
                                Back to login
                                <i class="fa fa-long-arrow-right m-l-5" aria-hidden="true"></i>
                            </a>
                        </div>
                    </form>
                @endif

            </div>
        </div>
    </div>

    <script>
        function showPass() {
            var x = document.getElementById("showpassword");
            if (x.type === "password") {
                x.type = "text";
            } else {
                x.type = "password";
            }
        }
    </script>
@endsection
