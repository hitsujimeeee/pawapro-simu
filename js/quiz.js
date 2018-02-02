/* jshint jquery:true */
/* jshint browser:true */

$(function(){
	quiz.fetchQuiz();
});


var quiz = {

	quizStock: [],
	quizDone: [],
	result: [],

	fetchQuiz: function() {

		$.get({
			url: './logic/getQuiz.php',
			timeOut: 30000,
		}).done(function(data){
			quiz.quizStock = JSON.parse(data);
			quiz.updateDisplay();
		});

	},

	updateDisplay: function() {
		var q = quiz.quizStock.pop();
		quiz.quizDone.push(q);
		var str;

		$('#contentsArea').html('<div>問' + quiz.quizDone.length + '. ' + quiz.escape_html(q.CONTENT) + '</div>');

		if (q.IMAGE === 1) {
			str = '<div class="contentImageArea"><img src="../img/quiz/' + q.ID + '.jpg"></div>';
			$('#contentsArea').html($('#contentsArea').html() + str);
		}
		$('#contentsArea').html($('#contentsArea').html() + '<div class="contentPercent">★' + q.CATEGORY + '<br>全体正答率' + Math.round(q.PERCENT) + '%</div>');

		str = '';

		for (var i = 0; i < q.OPTIONS.length; i++) {
			if (i % 2 === 0) {
				str += '<div class="optionContainer">';
			}

			if (q.OPTIONS[i]) {
				str += '<div class="conItem"><button onclick="quiz.answer(' + (i + 1) + ')">' + quiz.escape_html(q.OPTIONS[i]) + '</button></div>';
			}

			if (i % 2 === 1) {
				str += '</div>';
			}
		}

		$('#optionArea').html(str);

	},

	answer: function(n){
		var q = quiz.quizDone[quiz.quizDone.length-1];

		if (q.ANSWER === n) {
			quiz.result.push(1);
		} else {
			quiz.result.push(0);
			$('#optionArea button').eq(n-1).addClass('faild');
		}

		$('#optionArea button').eq(q.ANSWER-1).addClass('correct');

		$.post({
			url: './logic/updateQuizRecord.php',
			data: {id: q.ID, result: q.ANSWER === n ? 1 : 0},
			timeout: 5000
		});

		$('#optionArea button').prop('disabled', true);

		$('#ansResult').html('<span class="ansResultMark ' + (q.ANSWER === n ? 'ansCorrect' : 'ansFailed') + '">' + (q.ANSWER === n ? '正解': '不正解') + '</span>');


		$('#commentText').html('解説：<br>' + (quiz.escape_html(q.COMMENTS) || 'この問題の解説はありません。'));
		var str = '';
		str = q.USER_NAME || q.TWITTER_ID || '名無しさん';
		if (q.TWITTER_ID) {
			str = '<a onclick="ga(\'send\', \'event\', \'link\', \'click\', \'quizTwitter\')" href="https://twitter.com/' + quiz.escape_html(q.TWITTER_ID) + '" target="_blank">' + quiz.escape_html(str) + '</a>';
		} else {
			str = quiz.escape_html(str);
		}

		$('#commentText').html($('#commentText').html() + '<br><br>作者：' + str);
		$('.commentArea, .voteArea, .voteArea > *').removeClass('hiddenDisplay');
		$('.voteResult').addClass('hiddenDisplay');

		$('.nextButton').css('visibility', 'visible');
		$('#restQuizCounter').css('visibility', 'visible');


		if (quiz.quizStock.length === 0) {
			$('.nextButton').html('結果確認');
			$('#restQuizCounter').html('');
		} else {
			$('#restQuizCounter').html('残り' + quiz.quizStock.length + '問');
		}

	},

	next: function() {
		if (quiz.quizStock.length === 0) {
			var idList = quiz.quizDone.map(function(elt){
				return elt.ID;
			});
			var paramStr = $.param({idList: idList, result: quiz.result});
			location.href = "./quizResult.php?" + paramStr;
		} else {
			$('.nextButton').css('visibility', 'hidden');
			$('#restQuizCounter').css('visibility', 'hidden');
			$('#optionArea button').removeClass('correct, faild');
			$('.commentArea').addClass('hiddenDisplay');
			$('body').animate({scrollTop: 0}, 200);
			quiz.updateDisplay();
		}
	},

	escape_html: function(string) {
		if(typeof string !== 'string') {
			return string;
		}
		return string.replace(/[&'`"<>]/g, function(match) {
			return {
				'&': '&amp;',
				"'": '&#x27;',
				'`': '&#x60;',
				'"': '&quot;',
				'<': '&lt;',
				'>': '&gt;',
			}[match];
		}).replace(/\r?\n/g, '<br>');
	},

	vote: function(f) {
		var q = quiz.quizDone[quiz.quizDone.length-1];
		$.post({
			url: './logic/voteQuizRecord.php',
			data: {id: q.ID, voteFlag: f},
			timeOut: 5000
		}).done(function(data){
			console.log(data);
		});

		$('.voteArea, .voteArea > *').addClass('hiddenDisplay');
		$('.voteResult').removeClass('hiddenDisplay');
		$('.voteResult').html('<i class="fa fa-thumbs-o-up"></i>' + (q.VOTE_GOOD+f) + '　<i class="fa fa-thumbs-o-down"></i>' + (q.VOTE_BAD + ((f+1)%2)));
	}
};
