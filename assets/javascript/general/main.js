// import ClassicEditor from '@ckeditor/ckeditor5-build-classic';
// // import { ClassicEditor as ClassicEditorBase } from '@ckeditor/ckeditor5-editor-classic';
// // import { Essentials } from '@ckeditor/ckeditor5-essentials';
// // import { Bold, Italic } from '@ckeditor/ckeditor5-basic-styles';
// // import { Heading } from '@ckeditor/ckeditor5-heading';
// // import { List } from '@ckeditor/ckeditor5-list';
// // import { Paragraph } from '@ckeditor/ckeditor5-paragraph';
// // import { SpecialCharacters } from '@ckeditor/ckeditor5-special-characters';

// function SpecialCharactersEmoji( editor ) {
//     editor.plugins.get( 'SpecialCharacters' ).addItems( 'Emoji', [
//         { title: 'smiley face', character: '<i class="icons-inventory">' },
//         { title: 'rocket', character: '<i class="icons-po">' },
//         { title: 'wind blowing face', character: '<i class="icons-amulette">' },
//         { title: 'floppy disk', character: '<i class="icons-anneaux">' },
//         { title: 'heart', character: '<i class="icons-bouclier">' }
//     ], { label: 'Emoticons' } );
// }

// if (document.querySelector('.ckeditor') !== null)
// {
//     ClassicEditor
//     .create(document.querySelector('.ckeditor'), {
//         // plugins: [],
//         toolbar:  ['heading', 'bold', 'italic'],
//        // Définir les règles du modèle pour attribuer une classe à certains éléments
//        heading: {
//         options: [
//             {model : 'heading1', view: 'h1', title: 'Titre 1', class: 'ck-heading_heading1_title'},
//             {model : 'heading2', view: 'h2', title: 'Titre 2', class: 'ck-heading_heading1_sub-title'},
//             {model : 'paragraph', view: 'p', title: 'paragraphe', class: ''},
//             {model : 'paragraph', view: 'p', title: 'note', class: 'ck-heading_heading1_note'},
//         ]
//     }
//     })
//     .then(editor => {
//         console.log('Editor was initialized', editor);
//     })
//     .catch(error => {
//         console.error(error.stack);
//     });
// }
    