@extends('layouts.login', ['title' => DB::table('organizations')->where('id', 1)->value('name_en'). ' - Admin Login'])

@section('content')

<div class="limiter">
	<div class="container-login100">
		<div class="wrap-login100">
			<div class="login100-pic js-tilt" data-tilt>
				<img 	src="{{ asset(!empty(App\Photo::findOrFail(DB::table('organizations')->where('owner_url', explode('/',url()->current())[2])->value('image_id'))->file) ? App\Photo::findOrFail(DB::table('organizations')->where('owner_url', explode('/',url()->current())[2] )->value('image_id'))->file : 'images/img-01.png') }}" alt="IMG">
			</div>
			

                
			@if(Request::is('admin/login'))
            <form class="login100-form validate-form" method="post" action="{{ route('login') }}">
			    @csrf
				<span class="login100-form-title">
					{{ DB::table('organizations')->where('owner_url', explode('/',url()->current())[2])->value('name_en') }} Admin Login
				</span>
				@if ($errors->any())
					<div class="alert alert-danger">
						<strong>{{ $errors->first() }}</strong>
					</div>
				@endif
				<div class="wrap-input100 validate-input" data-validate = "Valid email is required: ex@abc.xyz">
					<input class="input100" type="text" name="email" placeholder="Email" value="{{ old('email') }}">
					<span class="focus-input100"></span>
					<span class="symbol-input100">
						<i class="fa fa-envelope" aria-hidden="true"></i>
					</span>
				</div>

				<div class="wrap-input100 validate-input" data-validate = "Password is required">
					<input class="input100" type="password" name="password" placeholder="Password">
					<span class="focus-input100"></span>
					<span class="symbol-input100">
						<i class="fa fa-lock" aria-hidden="true"></i>
					</span>
				</div>
				
				<div class="container-login100-form-btn">
					<button class="login100-form-btn">
						Login
					</button>
				</div>

				<div class="text-center p-t-12">
					<span class="txt1">
						Forgot
					</span>
					<a class="txt2" href="{{ route('password.request') }}">
						Username / Password?
					</a>
				</div>

				<!--<div class="text-center p-t-136">
					<a class="txt2" href="#">
						Create your Account
						<i class="fa fa-long-arrow-right m-l-5" aria-hidden="true"></i>
					</a>
				</div>-->
			</form>
            @else
                
                <form class="login100-form validate-form" method="post" action="{{ url('dologin') }}">
				    @csrf
					<span class="login100-form-title">
						Member Login
					</span>
					@if ($errors->any())
						<div class="alert alert-danger">
							<strong>{{ $errors->first() }}</strong>
						</div>
					@endif

					<div class="wrap-input100 validate-input" data-validate = "Valid email is required: ex@abc.xyz">
						<input class="input100" type="text" name="email" placeholder="Email" value="{{ old('email') }}">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-envelope" aria-hidden="true"></i>
						</span>
					</div>

					<div class="wrap-input100 validate-input" data-validate = "Password is required">
						<input class="input100" type="password" name="password" placeholder="Password">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-lock" aria-hidden="true"></i>
						</span>
					</div>
					
					<div class="container-login100-form-btn">
						<button class="login100-form-btn">
							Login
						</button>
					</div>

					<div class="text-center p-t-12">
						<span class="txt1">
							Forgot
						</span>
						<a class="txt2" href="{{ route('password.request') }}">
							Username / Password?
						</a>
					</div>

					<!--<div class="text-center p-t-136">
						<a class="txt2" href="#">
							Create your Account
							<i class="fa fa-long-arrow-right m-l-5" aria-hidden="true"></i>
						</a>
					</div>-->
				</form>
            @endif
			    
		</div>
	</div>
</div>
@endsection
