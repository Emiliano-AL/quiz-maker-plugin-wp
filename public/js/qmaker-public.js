(function( $ ) {
	'use strict';

	$( window ).load(function() {
		var $itemAnswer = $('.ans_item')
		var $itemOptionAnswer = $('.item-option')
		$itemAnswer.on('click', function(){
			$(this).attr( 'checked', true )
		})
		$itemOptionAnswer.on('click', function(){
			if(!jQuery(this).hasClass('evaluated')){
				var btnCheck = '#btn-check_'+$(this).data('question')
				$(btnCheck).removeClass('d-none')
			}
		})


		var $btncheckAnswer = $('.btn-check-anws')
		$btncheckAnswer.on('click', function(){
			var idQuestion = '.question_' + $(this).data('question')
			var btnNext = '#btn-next_' + $(this).data('question')
			var btnShowResults = '#btn-show-result_' + $(this).data('question')	
			// $(btnNext).addClass
			var isOptionSlctd = false
			$(idQuestion).each(function() {
				var item = $(this).find('.ans_item')
				if( item.is(":checked")){
					isOptionSlctd = true
				}
			})
			var alertMsg = '.msg-alert_' + $(this).data('question')
			if(isOptionSlctd){
				$(alertMsg).append(``)
				$(alertMsg).addClass('d-none')
				$(alertMsg).removeClass('alert-danger')

				$(btnNext).removeClass('d-none')
				$(btnShowResults).removeClass('d-none')
				$(idQuestion).each(function() {
					var answser = $(this).find('.ans_item')
					answser.attr('disabled', true)
					if( !$(answser).parent().hasClass('evaluated') && answser.is(":checked")){
						if(answser.val() == 1){
							var corrects = Number($('.correct-answers').val()) + 1
							$('.correct-answers').val(corrects)
							$('.correct-answers').val(corrects)
							$(answser).next().addClass('correct-answer')
							$(answser).parent().next().removeClass('d-none')
						}else{
							var incorrects = Number($('.incorrect-answers').val()) + 1
							$('.incorrect-answers').val(incorrects)
							console.info('QUIZM: incorrects', incorrects)
							$(answser).next().addClass('incorrect-answer')
							$(answser).parent().next().removeClass('d-none')
							$(idQuestion).each(function() {
								if($(this).children('label').hasClass('qm-answers-correct')){
									$(this).children('label').children('span').addClass('correct-answer')
									// $(this).children('i').removeClass('d-none')
								}
							})
						}
					}
					$(answser).parent().addClass('evaluated')
				})
				$(this).addClass('d-none')
			}else{
				$(alertMsg).append(`Debes seleccionar al menos una respuesta.`)
				$(alertMsg).removeClass('d-none')
				$(alertMsg).addClass('alert-danger')
			}
		})

		var $btnNextQuestion = $('.btn-next-question')
		$btnNextQuestion.on('click', function(){
			var cardQuestionToShow = '#card-question_' + ($(this).data('number-question') + 1)
			var cardQuestionToHide = '#card-question_' + $(this).data('number-question')
			$(cardQuestionToHide).addClass('invisible-qm')
			$(cardQuestionToShow).removeClass('invisible-qm')
		})
		var $btnPrevQuestion = $('.btn-prev-question')
		$btnPrevQuestion.on('click', function(){
			var cardQuestionToShow = '#card-question_' + ($(this).data('number-question') - 1)
			var cardQuestionToHide = '#card-question_' + $(this).data('number-question')
			$(cardQuestionToHide).addClass('invisible-qm')
			$(cardQuestionToShow).removeClass('invisible-qm')
		})
		var $btnShowResult = $('.btn-show-results')
		$btnShowResult.on('click', function(){
			var cardQuestionToHide = '#card-question_' + $(this).data('number-question')
			var ttlQuestions = $(this).data('number-question')
			var corrects = $('.correct-answers').val()
			var incorrects = $('.incorrect-answers').val()
			var score = (10 * corrects) / ttlQuestions
			$(cardQuestionToHide).addClass('invisible-qm')
			console.log('Respuestas: ', corrects, ttlQuestions)
			if(Number(corrects) === ttlQuestions){
				console.log('Todo bien: ', corrects, ttlQuestions)
				$('.btn-reset-quiz').addClass('d-none')
				$('.alert-msg-qm').removeClass('d-none')
			}
			$('.show-results-text').empty()
			$('.show-results-text').append(`
				Tuviste <strong>${corrects}</strong> respuestas correctas y <strong>${incorrects} </strong> incorrectas, 
				tu calificación final es de <strong>${score.toFixed()}</strong>
			`)
			$('.card-results').removeClass('invisible-qm')
		})
		var $btnResetQuiz = $('.btn-reset-quiz')
		$btnResetQuiz.on('click', function(){
			$itemOptionAnswer.each(function(){
				$(this).find('.ans_item').attr( 'checked', false )
				$(this).find('.ans_item').attr( 'disabled', false )
				$(this).find('.ans_item').next().removeClass('incorrect-answer')
				$(this).find('.ans_item').next().removeClass('correct-answer')
				$(this).next().addClass('d-none')
				$(this).find('.ans_item').parent().removeClass('evaluated')
			})
			$('.correct-answers').val(0)
			$('.incorrect-answers').val(0)
			$('.card-results').addClass('invisible-qm')
			$('#card-question_1').removeClass('invisible-qm')

			$('.btn-check-anws').removeClass('d-none')

			$('.btn-next-ctrl_1').addClass('d-none')
			$('.btn-directions-next').addClass('d-none')
			$('.btn-directions-show-results').addClass('d-none')
			//TODO: También se debe agregar las clases d-none a los bts que estaban ocultos
			for(let i = 1; i <= $(this).data('total-questions'); i++){
				let wrap_question = '.question_wrap_'+i

				var $nodes = $(wrap_question).find('li');
				shuffle($nodes, 'li-option');
				$(wrap_question).append($nodes);
			}
			// var wrapQuestion = 'card-question_' + $(this).data('total-questions')
		})
	});

	
})( jQuery );

//http://jsfiddle.net/serendipity/Xz6BJ/
function shuffle(nodes, switchableSelector) {
    var length = nodes.length;
    //Create the array for the random pick.
    var switchable = nodes.filter("." + switchableSelector);
    var switchIndex = [];
    jQuery.each(switchable, function(index, item) {
       switchIndex[index] = jQuery(item).index(); 
    });
    //The array should be used for picking up random elements.
    var switchLength = switchIndex.length;
    var randomPick, randomSwap;
    for (var index = length; index > 0; index--) {
        //Get a random index that contains a switchable element.
        randomPick = switchIndex[Math.floor(Math.random() * switchLength)];
        //Get the next element that needs to be swapped.
        randomSwap = nodes[index - 1];
        //If the element is 'switchable' continue, else ignore
        if(jQuery(randomSwap).hasClass(switchableSelector)) {
            nodes[index - 1] = nodes[randomPick];
            nodes[randomPick] = randomSwap;
        }
    }
    return nodes;
}