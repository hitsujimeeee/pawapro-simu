/*jslint browser: true, jquery: true*/
/*jslint shadow:true*/

$(function() {
	var cond = sessionStorage.getItem('deckSearchCond');
	var searchDeata = sessionStorage.getItem('deckSearchData');

	if (cond) {
		cond = JSON.parse(cond);
		$('#deckName').val(cond.deckName);
		$('#targetType').val(cond.targetType);
		$('#school').val(cond.school);
		$('#evChara').val(cond.evChara);
		$('#authorName').val(cond.author);
		$('#twitterId').val(cond.twitterId);
		$('#sortOrder').val(cond.sortOrder);
		$('#sortDir').val(cond.sortDir);
		$('#favCheck').prop("checked", cond.favCheck);
		$('#pageNum').html(cond.pageNum);
		$('#totalPageNum').html(cond.totalPageNum);
	}

	if (searchDeata) {
		deckSearch.drawDeckList(JSON.parse(searchDeata));
		$('.newInfo').addClass('hiddenDisplay')
	} else {
		deckSearch.search(true);
		$('.newInfo').removeClass('hiddenDisplay')
	}

	$('#searchCond').on('hide', function() {
		$('#acordionHeader .closeIcon').removeClass('fa-chevron-circle-down').addClass('fa-chevron-circle-up');
	});

});


