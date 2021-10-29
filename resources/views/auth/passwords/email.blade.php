@extends('layouts.auth')
@section('page_title', 'Forgot Password')
@section('content')
<div class=" page loginScreen">
   <div class="d-flex justify-content-center h-p100">
      <div class="align-self-center">
         <div class="card w-500 login-form text-center  wow fadeIn" data-wow-duration="4s">
            <div class="card-body">
               <div class="brand-logo">
                  <img src="{{ asset('images/logo.png') }}" alt="logo">
               </div>
               <h2 class="small-text">Forgot Password?</h2>
               
               {{-- <span class="text">Confirm Email Address</span> --}}
               <form method="post" action="{{ route('password.email') }}" autocomplete="off">
                    @csrf

                    
                  <div class="form-group  with-lable mt-4 ">
                  <input type="text" id="email" name="email" class="form-control effect-16 @error('email') is-invalid @enderror" value="{{ old('email') }}" data-validation="required email server" data-validation-url="{{ route('checkemail') }}"
        data-validation-param-name="email"  data-validation-error-msg-required="Please enter email" data-validation-error-msg-email="Please enter valid email" data-sanitize="trim"  />
                     <label for="email">Email</label>
                     <span class="focus-border"></span>
                     <img src="{{ asset('images/mail.png') }}" height="15">
                     @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                  </div>
                  <div class="form-group  mb-0">
                     <div class="row ">
                        <div class="col-sm-6 text-center-xs">
                           
                              <button type="submit" class="btn btn-primary btn-sm waves-effect waves-light  w-p100">
                                    {{ __('SEND ME EMAIL') }}
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
       $.ajaxSetup({

        headers: {

            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

        }

    });
  $.validate({
      modules : 'security, sanitize',
      validateOnBlur : true,
    
  });
  @include('admin.common.login_js')
</script>
@endsection