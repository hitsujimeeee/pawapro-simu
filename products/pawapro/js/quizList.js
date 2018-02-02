/* jshint jquery:true */
/* jshint browser:true */

$(function(){
	$.get({
		url: './logic/getQuizPageCount.php'
	}).done(function(count){
		count = parseInt(count, 10) + 1;
		$('.pageDisplay').pagination({
			items:count,
			displayedPages: 3,
			cssStyle: 'light-theme',
			prevText: '<i class="fa fa-arrow-left"></i>',
			nextText: '<i class="fa fa-arrow-right"></i>',
			onPageClick: function(pageNum) {quizList.updateQuizPage(pageNum-1);}
		});
		quizList.updateQuizPage(0);
	});
});




var quizList = {

	updateQuizPage: function(n){
		$.post({
			url: './logic/getQuizList.php',
			data: {'pageNum': n}
		}).done(function(data){
			quizList.drawQuizList(JSON.parse(data));
		}).fail(function(data){
			console.log(data);
		});
	},

	drawQuizList: function(data) {
		var str = '';

		for (var i= 0; i < data.length; i++) {
			var d = data[i];
			str += '<li><div class="contentContainer"><div class="contentsArea">';

			str += '<div>No.' + d.ID + (d.FIXED_FLAG === '0' ? '[承認待ち]' : '') + '</div>';
			str += '<div>' + quizList.escape_html(d.CONTENT) + '</div>';

			if (d.IMAGE === 1) {
				str += '<div class="contentImageArea"><img src="../img/quiz/' + d.ID + '.jpg"></div>';
			}

			str += '<div>';

			for (var j =0; j < d.OPTIONS.length; j++){
				str += (j+1) + '. ' + quizList.escape_html(d.OPTIONS[j]) + '<br>';
			}

			str +='</div>';

			str += '</div>';

			str += '<div class="contentOtherInfo">';

			str += '<div>';
			var name = d.USER_NAME || d.TWITTER_ID || '名無しさん';
			if (d.TWITTER_ID) {
				str += '作者：<a onclick="ga(\'send\', \'event\', \'link\', \'click\', \'quizTwitter\')" href="https://twitter.com/' + quizList.escape_html(d.TWITTER_ID) + '" target="_blank">' + quizList.escape_html(name) + '</a>';
			} else {
				str += '作者：' + quizList.escape_html(name);
			}


			str += '</div>';
			str += '<div class="voteInfo">';
			str += '<i class="fa fa-thumbs-o-up"></i>' + d.VOTE_GOOD + '　<i class="fa fa-thumbs-o-down"></i>' + d.VOTE_BAD;

			str += '</div>';

			str += '</div>';
			str += '</div></li>';
		}

		$('#quizList').html(str);
		$('body').animate({scrollTop: 0}, 200);


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

};

