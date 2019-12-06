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
	$('#addQuizmodal').on('keypress',function(e) {
		if(e.which == 13) {
			e.preventDefault();
			createQuiz()
		}
	});

	$('#addQuizmodal').on('shown.bs.modal', function () {
		$('#inputName').trigger('focus')
	})

	var urlhome = "?page=qmaker"
	var urlAddQuestions = "?page=qmaker&action=addquestions&idQuiz="

	function createQuiz(){
		console.log('Vamos a crear el quiz')
		var $name = $('#inputName')
		var $descrition = $('#inputdescription')
		if(!$name.val()){
			alert('Debes Agregar un nombre al Quiz')
		}else{
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
						}, 200);
					}
					console.log('Resultado: ', data);
				},
				error: function(d, x, v){
					console.log(d)
					console.log(x)
					console.log(v)
				}
			})
		}
	}

	$('#create-quiz').on('click', function(e){
		e.preventDefault();
		createQuiz()
	 })


	 var $btnAddResponse = $('.addresponse-btn')
	 var $btnDeleResponse = $('.delete-answer-btn')
	 var $btnSaveResponse = $('.save-question-btn')

	 $btnAddResponse.live('click', function(e){
		var cont = $('.wrapper_anws').children().length + 1
		var placeholderAnswers = "Escribe la respuesta"
		$( '.wrapper_anws' ).append(`
		 <div class="form-row border mx-0 mt-2 py-2 px-4 item_answer">
			<div class="col-md-2 custom-checkbox d-flex align-items-center is_correct_response">
				<input type="checkbox" class="custom-control-input response_iscorrect" id="customCheck_${cont}">
				<label class="custom-control-label ml-3" for="customCheck_${cont}">Correcta</label>
			</div>
			<div class="col-md-8 text_response">
				<label for="inputName_${cont}">Respuesta:</label>
				<textarea id="inputName_${cont}" class="form-control response_text" placeholder="${placeholderAnswers}" cols="10" rows="1"></textarea>
			</div>
			<div class="col-md-2 d-flex align-items-center pt-2">
				<button type="button" class="btn btn-sm btn-outline-danger delete-answer-btn">Eliminar respuesta</button>
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
		var hasError = false
		var hasAnswerCorrect = false
		questionObj.idQuiz = $('.quiz_id').val()
		questionObj.questionName = $('.question_text').val()
		var responses = Array()
		$('.item_answer').each(function() {
			var responseObj = new Object()
			var responseCorrect = $(this).find(".is_correct_response input")
			var responseText = $(this).find(".response_text")
			if(responseText.val() === ''){
				hasError = true
			}
			if(responseCorrect.is(':checked')){
				hasAnswerCorrect = true
			}
			responseObj.isCorrect = responseCorrect.is(':checked') ? 1 : 0;
			responseObj.responseText = responseText.val()
			responses.push(responseObj)
		});
		questionObj.response = responses
		console.info(questionObj)
		
		if(questionObj.questionName === ''){
			hasError = true
		}
		
		if(!hasError && hasAnswerCorrect){
			console.log('Todo OK!')
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
						alert('Pregunta agregada correctamente!')

						urlAddQuestions += $('.quiz_id').val()
						location.href= urlAddQuestions
					}
					console.log('Algo salió mal... ', data)
				},
				error: function(d, x, v){
					console.log(d)
					console.log(x)
					console.log(v)
				}
			})
		}else{
			console.log('No funciona correctamente.. ', hasError , hasAnswerCorrect)
			alert('Debes agregar una pregunta y marcar al menos una respuesta como correcta.')
			hasError = false
			hasAnswerCorrect = false
		}
	 })
	
})( jQuery );


function addItemQuestion(idWrapp){
	var cont = jQuery('.wrapper_anws_'+idWrapp).children().length + 1
	var ans_id = `${uniqueid()}`
	var placeholderAnswers = "Escribe la respuesta"
	jQuery( '.wrapper_anws_'+idWrapp ).append(`
		 <div class="form-row border mx-0 mt-2 py-2 px-4 item_answer">
			<div class="col-md-2 custom-checkbox d-flex align-items-center is_correct_response">
				<input type="checkbox" class="custom-control-input response_iscorrect" id="customCheck_${ans_id}">
				<label class="custom-control-label ml-3" for="customCheck_${ans_id}">Correcta</label>
			</div>
			<div class="col-md-8 text_response">
				<label for="inputName_${ans_id}">Respuesta:</label>
				<textarea id="inputName_${ans_id}" class="form-control response_text" placeholder="${placeholderAnswers}" cols="10" rows="1"></textarea>
			</div>
			<div class="col-md-2 d-flex align-items-center pt-2">
				<button type="button" class="btn btn-sm btn-outline-danger delete-answer-btn">Eliminar respuesta</button>
			</div>
		</div>
			 `);
	jQuery(`#inputName_${ans_id}`).focus()
 }

 function deleteQuestion(id){
	var r = confirm("La pregunta será removida, ¿esta seguro?")
	if(r === true){
		jQuery('.wrapp_manager_question_'+id).remove()
	}
	 
 }

 function saveChangesQuestions(idQuiz){
	var questions = Array()
	var quiz = new Object()
	let hasErrorGeneral = false
	let hasErrorOnQuestion = false
	if(jQuery('.name_quiz').val() === ""){
		hasErrorGeneral = true
	}
	quiz.name = jQuery('.name_quiz').val()
	quiz.description = jQuery('.description_quiz').val()
	quiz.total_questions = jQuery('.wrap_main_questions').children().length
	quiz.idQuiz = idQuiz
	jQuery('.wrapper_question').each(function() {
		var questionText = jQuery(this).find('.question_text')
		if(questionText.val() === ""){
			hasErrorOnQuestion = true
		}
		var questionNmbr = jQuery(this).find('.question_number')
		var questionObj = new Object()
		questionObj.questionName = questionText.val()
		questionObj.questionNmbr = questionNmbr.val()
		var responses = Array()
		jQuery(this).find('.item_answer').each(function(){
			var responseObj = new Object()
			var responseCorrect = jQuery(this).find('.is_correct_response input')
			var responseText = jQuery(this).find('.response_text')
			responseObj.isCorrect = responseCorrect.is(':checked') ? 1 : 0;
			responseObj.responseText = responseText.val()
			responses.push(responseObj)
		})
		questionObj.response = responses
		questions.push(questionObj)
	})
	let hasResponse = false
	let hasEmptyAnws = false
	quiz.questions = questions
	quiz.questions.map(q =>{
		hasResponse = false
		hasEmptyAnws  = false
		q.response.forEach(anws => {
			if(anws.responseText  === ""){
				hasEmptyAnws = true
			}
			if(anws.isCorrect == 1){
				hasResponse = true
			}
		});
		if(!hasResponse){
			console.log('Esta pregunta no tiene respuesta', q)
		}
		if(hasEmptyAnws){
			console.log('Esta pregunta no tiene texto', q)
		}
	})
	let qmIsValid = true
	if(!hasResponse){
		alert('Hay por lo menos, una pregunta que no tiene una respuesta correcta.')
		qmIsValid = false
	}else if(hasEmptyAnws){
		alert('Hay preguntas que tienen respuestas vacias.')
		qmIsValid = false
	}else if(hasErrorOnQuestion){
		alert('Hay preguntas vacias.')
		qmIsValid = false
	}else if(hasErrorGeneral){
		alert('El quiz debe tener un nombre.')
		qmIsValid = false
	}
	if(qmIsValid){
		// Evento ajax 
		jQuery.ajax({
			url:		qmaker.url,
			type:		'post',
			datatype:	'json',
			data: 		{
				action: 		'qm_questions_manager',
				nonce:			qmaker.seguridad,
				quiz:			JSON.parse(JSON.stringify(quiz)),
				tipo:			'update'
			},
			success: function(data){
				data = JSON.parse(data);
				if(data.result){
					console.info(data)
					alert('Actualizado exitosamente.')
				}
				console.info(data)
			},
			error: function(d, x, v){
				console.log(d)
				console.log(x)
				console.log(v)
			}
		})
	}
	
 }

function uniqueid() {
	return Math.random().toString(36).substr(2, 9);
}

function closeEditor() {
	const home = '?page=qmaker'
	const exit = confirm('¿Estás seguro de salir? Puedes tener cambios sin guardar.')

	if(exit) window.location.href = home
}

 function addQuestionWrap(idQuiz){
	var nmbrQuestion = 	jQuery('.wrap_main_questions').children().length + 1
	var wrapAns = 	(jQuery('.wrap_main_questions').children().length + 1) + uniqueid()
	var ans_id = `${uniqueid()}`
	var placeholderQuestion = "Escribe la pregunta"
	var placeholderAnswers = "Escribe la respuesta"
	jQuery('.wrap_main_questions').append(`
		<div class="wrapper_question wrapp_manager_question_${nmbrQuestion}  mb-2">
			<div id="question_${nmbrQuestion}" class="border px-4 py-3">
				<div class="form-group">					
					<label class="counter_question font-weight-bold" for="inputName_${wrapAns}">Pregunta ${nmbrQuestion}:</label>
					<textarea class="form-control question_text" rows="3" cols="50" id="inputName_${wrapAns}" placeholder="${placeholderQuestion}"></textarea>
					<input type="hidden" class="question_number" value="${nmbrQuestion}">
					<div class="wrapper_anws_${wrapAns}">
						<div class="form-row border mx-0 mt-2 py-2 px-4 item_answer">
							<div class="col-md-2 custom-checkbox d-flex align-items-center is_correct_response">
								<input type="checkbox" class="custom-control-input response_iscorrect" id="customCheck_${ans_id}">
								<label class="custom-control-label ml-3" for="customCheck_${ans_id}">Correcta</label>
							</div>
							<div class="col-md-8 text_response">
								<label for="inputName_${ans_id}">Respuesta: 1</label>
								<textarea id="inputName_${ans_id}" class="form-control response_text" placeholder="${placeholderAnswers}" cols="10" rows="1"></textarea>
							</div>
							<div class="col-md-2 d-flex align-items-center pt-2">
								<button type="button" class="btn btn-sm btn-outline-danger delete-answer-btn">Eliminar respuesta</button>
							</div>
						</div>
					</div>
				</div>
				<div class="form-group d-flex justify-content-end">
					<button type="button" onclick="addItemQuestion('${wrapAns}')" class="btn btn-info btn-sm addresponse-btn-edit">Agregar respuesta</button>
				</div>
			</div>
		</div>
		<div class="form-group d-flex justify-content-end">
			<button type="button" onclick="deleteQuestion(${nmbrQuestion})" class="btn btn-outline-danger btn-sm ">Eliminar pregunta</button>
		</div>
	`)
	jQuery('.question_text').focus()
 }

