/*jslint browser: true, jquery: true */
/*jslint shadow:true*/

$(function () {
	deckList.loadDeckList();
});


var deckList = {

	loadDeckList: function () {
		$.ajax({
			type: 'POST',
			url: './logic/getDeckList.php',
			data: {
				'userName': $('#loginUserName').val(),
				'password': $('#loginPassword').val()
			}
		}).done(function (data) {
			var str = '';
			var rarelityGraphList = ['SR', 'SR', 'SR', 'R', 'R', 'R', 'R'];
			for (var i = 0; i < data.length; i++) {
				var d = data[i];
				str += '<a class="deckListLink" href="./deckCreator.php?userId=' + d.userId + '&deckId=' + d.id + '"><li class="deckList">' +
					'<div class="deckHeader">' + d.name + '　</div>' +
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
				str += '</div></li></a>';
			}
			$('#deckList').html(str);
		}).fail(function (res) {
		});
	},

};
