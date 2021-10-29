<!DOCTYPE html>
<html>
    <head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
        <script src='http://localhost/artc-survey-admin/tinymce-editor/tinymce/js/tinymce/tinymce.min.js'></script>
        <script>
            var myTextAreaConfig = {
                selector: '.mytextarea',
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
                    'http://localhost/artc-survey-admin/tinymce-editor/custom.css'                    
                ]
            };

            $(function() {
                $(".mytextarea").click( function(event) {       
                    event.stopPropagation();
                    tinymce.init(myTextAreaConfig);
                });

                $(window).click(function() {
                    tinymce.remove('.mytextarea');
                });
            });            
        </script>
         
    </head>

    <body>
        <div class="mytextarea">
            <h1 class="emailHeaderConfig red" >TinyMCE Quick Start Guide</h1>        
            
        </div>        
    </body>
</html>