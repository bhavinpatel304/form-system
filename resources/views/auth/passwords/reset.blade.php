@extends('layouts.auth')
@section('page_title', 'Reset Password')
@section('content')
<div class=" page loginScreen">
   <div class="d-flex justify-content-center h-p100">
      <div class="align-self-center">
         <div class="card w-500 login-form text-center  wow fadeIn" data-wow-duration="4s">
            <div class="card-body">
               <div class="brand-logo">
                  <img src="{{ asset('images/logo.png') }}" alt="logo">
               </div>
               <h2 class="small-text">Reset Password?</h2>
                @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
               {{-- <span class="text">Confirm Email Address</span> --}}
               <form method="post" action="{{ route('password.update') }}" novalidate autocomplete="off">
                    @csrf
                    <input type="hidden" name="token" value="{{ $token }}">
                     <input id="email" type="hidden" class="form-control effect-16 @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus data-validation="required email" data-validation-error-msg-required="Please enter email" data-validation-error-msg-email="Please enter valid email">
                  {{-- <div class="form-group  with-lable mt-4 ">
                     
                     <input id="email" type="hidden" class="form-control effect-16 @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus data-validation="required email" data-validation-error-msg-required="Please enter email" data-validation-error-msg-email="Please enter valid email">
                     <label for="email">Email</label>
                     <span class="focus-border"></span>
                     <img src="{{ asset('images/mail.png') }}" height="15">
                     @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                  </div> --}}

                  <div class="form-group  with-lable mt-4 ">
                     
                      <input id="password" type="password" class="form-control effect-16 @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" data-validation="required length" data-validation-length="min8" data-validation-error-msg-required="Please enter password" data-validation-error-msg-length="Password must be atleast 8 characters long" />
                     <label for="password">New Password</label>
                     <span class="focus-border"></span>
                     <img src="{{ asset('images/password.png') }}" height="15">
                      @if ($errors->has('password'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>
                                            {{ $errors->first('password') }}
                                            </strong>
                                        </span>
                                        @endif
                  </div>


                  <div class="form-group  with-lable mt-4 ">                     
                       
                       <input class="form-control effect-16" data-validation="required length confirmation" data-validation-confirm="password" data-validation-length="min8" id="password-confirm" name="password_confirmation" type="password" data-validation-error-msg-required="Please enter password" data-validation-error-msg-confirmation="Password and confirm password must be the same" data-validation-error-msg-length="Password must be atleast 8 characters long" />
                     <label for="password-confirm">Confirm Password</label>
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
                                    {{ __('RESET PASSWORD') }}
                                </button>
                        </div>
                        <div class="col-sm-6 d-flex justify-content-center">
                           <a class=" align-self-center textLink  textlinkprimary" href="{{ route('login') }}">
                           Log In</a>
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
      modules: 'security, date',
      validateOnBlur : true,
    
  });
  @include('admin.common.login_js')
</script>
@endsection