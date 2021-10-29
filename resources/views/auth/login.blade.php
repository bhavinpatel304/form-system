@extends('layouts.auth')
@section('page_title', 'Login')
@section('content')
<div class=" page loginScreen">
   <div class="d-flex justify-content-center h-p100">
      <div class="align-self-center wow fadeIn" data-wow-duration="4s">
         <div class="login-text text-center">
            <h2>Welcome To</h2>
            <h6>Admin Panel</h6>
         </div>
         <div class="card login-form text-center ">
            <div class="card-body">
               <div class="brand-logo">
                  <img src="{{ asset('images/logo.png') }}" alt="logo">
               </div>
               <h2 class="small-text">Login </h2>              
               
               <form method="POST" action="{{ route('loginpost') }}" novalidate autocomplete="off">
                  @csrf
                  <div class="form-group  with-lable mt-4">
                     <input type="text" id="email" name="email" class="form-control effect-16 @error('email') is-invalid @enderror" value="{{ old('email') }}" required autocomplete="email" autofocus data-validation="required email" data-validation-error-msg-required="Please enter email" data-validation-error-msg-email="Please enter valid email"  data-sanitize="trim"  />
                     <label for="email">Email</label>
                     <span class="focus-border"></span>
                     <img src="{{ asset('images/mail.png') }}" height="15">
                     @error('email')
                     {{-- <span class="invalid-feedback" role="alert">
                     <strong>{{ $message }}</strong>
                     </span> --}}
                     @enderror
                  </div>
                  <div class="form-group  with-lable mt-4 ">
                     <input type="password" id="password" name="password" class="form-control effect-16 @error('password') is-invalid @enderror" required data-validation="required " data-validation-error-msg-required="Please enter password" />
                     <label for="password">Password</label>
                     <span class="focus-border"></span>
                     <img src="{{ asset('images/password.png') }}" height="15">
                     @error('password')
                     <span class="invalid-feedback" role="alert">
                     <strong>{{ $message }}</strong>
                     </span>
                     @enderror
                  </div>
                  <div class="form-group mb-0">
                     <div class="row ">
                        <div class="col-sm-6 text-center-xs">
                           <button type="submit" class="btn btn-primary btn-sm waves-effect waves-light  w-p100">
                           {{ __('Log IN') }}
                           </button>
                        </div>
                        <div class="col-sm-6 d-flex justify-content-center">
                           <a class=" align-self-center textLink  textlinkprimary"
                              href="{{ route('password.request') }}">
                           Forgot Password?</a>
                        </div>
                     </div>
                  </div>
               </form>
            </div>
         </div>
      </div>
   </div>
   @include('admin.common.footer')
</div>
@endsection

@section('scripts')
 @parent
 <script src="//cdnjs.cloudflare.com/ajax/libs/jquery-form-validator/2.3.26/jquery.form-validator.min.js"></script>
@endsection


@section('jscode')
<script>
  $.validate({
     modules : 'sanitize',
      validateOnBlur : true,
    
  });
  @include('admin.common.login_js')
</script>
@endsection