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
	var urlhome = "?page=qmaker"
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
		 <div class="form-row border border-secondary mx-3 mt-2 py-2 px-4 item_answer">
			<div class="col-md-2 custom-checkbox d-flex align-items-center is_correct_response">
				<input type="checkbox" class="custom-control-input response_iscorrect" id="customCheck_${cont}">
				<label class="custom-control-label ml-3" for="customCheck_${cont}">Correcta</label>
			</div>
			<div class="col-md-8 text_response">
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
		var questionObj = new Object()
		questionObj.idQuiz = $('.quiz_id').val()
		questionObj.questionName = $('.question_text').val()
		var responses = Array()
		$('.item_answer').each(function() {
			var responseObj = new Object()
			var responseCorrect = $(this).find(".is_correct_response input")
			var responseText = $(this).find(".response_text")
			responseObj.isCorrect = responseCorrect.is(':checked')
			responseObj.responseText = responseText.val()
			responses.push(responseObj)
		});
		questionObj.response = responses
		console.info(questionObj)

		//Evento ajax
		$.ajax({
			url:		qmaker.url,
			type:		'post',
			datatype:	'json',
			data: 		{
				action: 		'qm_questions_manager',
				nonce:			qmaker.seguridad,
				question:		JSON.parse(JSON.stringify(questionObj)),
				tipo:			'add'
			},
			success: function(data){
				data = JSON.parse(data);
				if(data.result){
					console.log('Todo Ok!');
					var r = confirm("Pregunta agregada correctamente. ¿Deseas agregar más?")
					if(r === true){
						urlAddQuestions += $('.quiz_id').val()
						location.href = urlAddQuestions;
					}else{
						location.href = urlhome;
					}
				}
			},
			error: function(d, x, v){
				console.log(d)
				console.log(x)
				console.log(v)
			}
		})
	 })
})( jQuery );
