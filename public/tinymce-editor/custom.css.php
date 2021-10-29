<!DOCTYPE html>
<html>
    <head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
        <script src='http://localhost/artc-survey-admin/tinymce-editor/tinymce/js/tinymce/tinymce.min.js'></script>
        <script>
            var myTextAreaConfig = {
                selector: '#mytextarea',
                browser_spellcheck : true,
                height: 500,
                menubar: false,
                plugins: [
                    'advlist autolink lists link image charmap print preview anchor textcolor',
                    'searchreplace visualblocks code fullscreen',
                    'insertdatetime media table paste code help wordcount spellchecker'
                ],
                toolbar: 'undo redo | formatselect | bold italic forecolor  backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | help | spellchecker',
                content_css: [
                    '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
                    '//www.tiny.cloud/css/codepen.min.css',
                    'http://localhost/artc-survey-admin/custom.css'
                ]
            };

            $(function() {
                $("#mytextarea").click( function(event) {
                    //your tinyMCE initcode                    
                    event.stopPropagation();
                    tinymce.init(myTextAreaConfig);
                });

                $(window).click(function() {
                    //alert('outer click');
                    tinymce.remove('#mytextarea');
                });
            });            
        </script>
        <style>
        .red{
            color:red;
        }
        </style>
    </head>

    <body>
        <div id="mytextarea">
            <h1 class="emailHeaderConfig red" >TinyMCE Quick Start Guide</h1>        
            <h2 class="emailHeaderConfig">TinyMCE Quick Start Guide</h2>
            <h3 class="emailHeaderConfig">TinyMCE Quick Start Guide</h3>
            <h4 class="emailHeaderConfig">TinyMCE Quick Start Guide</h4>
            <p class="emailHeaderConfig">TinyMCE Quick Start Guide</p>
        </div>        
    </body>
</html>