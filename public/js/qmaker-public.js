(function( $ ) {
	'use strict';

	/**
	 * All of the code for your public-facing JavaScript source
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
	
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */
	$( window ).load(function() {
		var $itemAnswer = $('.ans_item')
		var $itemOptionAnswer = $('.item-option')
		$itemAnswer.on('click', function(){
			$(this).attr( 'checked', true )
		})
		$itemOptionAnswer.on('click', function(){
			var btnCheck = '#btn-check_'+$(this).data('question')
			$(btnCheck).removeClass('d-none')
		})


		var $btncheckAnswer = $('.btn-check-anws')
		$btncheckAnswer.on('click', function(){
			var idQuestion = '.question_' + $(this).data('question')
			var btnNext = '#btn-next_' + $(this).data('question')
			$(btnNext).removeClass('d-none')
			$(idQuestion).each(function() {
				var answser = $(this).find('.ans_item')
				// console.log(answser.is(":checked"))
				
				if( !$(answser).parent().hasClass('evaluated') && answser.is(":checked")){
					if(answser.val() == 1){
						console.log('Respuesta correcta!')
						$(answser).next().addClass('correct-answer')
						$(answser).parent().next().removeClass('d-none')
						var corrects = Number($('.correct-answers').val()) + 1
						$('.correct-answers').val(corrects)
					}else{
						console.log('Respuesta incorrecta')
						$(answser).next().addClass('incorrect-answer')
						var incorrects = Number($('.incorrect-answers').val()) + 1
						$('.incorrect-answers').val(incorrects)
					}
				}
				$(answser).parent().addClass('evaluated')
			})
		})

		var $btnNextQuestion = $('.btn-next-question')
		$btnNextQuestion.on('click', function(){
			var cardQuestionToShow = '#card-question_' + ($(this).data('number-question') + 1)
			var cardQuestionToHide = '#card-question_' + $(this).data('number-question')
			$(cardQuestionToHide).addClass('invisible')
			$(cardQuestionToShow).removeClass('invisible')
		})
		var $btnPrevQuestion = $('.btn-prev-question')
		$btnPrevQuestion.on('click', function(){
			var cardQuestionToShow = '#card-question_' + ($(this).data('number-question') - 1)
			var cardQuestionToHide = '#card-question_' + $(this).data('number-question')
			$(cardQuestionToHide).addClass('invisible')
			$(cardQuestionToShow).removeClass('invisible')
		})
		var $btnShowResult = $('.btn-show-results')
		$btnShowResult.on('click', function(){
			var cardQuestionToHide = '#card-question_' + $(this).data('number-question')
			var ttlQuestions = $(this).data('number-question')
			var corrects = $('.correct-answers').val()
			var incorrects = $('.incorrect-answers').val()
			var score = (10 * corrects) / ttlQuestions
			$(cardQuestionToHide).addClass('invisible')

			$('.show-results-text').empty()
			$('.show-results-text').append(`
				Tuviste <strong>${corrects}</strong> respuestas correctas y <strong>${incorrects} </strong> incorrectas, 
				tu calificación final es de <strong>${score.toFixed(2)}</strong>
			`)
			$('.card-results').removeClass('invisible')
		})
		var $btnResetQuiz = $('.btn-reset-quiz')
		$btnResetQuiz.on('click', function(){
			$itemOptionAnswer.each(function(){
				$(this).find('.ans_item').attr( 'checked', false )
				$(this).find('.ans_item').next().removeClass('incorrect-answer')
				$(this).find('.ans_item').next().removeClass('correct-answer')
				$(this).next().addClass('d-none')
				$(this).find('.ans_item').parent().removeClass('evaluated')
			})
			$('.correct-answers').val(0)
			$('.incorrect-answers').val(0)
			$('.card-results').addClass('invisible')
			$('#card-question_1').removeClass('invisible')
			
			$('.btn-next-ctrl_1').addClass('d-none')
		})
	});

	
})( jQuery );