var deckSearch = {

	getSearchData: function() {
		return {
			deckName: $('#deckName').val(),
			targetType: Number($('#targetType').val()),
			school: Number($('#school').val()),
			evChara: $('#evChara').val(),
			author:$('#authorName').val(),
			twitter:$('#twitterId').val(),
			sortOrder: $('#sortOrder').val(),
			sortDir: $('#sortDir').val(),
			favCheck: $('#favOnly').prop('checked'),
			pageNum: 0
		};
	},

	reset: function() {
		$('#deckName').val('');
		$('#targetType').val(0);
		$('#school').val(0);
		$('#evChara').prop('selectedIndex', 0);
		$('#authorName').val('');
		$('#twitterId').val('');
		$('#sortOrder').prop('selectedIndex', 0);
		$('#sortDir').prop('selectedIndex', 0);
		$('#favOnly').prop('checked', false);
		sessionStorage.removeItem('deckSearchCond');
		sessionStorage.removeItem('deckSearchData');
		document.querySelector('#deckList').innerHTML = '';
		$('.pageDisplay').css('display', 'none');
		$('.newInfo').addClass('hiddenDisplay');
	},

	search: function(newFlag) {
		var inputData = deckSearch.getSearchData();
		var sendData = inputData;
		sendData.userName = $('#loginUserName').val();
		sendData.password = $('#loginPassword').val();
		$.blockUI({
			message: '<div><i class="fa fa-spinner fa-pulse fa-fw"></i>読み込み中……</div>',
			css:{'width':'80%'}
		});
		$.ajax({
			type: 'POST',
			url: './logic/search.php',
			timeout: 10000,
			data: sendData,
		}).done(function(data) {
			ga('send', 'event', 'action', 'click', 'deckSearch');
			deckSearch.drawDeckList(data.list);
			$.unblockUI();


			if(newFlag == null || newFlag !== true) {
				sessionStorage.setItem('deckSearchData', JSON.stringify(data.list));
				inputData.favCheck = $('#favOnly').prop('checked');
				inputData.pageNum = 1;
				inputData.totalPageNum = parseInt((data.count-1)/10+1);
				sessionStorage.setItem('deckSearchCond', JSON.stringify(inputData));
				// 移動先を数値で取得
				var position = $('#deckArea').offset().top;
				// スムーススクロール
				$('body,html').animate({scrollTop:position}, 400, 'swing');
				$('.newInfo').addClass('hiddenDisplay')
				$('#totalPageNum').html(parseInt((data.count-1)/10+1));
			} else {
				$('#totalPageNum').html(1);
			}

			$('#pageNum').html(1);



		}).fail(function(res) {
			$.unblockUI();
		});
	},

	drawDeckList: function(data) {
		var str = '';
		var favList = localStorage.getItem('favoriteList');
		var favCheck = $('#favOnly').prop('checked');
		var rarelityGraphList = ['SR', 'SR', 'SR', 'R', 'R', 'R', 'R'];
		if(data.length === 0) {
			$('.noResult').removeClass('hiddenDisplay');
			$('.pageDisplay').css('display', 'none');
		} else {
			$('.noResult').addClass('hiddenDisplay');
			$('.pageDisplay').css('display', 'flex');
		}

		if(favList) {
			favList = JSON.parse(favList);
		}
		for (var i = 0; i < data.length; i++) {
			var d = data[i];

			if (favCheck && favList && favList.length > 0 && favList.indexOf(d.id) < 0) {
				continue;
			}

			str += '<li class="deckList"><a href="./deckCreator.php?userId=' + d.userId + '&deckId=' + d.id + '">' +
				'<div class="deckHeader"><h3>' + d.name + '　</h3><p class="authorName">作者:' + d.author + (d.twitterId ? '(@' + d.twitterId + ')' : '' ) + '</p></div>' +
				'<div class="deckDetail">';
			for (var j = 0; j < d.chara.length; j++) {
				str += '<div class="evCharaContainer">' +
					'<img class="eveChara" onerror="this.src=\'../img/noface.jpg\';" class="eveChara" src="../img/eventChara/' + (d.chara[j] ? rarelityGraphList[d.rare[j]] + '/' + d.chara[j] + '.jpg' : 'noimage.jpg') + '">';
				if (Number(d.rare[j]) === 1) {
					str += '<img class="rarelityBadge" src="../img/icon/PSR_icon.png">';
				} else if (Number(d.rare[j]) === 3) {
					str += '<img class="rarelityBadge" src="../img/icon/PR_icon.png">';
				} else if (Number(d.rare[j]) === 5) {
					str += '<img class="rarelityBadge" src="../img/icon/PN_icon.png">';
				} else if (Number(d.rare[j]) === 6) {
					str += '<img class="rarelityBadge" src="../img/icon/N_icon.png">';
				}
				str += '</div>';
			}
			str += '</div>' +
				'<div class="deckTraining">';
			for (var j = 0; j < 10; j++) {
				str += '<div class="trainingCell"><img class="trainingIcon' + (d.training[j] > 0 ? ' nonOpacity' : '') + '" src="../img/practice' + j + '.jpg">';
				if (d.training[j] > 1) {
					str += '<div class="countNum">×' + d.training[j] + '</div>';
				}
				str += '</div>';
			}
			str += '</div>';
			str += '<div class="deckOption">';
			str += '<span class="viewDeckType">' + d.targetType + '</span>';
			str += '<span class="viewSchoolType">' + d.school + '</span>';
			str += Number(d.favCount) > 0 ? '<span class="viewFavCount"><i class="fa fa-heart"></i>' + d.favCount + '</span>' : '';
			str += '</div>';
			str += '</a></li>';
		}
		var disp = document.querySelector('#deckList');
		disp.innerHTML = '';
		disp.insertAdjacentHTML('beforeend', str);
	},

	sendPage: function(send) {

		var cond = sessionStorage.getItem('deckSearchCond');
		var pageNum = Number($('#pageNum').text());
		var totalPageNum = Number($('#totalPageNum').text());
		var newPageNum = pageNum + send;
		if(newPageNum <= 0 || newPageNum > totalPageNum) {
			return;
		}


		if (!cond) {
			return;
		}
		var sendData = JSON.parse(cond);
		sendData.userName = $('#loginUserName').val();
		sendData.password = $('#loginPassword').val();
		sendData.pageNum = newPageNum - 1;
		$.blockUI({
			message: '<div><i class="fa fa-spinner fa-pulse fa-fw"></i>読み込み中……</div>',
			css:{'width':'80%'}
		});
		$.ajax({
			type: 'POST',
			url: './logic/search.php',
			timeout: 10000,
			data: sendData,
		}).done(function(data) {
			ga('send', 'event', 'action', 'click', 'pageScroll');
			deckSearch.drawDeckList(data.list);
			$('#pageNum').html(newPageNum);
			sendData.pageNum = newPageNum;
			$('#totalPageNum').html(parseInt((data.count-1)/10+1));
			sessionStorage.setItem('deckSearchData', JSON.stringify(data.list));
			sessionStorage.setItem('deckSearchCond', JSON.stringify(sendData));
			// 移動先を数値で取得
			var position = $('#deckArea').offset().top;
			// スムーススクロール
			$('body,html').animate({scrollTop:position}, 400, 'swing');
			$.unblockUI();
		}).fail(function(res) {
			$.unblockUI();
		});
	}

};
