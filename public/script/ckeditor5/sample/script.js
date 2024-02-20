ClassicEditor
	.create( document.querySelector( '.editor' ), {
		// plugins: []
	} )
	.then( editor => {
		window.editor = editor;
	} )
	.catch( handleSampleError );

function handleSampleError( error ) {
	const issueUrl = 'https://github.com/ckeditor/ckeditor5/issues';

	const message = [
		'Oops, something went wrong!',
		`Please, report the following error on ${ issueUrl } with the build id "c9c6c7mdfr6u-2mws4up2i95t" and the error stack trace:`
	].join( '\n' );

	console.error( message );
	console.error( error );
}
