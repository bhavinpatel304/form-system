 

var welcome_description = {
    selector: 'textarea#welcome_description',
    browser_spellcheck : true, 
    menubar: false,
    plugins: [
        'advlist autolink lists link image charmap print preview anchor textcolor',
        'searchreplace visualblocks code fullscreen',
        'insertdatetime media table paste code help wordcount spellchecker'
    ],
    toolbar: 'undo redo | formatselect | bold italic forecolor  backcolor | alignleft aligncenter alignright alignjustify ',
    content_css: [
        './tinymce-editor/custom.css',
        './assets/css/theme/theme-main.css'
                         
    ]
};


var thankyou_description = {
    selector: 'textarea#thankyou_description',
    browser_spellcheck: true,
    height: 300,
        
    theme_advanced_resizing: false,
    menubar: false,
    plugins: [
        'advlist autolink lists link image charmap print preview anchor textcolor',
        'searchreplace visualblocks code fullscreen',
        'insertdatetime media table paste code help wordcount spellchecker'
    ],
    toolbar: 'undo redo | formatselect | bold italic forecolor  backcolor | alignleft aligncenter alignright alignjustify ',
    content_css: [
        './tinymce-editor/custom.css',
        './assets/css/theme/theme-main.css'

    ]
};

 
$(function() {

    tinymce.init(welcome_description);
   // tinymce.init(thankyou_description);
 

    $(".mytextarea").click( function(event) {       
        event.stopPropagation();
        tinymce.init(myTextAreaConfig);
    });

    $(window).click(function() {
        tinymce.remove('.mytextarea');
    });
});     