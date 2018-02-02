/*jslint browser: true, jquery: true */
/* global savedCharaList, savedMakedCharaList, mode, Clipboard, History */
/*jslint shadow:true*/

$(function () {

//	$('.js-replace-no-image').error(function() {
//		$(this).attr({
//			src: '/img/noface.jpg',
//			alt: 'no image'
//		});
//	});
	var clipboard = new Clipboard('#copyText');
	clipboard.on('success', function(e) {
		e.clearSelection();
		alert('クリップボードにコピーしました。');
	});
	clipboard.on('error', function(e) {
		e.clearSelection();
		alert('ご使用のブラウザではコピーできません。');
	});

	$('#ui-tab').tabs();

	$(document).on('closing', '#eveCharaRemodal', function () {
		deckCreator.ConfirmRemodal();
	});

	$(document).on('closing', '#makedCharaRemodal', function () {
		deckCreator.setMakedCharacter();
	});



	$('.charaLv').on('change', function () {
		var idx = $('.charaLv').index(this);
		if (idx < deckCreator.selectedCharaList.length) {
			if (Number(this.value) > 50) {
				this.value = '';
			} else {
				deckCreator.selectedCharaList[idx].lv = Number(this.value);
			}
		}
	});

	$('.rareRank').on('change', function () {
		var idx = $('.rareRank').index(this);
		if (idx < deckCreator.selectedCharaList.length) {
			deckCreator.selectedCharaList[idx].rare = Number(this.value);
		}
	});

	$('.eveCharaListItem').click(deckCreator.clickEveCharaList);

	var setRestTextCount = function () {
		if (!$('#summary').length) {
			return;
		}
		var count = $('#summary').val().length;
		$('#restTextCount').text(500 - count);
	};

	$('#summary').on('keydown', setRestTextCount);
	$('#summary').on('change', setRestTextCount);

	setRestTextCount();
	deckCreator.init();

	//選択済みのイベキャラの得意練習画像を画面に反映
	(function(){
		var list = deckCreator.selectedCharaList;
		var evTypeStr = ['Before', 'After'];
		for (var i = 0; i < list.length; i++) {
			if (list[i]) {
				var obj = $('.eveCharaListItem').filter(function() {
					return list[i].id ===  '' + $(this).data('charaId');
				});
				var trainingType = obj.data('trainingType');
				var eventType = Number(obj.data('eventType'));
				if (trainingType) {
					$('.eveImageArea img.trainingIcon').eq(i).removeClass('hiddenDisplay').attr('src', '../img/practice' + trainingType + '.jpg');
				}
				$('.charaLv').eq(i).addClass('colorEventType' + evTypeStr[eventType]);
				$('.rareRank').eq(i).addClass('colorEventType' + evTypeStr[eventType]);
			}
		}

	})();


	$.ajax({
		url:'./logic/getFavoriteList.php',
		type:'POST',
		data:{
			userName: $('#loginUserName').val(),
			password: $('#loginPassword').val()
		}
	}).done(function(res) {
		var list = localStorage.getItem('favoriteList');
		list = list ? JSON.parse(list) : [];
		if(res) {
			res = JSON.parse(res);
			Array.prototype.push.apply(list, res.filter(function(elt){
				return list.indexOf(elt) === -1;
			}));
		}
		localStorage.setItem('favoriteList', JSON.stringify(list));
		$('#favButton').attr('data-fav-status', list.indexOf($('#deckId').val()) >= 0 ? 1 : 0);
	}).fail(function(res) {
	});


	if(mode === 1) {
		$('#gameId').val($('#loginPawaproId').val());
		$('#twitterId').val($('#loginTwitterId').val());

	}


	var queryStringArray = null;
	if(mode === 3) {
		queryStringArray = deckCreator.GetQueryString();
	}

	$.ajax({
		url:'./getCharacterList.php',
		type:'POST',
		data:JSON.stringify(mode === 3 ? {
			userId: queryStringArray.userId
		} : {
			name: $('#loginUserName').val(),
			password: $('#loginPassword').val()
		})
	}).done(function(data) {
		deckCreator.makedCharaList = data.data.charaList;
		deckCreator.setMakedCharacterList(data);
	}).fail(function(res) {
	});

});


