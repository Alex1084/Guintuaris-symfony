import * as CKEditor from './ckeditor5/build/ckeditor.js'
// import { SpecialCharacters as SpecialCharacters } from 'https://cdn.jsdelivr.net/npm/@ckeditor/ckeditor5-special-characters@41.1.0'
// SpecialCharacters

function SpecialCharactersEmoji( editor ) {
    editor.plugins.get( 'SpecialCharacters' ).addItems( 'Emoji', [
        { title: 'smiley face', character: '😊' },
        { title: 'rocket', character: '🚀' },
        { title: 'wind blowing face', character: '🌬️' },
        { title: 'floppy disk', character: '💾' },
        { title: 'heart', character: '❤️' }
    ], { label: 'Emoticons' } );
}
ClassicEditor.create( document.querySelector( '#form_lore' ), {
    //  plugins: [SpecialCharacters],
} )