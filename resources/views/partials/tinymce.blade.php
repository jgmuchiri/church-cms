@push('scripts')
<script src="/plugins/tinymce/tinymce.min.js"></script>
<script>

    tinymce.init({
        selector: '.editor',
        bootstrapConfig: {
            'imagesPath': '/storage/images/', // replace with your images folder path
            'bootstrapElements': {
                'btn': true,
                'icon': true,
                'image': true,
                'table': true,
                'template': true,
                'breadcrumb': true,
                'pagination': true,
                'pager': true,
                'label': true,
                'badge': true,
                'alert': true,
                'panel': true,
                'snippet': true
            }
        },

        height: 100,
        autoresize_min_height: 100,
        autoresize_max_height: 400,
        autoresize_bottom_margin: 5,
        theme: 'modern',
        plugins: [
            'advlist autolink lists link image charmap print preview hr anchor pagebreak',
            'searchreplace wordcount visualblocks visualchars code fullscreen',
            'insertdatetime media nonbreaking save table contextmenu directionality',
            'emoticons template paste textcolor colorpicker textpattern imagetools autoresize',
            'bootstrap'
        ],
        toolbar1: 'insertfile undo redo | styleselect | forecolor backcolor | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',

        toolbar2: "bootstrap",

        image_advtab: true,
        templates: [
                @foreach(App\Models\EditorTemplates::editorTemplates() as $template)
            {
                title: '{{$template->name}}',
                description: '{{$template->desc}}',
                content: '{!! str_replace("'","\'",$template->body) !!}'
            },
            @endforeach
        ],
        content_css: [
            '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
            '//www.tinymce.com/css/codepen.min.css'
        ]
    });

    var miniOpts = {
        selector: ".mini-editor",
        menu: {
            file: {title: 'File', items: 'newdocument'},
            edit: {title: 'Edit', items: 'undo redo | cut copy paste pastetext | selectall'},
            insert: {title: 'Insert', items: 'link | template hr'},
            view: {title: 'View', items: 'visualaid'},
            format: {
                title: 'Format',
                items: 'bold italic underline strikethrough superscript subscript | formats | removeformat'
            },
            table: {title: 'Table', items: 'inserttable tableprops deletetable | cell row column'},
            tools: {title: 'Tools', items: 'spellchecker code'},
            newmenu: {title: 'New Menu', items: 'newmenuitem'}
        },
        menubar: 'file edit newmenu',
        setup: function (editor) {
            editor.addMenuItem('newmenuitem', {
                text: 'New Menu Item',
                context: 'newmenu',
                onclick: function () {
                    alert('yey!');
                }
            });
        }
    };
</script>
@endpush