var deckCreator = {
	selectedCharaList: [],
	makedCharaList: null,

	init: function () {
		for (var i = 0; i < savedCharaList.length; i++) {
			deckCreator.selectedCharaList[i] = savedCharaList[i];
		}
	},

	openRemodal: function () {
		$.remodal.lookup[$('[data-remodal-id=eveCharaRemodal]').data('remodal')].open();
	},

	ConfirmRemodal: function () {
		deckCreator.updateEveCharaList();
		$.remodal.lookup[$('[data-remodal-id=eveCharaRemodal]').data('remodal')].close();
	},

	updateEveCharaList : function() {
		var list = deckCreator.selectedCharaList;
		var rateGraphList = ['SR', 'SR', 'SR', 'R', 'R', 'R', 'R'];
		var f1 = function(){
			return list[i].id ===  '' + $(this).data('charaId');
		};
		var evTypeStr = ['colorEventTypeBefore', 'colorEventTypeAfter'];

		$('.charaLv, .rareRank').removeClass(evTypeStr.join(' '));

		for (var i = 0; i < 6; i++) {
			var src = '../img/eventChara/';
			if (i <= list.length - 1) {
				var obj = $('.eveCharaListItem').filter(f1);
				var trainingType = obj.data('trainingType');
				var eventType = Number(obj.data('eventType'));
				if (trainingType !== "") {
					$('.eveImageArea img.trainingIcon').eq(i).removeClass('hiddenDisplay').attr('src', '../img/practice' + trainingType + '.jpg');
				}
				$('.charaLv').eq(i).val(list[i].lv).attr('disabled', false).addClass(evTypeStr[eventType]);
				$('.rareRank').eq(i).val(list[i].rare).attr('disabled', false).addClass(evTypeStr[eventType]);
				var rareGraph = $('.rareRank').eq(i).val() != null ? rateGraphList[$('.rareRank').eq(i).val()] : 'SR';
				src += rareGraph + '/' + list[i].id + '.jpg';
			} else {
				src += 'noimage.jpg';
				$('.eveImageArea img.trainingIcon').eq(i).addClass('hiddenDisplay').attr('src', '');
				$('.charaLv').eq(i).val('').attr('disabled', true);
				$('.rareRank').eq(i).val(0).attr('disabled', true);
			}

			$('.eveCharaImg .eveImageArea').eq(i).find('>img').attr('src', src);
		}
	},


	sortEveCharaList: function () {
		var orderList = ['charaId', 'charaRead', 'trainingType'];
		var order = orderList[+$('#sortOrderType').val()];
		var dir = +$('#sortOrderDir').val();
		var limitType = +$('#limitType').val();
		var tag = 'hiddenDisplay';
		var type;
		var items = $('.eveCharaListItem');
		items.sort(function (a, b) {
			var aVal = '' + $(a).data(order);
			var bVal = '' + $(b).data(order);

			if (aVal === bVal) {
				if('' + $(a).data('charaId') > '' + $(b).data('charaId')) {
					if (dir === 0) {
						return 1;
					} else {
						return -1;
					}
				} else {
					if (dir === 0) {
						return -1;
					} else {
						return 1;
					}
				}
			}

			if(dir === 0) {
				if (aVal === '') {
					return 1;
				}
				if (bVal === '') {
					return -1;
				}
				if(aVal > bVal) {
					return 1;
				} else {
					return -1;
				}
			} else {
				if (aVal === '') {
					return -1;
				}
				if (bVal === '') {
					return 1;
				}				if(aVal < bVal) {
					return 1;
				} else {
					return -1;
				}
			}

			return dir === 0 ? aVal >= bVal : bVal >= aVal;
		});


		$('#eveCharaList').html(items);
		$('.eveCharaListItem').click(deckCreator.clickEveCharaList);

		var obj = $('.eveCharaListItem');
		if (limitType === 0) {
			obj.removeClass(tag);
		} else {
			for (var i = 0; i < obj.length; i++) {
				var o = obj.eq(i);
				switch (limitType) {
					case 1:
						type = ""+o.data('charaType');
						if (type.length > 1 && type.split("").indexOf("0") === -1) {
							o.addClass(tag);
						} else if (+type.length === 1 && +type !== 0) {
							o.addClass(tag);
						} else {
							o.removeClass(tag);
						}
						break;
					case 2:
						type = ""+o.data('charaType');
						if (type.length > 1 && type.split("").indexOf("1") === -1) {
							o.addClass(tag);
						} else if (+type.length === 1 && +type !== 1) {
							o.addClass(tag);
						} else {
							o.removeClass(tag);
						}
						break;
					case 3:
						if (+o.data('charaType') !== 2) {
							o.addClass(tag);
						} else {
							o.removeClass(tag);
						}
						break;
					case 4:
						if (+o.data('eventType') !== 0) {
							o.addClass(tag);
						} else {
							o.removeClass(tag);
						}
						break;
					case 5:
						if (+o.data('eventType') !== 1) {
							o.addClass(tag);
						} else {
							o.removeClass(tag);
						}
						break;
				}
			}
		}
	},

	save: function () {
		var validate = deckCreator.validateInput();
		if(validate) {
			alert(validate);
			return;
		}

		var deckData = {};
		deckData.name = $('#deckName').val();

		deckData.chara = [];

		for (var i = 0; i < 6; i++) {
			if (deckCreator.selectedCharaList.length > i) {
				deckData.chara[i] = deckCreator.selectedCharaList[i];
			} else {
				deckData.chara[i] = null;
			}
		}

		deckData.makedChara = [];
		var obj = $('.selectedMakedCharacter');
		for (var i = 0; i < obj.length; i++) {
			deckData.makedChara[deckData.makedChara.length] = obj.eq(i).data('charaid');
		}

		deckData.type = $('#charaType').val();
		deckData.school = $('#school').val();
		deckData.summary = $('#summary').val();
		deckData.author = $('#author').val();
		deckData.gameId = $('#gameId').val();
		deckData.twitterId = $('#twitterId').val();

		deckCreator.showBlockMessage('処理中……');

		$.ajax({
			url: '../php/logic/saveDeck.php',
			type: 'POST',
			data: {
				userName: $('#loginUserName').val(),
				password: $('#loginPassword').val(),
				deckId: $('#deckId').val(),
				deckData: deckData
			}
		}).done(function (res) {
			res.msg = '<i class="fa fa-check" aria-hidden="true" style="color:#00ff00"></i>' + res.msg;
			$('.blockMsg').html(res.msg);
			$('.blockOverlay').click($.unblockUI).on('click', $.unblockUI);
			setTimeout($.unblockUI, 2000);
			if(res.status === -1) {
				return;
			}
			ga('send', 'event', 'action', 'click', 'saveDeck');
			$('#deckId').val(res.deckId);
			var newUrl = deckCreator.setParameter({'userId':res.userId, 'deckId':res.deckId});
			History.replaceState('','',newUrl);
			$('.openURL').html(window.location.href);

		}).fail(function (res) {
			res.msg = '<i class="fa fa-times" aria-hidden="true" style="color:#00ff00"></i>' + res.msg;
			$('.blockMsg').html(res.msg);
			$('.blockOverlay').click($.unblockUI).on('click', $.unblockUI);
		});

	},

	delete: function () {
		if(!$('#deckId').val()) {
			alert('このデッキは削除できません。');
			return;
		}

		if(window.confirm('デッキを削除します。よろしいですか？')){
			deckCreator.showBlockMessage('処理中……');

			$.ajax({
				type:'POST',
				url:'./logic/deleteDeck.php',
				data:{
					userName:$('#loginUserName').val(),
					password:$('#loginPassword').val(),
					deckId:$('#deckId').val()
				}
			}).done(function(res) {
				if(res.status === -1) {
					alert(res.msg);
					return;
				}
				window.location.replace('./deckList.php');
			}).fail(function(res) {
				res.msg = '<i class="fa fa-times" aria-hidden="true" style="color:#00ff00"></i>' + res.msg;
				$('.blockMsg').html(res.msg);
				$('.blockOverlay').click($.unblockUI).on('click', $.unblockUI);
			});
		}
	},

	setFavarite: function () {
		var actFlag = Number($('#favButton').attr('data-fav-status'));
		var method = ['setFavorite', 'deleteFavorite'][actFlag];

		$.ajax({
			url: '../php/logic/' + method + '.php',
			type: 'POST',
			data: {
				userName: $('#loginUserName').val(),
				password: $('#loginPassword').val(),
				deckUserId: $('#userId').val(),
				deckId: $('#deckId').val()
			}
		}).done(function (res) {
			var listStr = localStorage.getItem('favoriteList');
			var list = listStr ? JSON.parse(listStr) : [];
			var deckId = $('#deckId').val();
			switch(res.status) {
				case 0:	//既にお気に入り済み
				case 1: //登録成功
					if (actFlag === 0) {
						if (list.indexOf(deckId) == -1) {
							list.push(deckId);
						}
						$('#favButton').attr('data-fav-status', '1');
					} else {
						var idx = list.indexOf(deckId);
						if (idx >= 0) {
							list.splice(idx, 1);
						}
						$('#favButton').attr('data-fav-status', '0');
					}
					localStorage.setItem('favoriteList', JSON.stringify(list));
					alert(res.msg);
					break;
				case -1: //エラー失敗
					alert('失敗しました');
					break;
			}
		}).fail(function (res) {
		});


	},

	validateInput: function() {
		var validateItem = ['deckName', 'summary', 'author', 'gameId', 'twitterId'];
		for(var i = 0; i < validateItem.length; i++) {
			var item = $('#' + validateItem[i]);
			var max = Number(item.attr('maxlength'));
			var min = Number(item.attr('minlength'));
			var v = item.val();
			if(item.attr('required') != null && v === '') {
				return item.data('formName') + 'を入力してください。';
			}
			if (v !== '' && (v.length > max || v.length < min)) {
				return item.data('formName') + 'は' + (min ? min + '文字以上' : '') + max + '文字以内にしてください。';
			}
		}
		return null;

	},

	//パラメータを設定したURLを返す
	setParameter: function ( paramsArray ) {
		var resurl = '';
		for (var key in paramsArray ) {
			resurl += (resurl.indexOf('?') == -1) ? '?':'&';
			resurl += key + '=' + paramsArray[key];
		}
		return resurl;
	},

	clickEveCharaList: function(){
		var charaId = '' + $(this).data('charaId');
		var idList = deckCreator.selectedCharaList.map(function (el) {
			return el.id;
		});
		if (idList.indexOf(charaId) >= 0) {
			deckCreator.selectedCharaList.splice(idList.indexOf(charaId), 1);
			$(this).find('.evecharaIcon').removeClass('selectedItem');
		} else {
			if (deckCreator.selectedCharaList.length < 6) {
				deckCreator.selectedCharaList.push({
					id: charaId,
					lv: '',
					rare: 0
				});
				$(this).find('.evecharaIcon').addClass('selectedItem');
			}
		}
	},

	deleteSelectedEveChara: function(idx) {
		if (!deckCreator.selectedCharaList[idx]) {
			deckCreator.openRemodal();
			return;
		}

		var id = deckCreator.selectedCharaList[idx].id;
		var obj = $('#eveCharaList li');
		obj.each(function(){
			if ('' + $(this).data('charaId') === id) {
				$(this).find('.selectedItem').removeClass('selectedItem');
			}
		});

		deckCreator.selectedCharaList.splice(idx, 1);
		deckCreator.updateEveCharaList();
	},

	openMakedCharaList: function () {
		$.remodal.lookup[$('[data-remodal-id=makedCharaRemodal]').data('remodal')].open();
	},

	setMakedCharacterList: function(data) {
		var posNameList = [
			['捕手', '一塁手', '二塁手', '三塁手', '遊撃手', '外野手'],
			['先発', '中継ぎ', '抑え']
		];
		var list = data.data.charaList;
		var str = '';
		for (var i = 0; i < list.length; i++) {
			var chara = list[i].data;
			var meter = list[i].meter;
			if (chara.charaType === 0) {
				str += '<tr data-charaid="' + list[i].id + '"' + (savedMakedCharaList.indexOf(list[i].id) >= 0 ? ' class="selectedMakedCharacter"' : '') + '>' +
					'<td><img class="charaFace" src="' + list[i].imgURL + '"></td>' +
					'<td>' + chara.name + '</td>' +
					'<td>' + posNameList[0][chara.mainPosition] + '</td>';

				for (var j = 0; j < chara.basePoint[1].length; j++) {
					str += '<td>';
					if(chara.basePoint[1][j] !== 0) {
						str += '<div class="rankArea"><img class="rankGraph" src="../img/';
						if(j === 0) {
							str+= 'trajectory' + chara.basePoint[1][j];
						} else {
							str+= 'rank' + deckCreator.getRankString(chara.basePoint[1][j]);
						}
						str += '.png">';
						if(j !== 0) {
							str += '<div class="rankNum">' + chara.basePoint[1][j] + '</div>'
						}
						str += '</div>';
					}
					str += '</td>';
				}

				var rankAlpha = list[i].rankStr.match(/^[A-Z]*/)[0];
				var rankNum = list[i].rankStr.match(/[0-9]$/);
				str += '<td><div class="rankArea"><div class="assessmentArea"><img class="rankGraph" src="../img/rank' + rankAlpha + '.png">' + (rankNum ? '<div class="rankGrade">' + rankNum + '</div>' : '') + '</div><div class="meterFrame"><div class="meterGauge" style="width:' + meter + '%"></div></div></div></td>' +
					'<td><a href="./batter.php?userId=' + data.data.userId + '&charaId=' + list[i].id + '" target="_blank">詳細</a></td>' +
					'</tr>';
			}
		}
		$('#batterTable').append(str);

		str = '';

		for (var i = 0; i < list.length; i++) {
			var chara = list[i].data,
				imgURL = list[i].imgURL;
			if (chara.charaType === 1) {
				str += '<tr data-charaid="' + list[i].id + '"' + (savedMakedCharaList.indexOf(list[i].id) >= 0 ? ' class="selectedMakedCharacter"' : '') + '>' +
					'<td class="charaFaceCell"><img class="charaFace" src="' + imgURL + '"></td>' +
					'<td>' + chara.name + '</td>' +
					'<td>' + posNameList[1][chara.mainPosition] + '</td>';
				for (var j = 0; j < chara.basePoint[1].length; j++) {
					str += '<td>';
					if(chara.basePoint[1][j] !== 0) {
						if(j === 0) {
							str+= '' + chara.basePoint[1][j];
						} else {
							str += '<div class="rankArea"><img class="rankGraph" src="../img/';
							str+= 'rank' + deckCreator.getRankString(chara.basePoint[1][j]);
							str += '.png">';
						}
						if(j !== 0) {
							str += '<div class="rankNum">' + chara.basePoint[1][j] + '</div>'
						}
						str += '</div>';
					}
					str += '</td>';
				}
				for (var j = 0; j < chara.changeBall[1].length; j++) {
					str += '<td>' + (chara.changeBall[1][j] ? chara.changeBall[1][j].value : '0') + '</td>';
				}
				str += '<td><a href="./pitcher.php?userId=' + data.data.userId + '&charaId=' + list[i].id + '" target="_blank">詳細</a></td>' +
					'</tr>';
			}
		}
		document.querySelector('#pitcherTable').insertAdjacentHTML('beforeend', str);

		$('#batterTable tr:gt(0)').click(deckCreator.markMakedCharacter);
		$('#pitcherTable tr:gt(0)').click(deckCreator.markMakedCharacter);
		this.setMakedCharacter();
	},

	markMakedCharacter: function() {
		if ($(this).hasClass('selectedMakedCharacter')) {
			$(this).removeClass('selectedMakedCharacter');
		} else if($('.selectedMakedCharacter').length < 10) {
			$(this).addClass('selectedMakedCharacter');
		}
	},

	setMakedCharacter: function() {
		var table = $('#batterDisplayTable');
		var obj = $('#batterTable tr');
		var existFlag = false;
		table.find("tr:gt(0)").remove();
		for (var i = 0; i < obj.length; i++) {
			if (obj.eq(i).hasClass('selectedMakedCharacter')) {
				table.append(obj.eq(i).clone());
				existFlag = true;
			}
		}
		table.find('.selectedMakedCharacter').removeClass('selectedMakedCharacter');
		if (existFlag) {
			$('#batterMakedDisplay').removeClass('hiddenDisplay');
		} else {
			$('#batterMakedDisplay').addClass('hiddenDisplay');
		}

		table = $('#pitcherDisplayTable');
		obj = $('#pitcherTable tr');
		existFlag = false;
		table
		table.find("tr:gt(0)").remove();
		for (var i = 0; i < obj.length; i++) {
			if (obj.eq(i).hasClass('selectedMakedCharacter')) {
				table.append(obj.eq(i).clone());
				existFlag = true;
			}
		}
		table.find('.selectedMakedCharacter').removeClass('selectedMakedCharacter');
		if (existFlag) {
			$('#pitcherMakedDisplay').removeClass('hiddenDisplay');
		} else {
			$('#pitcherMakedDisplay').addClass('hiddenDisplay');
		}
	},


	getRankString: function(val) {
		var rank = ['G', 'G', 'F', 'F', 'E', 'D', 'C', 'B', 'A', 'S'];
		return val === 100 ? 'S' : rank[parseInt(val/10)];
	},

	GetQueryString: function() {
		var result = {};
		if( 1 < window.location.search.length )	{
			// 最初の1文字 (?記号) を除いた文字列を取得する
			var query = window.location.search.substring( 1 );

			// クエリの区切り記号 (&) で文字列を配列に分割する
			var parameters = query.split( '&' );

			for( var i = 0; i < parameters.length; i++ ) {
				// パラメータ名とパラメータ値に分割する
				var element = parameters[ i ].split( '=' );

				var paramName = decodeURIComponent( element[ 0 ] );
				var paramValue = decodeURIComponent( element[ 1 ] );

				// パラメータ名をキーとして連想配列に追加する
				result[ paramName ] = paramValue;
			}
		}
		return result;
	},

	showBlockMessage: function (msg) {
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
	}

};
