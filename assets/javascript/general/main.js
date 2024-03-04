import ClassicEditor from '@ckeditor/ckeditor5-build-classic';
// import SpecialCharacters from '@ckeditor/ckeditor5-special-characters';

function SpecialCharactersEmoji( editor ) {
    editor.plugins.get( 'SpecialCharacters' ).addItems( 'Emoji', [
        { title: 'smiley face', character: '<i class="icons-inventory">' },
        { title: 'rocket', character: '<i class="icons-po">' },
        { title: 'wind blowing face', character: '<i class="icons-amulette">' },
        { title: 'floppy disk', character: '<i class="icons-anneaux">' },
        { title: 'heart', character: '<i class="icons-bouclier">' }
    ], { label: 'Emoticons' } );
}

ClassicEditor
    .create(document.querySelector('.ckeditor'), {
        // plugins: [SpecialCharacters, /* Autres plugins */],
        // toolbar: ['specialCharacters', /* Autres éléments de la barre d'outils */]
    })
    .then(editor => {
        console.log('Editor was initialized', editor);
    })
    .catch(error => {
        console.error(error.stack);
    });

    