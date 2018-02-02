/* jshint jquery:true */
/* jshint browser:true */

$(function(){

	$('#sendFile').on('change', function(e){
		quizMake.setPreviewImage(e);
	});

	$('#show_dialog').dialog({
		autoOpen: false,
		modal: true,
		show: "clip",
		hide: "fade",
		buttons: {
			"OK": function(){
				$('#show_dialog').dialog("close");
				quizMake.registQuiz();
			},
			"キャンセル": function(){
				$('#show_dialog').dialog("close");
			}
		}
	});

//	$('#makeContents').val('テスト');
//	$('.makeOption').eq(0).val('選択肢1');
//	$('.makeOption').eq(1).val('選択肢2');
//	$('.makeOption').eq(2).val('選択肢3');
//	$('.makeOption').eq(3).val('選択肢4');
//	$('#makeAnswer').val(2);
//	$('#makeCategory').val(3);
//	$('#makeComment').val('コメント');
//	$('#makeUserName').val('羊');
//	$('#makeTwitter').val('hitsujiPawapro');


});



var quizMake = {

	confirmSubmit: function() {
		var data = quizMake.getInputData();

		var errorMessage = [];

		if (data.content === '' || data.content.length > 200) {
			errorMessage.push('問題文は1文字以上200文字以内で入力してください。');
		}

		for(var i = 0; i < data.options.length; i++) {
			if (data.options[i] === '' || data.options[i].length > 40) {
				errorMessage.push('選択肢は1文字以上40文字以内で入力してください。');
				break;
			}
		}

		if (data.comment.length > 300) {
			errorMessage.push('解説は300文字までです。');
		}
		if (data.userName.length > 200) {
			errorMessage.push('考案者名は30文字までです。');
		}
		if (data.twitter.length > 200) {
			errorMessage.push('TwitterIDは15文字までです。');
		}

		if (errorMessage.length === 0) {
			$('#show_dialog').dialog("open");
		} else {
			quizMake.showBlockMessage('<i class="fa fa-times" style="color:#f00"></i>' + errorMessage.join('<br>'), true);
		}
	},

	registQuiz: function(){
		var data = quizMake.getInputData();

		quizMake.showBlockMessage('<i class="fa fa-spinner fa-spin"></i>処理中……', false);


		var fd = new FormData($('#sendForm').get(0));
		fd.append('content', encodeURI(data.content));
		fd.append('option1', encodeURI(data.options[0]));
		fd.append('option2', encodeURI(data.options[1]));
		fd.append('option3', encodeURI(data.options[2]));
		fd.append('option4', encodeURI(data.options[3]));
		fd.append('answer', data.answer);
		fd.append('category', data.category);
		fd.append('comment', encodeURI(data.comment));
		fd.append('userName', encodeURI(data.userName));
		fd.append('twitter', encodeURI(data.twitter));

		$.post({
			url: './logic/registQuizRecord.php',
			data: fd,
			processData: false,
			contentType: false,
			dataType: 'json'
		}).done(function(data){
			switch(data.status){
				case 0:
					location.href = './quizRegistComplete.php';
					break;
				case -1:
					$.unblockUI();
					quizMake.showBlockMessage('<i class="fa fa-times" style="color:#f00"' + data.msg, true);
					break;
			}
		}).fail(function(data){
			$.unblockUI();
			quizMake.showBlockMessage('<i class="fa fa-times" style="color:#f00"' + data.msg, true);
		});
	},

	getInputData: function() {
		return {
			content: $('#makeContents').val(),
			options: $('.makeOption').map(function(){
				return $(this).val();
			}).get(),
			answer: $('#makeAnswer').val(),
			category: $('#makeCategory').val(),
			comment: $('#makeComment').val(),
			userName: $('#makeUserName').val(),
			twitter: $('#makeTwitter').val()
		};
	},

	setPreviewImage: function(e) {
		var file = e.target.files[0],
			reader = new FileReader(),
			preview = $('#contentImage');
		if(file === void 0) {
			preview.attr('src', '');
			return false;
		}

		if(!~file.type.indexOf('image')) {
			preview.attr('src', '');
			alert('ファイル形式が不正です。');
			return false;
		}

		reader.onload = (function() {
			return function(e) {
				preview.attr('src', e.target.result);
			};
		})(file);
		reader.readAsDataURL(file);
	},

	showBlockMessage: function (msg, closeable) {
		$.blockUI({
			message: msg,
			css:{
				border: 'none',
				padding: '15px',
				left: '10%',
				width:'80%',
				'-webkit-border-radius': '10px',
				'-moz-border-radius':'10px',
				opacity: '.8',
				color:'#000',
				'font-size':'1em'
			}
		});
		if (closeable) {
			$('.blockOverlay').click($.unblockUI).on('click', $.unblockUI);
			setTimeout($.unblockUI, 3000);
		}
	}


};
