/*jslint shadow:true, browser: true, jquery: true */

$(function () {

	$('.epicButton').on('click', epicMemo.openRemodal);
	$('.epicItem').on('click', epicMemo.setEpic);
	$('#commentArea').on('change', epicMemo.save);
	epicMemo.load();
});


var epicMemo = {
	selectedIndex: 0,
	classList: ['buttonType0', 'buttonType1', 'buttonType2', 'buttonType3', 'buttonType4', 'buttonType5'],

	openRemodal: function() {
		$.remodal.lookup[$('[data-remodal-id=modal]').data('remodal')].open();
		epicMemo.selectedIndex = $('.epicButton').index(this);
	},

	closeRemodal: function() {
		$.remodal.lookup[$('[data-remodal-id=modal]').data('remodal')].close();
	},

	setEpic: function() {
		epicMemo.closeRemodal();
		var idx = $('.epicItem').index(this);
		var name = $('.epicListName').eq(idx).html();
		var turn = $('.epicTurn').eq(idx).html();
		var personnel = $('.epicPersonnel').eq(idx).html();
		var type = $('.epicItem').eq(idx).data('epictype');
		$('.epicButtonName').eq(epicMemo.selectedIndex).html(name);
		$('.epicButtonDetail').eq(epicMemo.selectedIndex).html(turn + '/' + personnel);
		$('.epicButton').eq(epicMemo.selectedIndex).removeClass(epicMemo.classList.join(' ')).addClass('buttonType' + type);

		epicMemo.save();
	},

	addRow: function(saveFlag) {
		if ($('.epicTable tr').length > 20) {
			return;
		}

		var str = '<tr>' +
			'<th>' + $('.epicTable tr').length + '</th>' +
			'<td>' +
				'<div class="epicButton">' +
					'<div class="epicButtonName"></div>' +
					'<div class="epicButtonDetail"></div>' +
				'</div>' +
			'</td>' +
			'</tr>';

		$('.epicTable').append(str);
		$('.epicButton').off().on('click', epicMemo.openRemodal);

		if (saveFlag) {
			epicMemo.save();
		}
	},

	deleteRow: function(saveFlag) {
		if ($('.epicTable tr').length <= 6) {
			return;
		}

		$('.epicTable tr:last').remove();
		if (saveFlag) {
			epicMemo.save();
		}

	},

	removeItem: function() {
		epicMemo.closeRemodal();
		$('.epicButton').eq(epicMemo.selectedIndex).removeClass(epicMemo.classList.join(' '));
		$('.epicButtonName').eq(epicMemo.selectedIndex).html('');
		$('.epicButtonDetail').eq(epicMemo.selectedIndex).html('');
		epicMemo.save();
	},

	reset: function() {
		$('.epicButton').removeClass(epicMemo.classList.join(' '));
		$('.epicButtonName').html('');
		$('.epicButtonDetail').html('');

		var restRowCount = $('.epicTable tr').length - 1 - 10;

		while(restRowCount > 0) {
			epicMemo.deleteRow(false);
			restRowCount--;
		}

		epicMemo.save();

	},

	load: function() {
		var dataStr = localStorage.getItem('epicMemo');
		if (!dataStr) {
			return;
		}
		var savedata = JSON.parse(dataStr);

		var restRowCount = savedata.rowCount - 10;

		while(restRowCount > 0) {
			epicMemo.addRow(false);
			restRowCount--;
		}

		var items = $('.epicItem');

		for (var i = 0; i < savedata.list.length; i++) {
			if (savedata.list[i] !== '') {

				var cType;
				for (var j = 0; j < items.length; j++) {
					if ($('.epicListName').eq(j).html() === savedata.list[i]) {
						cType = items.eq(j).data('epictype');
						$('.epicButton').eq(i).addClass(epicMemo.classList[cType]);
						$('.epicButtonDetail').eq(i).html($('.epicTurn').eq(j).html() + '/' + $('.epicPersonnel').eq(j).html());
						break;
					}
				}
				$('.epicButtonName').eq(i).html(savedata.list[i]);
			}
		}
		if (savedata.comment) {
			$('#commentArea').val(savedata.comment);
		}
	},

	save: function() {
		var rowCount = $('.epicTable tr').length - 1;
		var list = $('.epicButtonName').get().map(function(elt){
			return $(elt).html();
		});
		var comment = $('#commentArea').val();
		var savedata = {
			rowCount:rowCount,
			list: list,
			comment: comment
		};

		localStorage.setItem('epicMemo', JSON.stringify(savedata));
	},

	outputCPText: function() {
		var str = '<ul class="cpTextList">';
		var idx = 1;
		$('.epicButtonName').get().forEach(function(elt){
			if ($(elt).html()) {
				str += '<li>' + idx + '. ' + $(elt).html() + '</li>';
				idx++;
			}
		});
		str += '</ul>';

		if ($('#commentArea').val()) {
			str += '<div>メモ：</div>';
			str += '<div style="margin-left:0.5em;">' + epicMemo.escape_html($('#commentArea').val()) + '</div>';
		}
		$('.cpTextArea').css('display', 'block').html(str);
		$('html, body').animate({scrollTop:$('.cpTextArea').offset().top});
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
	}

};
