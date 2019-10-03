(function( $ ) {
	'use strict';

	/**
	 * All of the code for your admin-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */
	 
	$(function() {
		
	})

	$( window ).load(function() {
		// console.log('hola')
	});

	var urlAddQuestions = "?page=qmaker&action=addquestions&idQuiz="
	var $name = $('#inputName')
	var $descrition = $('#inputdescription')

	$('#create-quiz').on('click', function(e){
		e.preventDefault();
		console.log('name: ', $name.val() )
		console.log('descrition: ', $descrition.val() )

		//Evento ajax
		$.ajax({
			url:		qmaker.url,
			type:		'post',
			datatype:	'json',
			data: 		{
				action: 		'qm_add_quiz',
				nonce:			qmaker.seguridad,
				name:			$name.val(),
				description:	$descrition.val(),
				tipo:			'add'
			},
			success: function(data){
				data = JSON.parse(data);
				if(data.result){
					console.log('Todo Ok!');
					urlAddQuestions += data.insert_id;
					setTimeout(function(){
						location.href = urlAddQuestions;
					}, 1300);
				}
				console.log('Resultado: ', data);
			},
			error: function(d, x, v){
				console.log(d)
				console.log(x)
				console.log(v)
			}
		})
	 })


	 var $btnAddResponse = $('.addresponse-btn')
	 var $btnDeleResponse = $('.delete-answer-btn')
	 var $btnSaveResponse = $('.save-question-btn')

	 $btnAddResponse.live('click', function(e){
		var cont = $('.wrapper_anws').children().length + 1
		
		$( '.wrapper_anws' ).append(`
		 <div class="form-row border border-secondary mx-3 mt-2 py-2 px-4">
			<div class="col-md-2 custom-checkbox d-flex align-items-center">
				<input type="checkbox" class="custom-control-input" id="customCheck_${cont}">
				<label class="custom-control-label ml-3" for="customCheck_${cont}">Correcta</label>
			</div>
			<div class="col-md-8">
				<label for="inputName_${cont}">Respuesta:</label>
				<input type="text" class="form-control response_text" id="inputName_${cont}" placeholder="Nombre del Quiz">
			</div>
			<div class="col-md-2 d-flex align-items-center pt-2">
				<button type="button" class="btn btn-outline-danger delete-answer-btn">Quitar</button>
			</div>
		</div>
		 	`);
	 })


	 $btnDeleResponse.live('click', function(){
		console.log('del response 3')
		$(this).parent().parent().remove()
	 })

	 $btnSaveResponse.on('click', function(){
		 $('.wrapper_anws').each(function( index ){
			console.log($( this ).find('.response_text').val())
		 })
	 })
})( jQuery );
