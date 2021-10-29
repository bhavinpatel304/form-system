@extends('layouts.admin')
@section('page_title', 'Profile')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                 @if( Session::has( 'failed' ))
                    <div class="alert alert-danger" role="alert">
                        {{ Session::get( 'failed' ) }}
                    </div>
                @endif

                @if( Session::has( 'success' ))
                    <div class="alert alert-success" role="alert">
                        {{ Session::get( 'success' ) }}
                    </div>
                @endif
                <div class="card-header">Profile</div>

                    <div class="card-body">
                    <form method="POST" action="{{ route('profile') }}" enctype="multipart/form-data" novalidate>
                        @csrf

                        <div class="form-group row">
                            <label for="fname" class="col-md-4 col-form-label text-md-right">First Name</label>

                            <div class="col-md-6">
                                <input id="fname" type="text" class="form-control @error('fname') is-invalid @enderror" name="fname" value="{{ old('fname') ? old('fname') : Auth::user()->fname }}"  required >

                                @error('fname')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="lname" class="col-md-4 col-form-label text-md-right">Last Name</label>

                            <div class="col-md-6">
                                <input id="lname" type="text" class="form-control @error('lname') is-invalid @enderror" name="lname" value="{{ old('lname') ? old('lname') : Auth::user()->lname }}"  required >

                                @error('lname')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>



                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">Email</label>

                            <div class="col-md-6">
                                <input id="email" type="text" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') ? old('email') : Auth::user()->email }}"  required >

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>


                         <div class="form-group row">
                            <label for="contact_number" class="col-md-4 col-form-label text-md-right">Mobile Number</label>

                            <div class="col-md-6">
                                <input id="contact_number" type="text" class="form-control @error('contact_number') is-invalid @enderror" name="contact_number" value="{{ old('contact_number') ? old('contact_number') : Auth::user()->contact_number }}"  required >

                                @error('contact_number')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            
                            <label for="contact_number" class="col-md-4 col-form-label text-md-right">Profile Image (jpg, png, jpeg)</label>
                                <div class="col-md-6">
                                    <div class=" thumbnail-img">
                                        
                                        <span class="thumbnail thumb-lg" id="imagePreview">
                                            @if (empty(Auth::user()->profile_image) || !file_exists($user_thumb_path . Auth::user()->profile_image))
                                            <img alt="profile_image" id="profile_image" src="{{ url('/images/' . env('DEFAULT_USER_IMAGE','')) }}" />
                                            @else

                                            <?php  $imageUrl = url($imgUrl) . '/' . Auth::user()->profile_image; ?>
                                            <img alt="profile_image" id="profile_image" src="<?= url($imageUrl); ?>" />
                                            @endif
                                            
                                            
                                        </span>
                                        <input accept="image/*"  id="profile_image" name="profile_image" type="file"/>
                                    </div>
                                </div>

                        </div>


                         

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    Update Profile
                                </button>
                            </div>
                        </div>

                    </form>

                
            </div>
        </div>
    </div>
</div>
@endsection
