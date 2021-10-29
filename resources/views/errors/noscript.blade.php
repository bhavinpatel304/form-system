@extends('layouts.noscript')
@section('content')
<div class="d-flex justify-content-center h-p100 page-error ">
    {{-- <div class="align-self-center">
        <h1 class="animation-slide-top">
            Javascript disabled
        </h1>
        <p>
            
            Sorry! please enable javascript in your browser first.
        </p>
        <p class="error-advise">
            YOU SEEM TO BE TRYING TO FIND HIS WAY HOME
        </p>
        
    </div> --}}

<div class="container text-center">

    

    <!-- NoScript Alert -->
     
    	<div class="alert alert-danger">
			
			<span><strong>Notice: </strong> JavaScript is not enabled. <a href="http://enable-javascript.com/" class="alert-link">Please Enable JavaScript Safley</a>.</span>
		</div>
	 
    
    <p><strong>The above alert</strong> will only show is JavaScript is disabled in the browser.</p>
    
    
    
    <blockquote> Nowadays almost all web pages contain JavaScript, a scripting programming language that runs on visitor's web browser. It makes web pages functional for specific purposes and if disabled for some reason, the content or the functionality of the web page can be limited or unavailable. Here you can find instructions on how to enable (activate) JavaScript in five most commonly used browsers.</blockquote>
    
    <pre>
        
            For full functionality of this site it is necessary to enable JavaScript.
            Here are the <a href="http://www.enable-javascript.com/" target="_blank"> instructions how to enable JavaScript in your web browser</a>.
        
    </pre>
    
    

</div>
</div>
@endsection
