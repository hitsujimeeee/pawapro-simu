/*jshint jquery: true, browser: true, shadow: true */
/*global baseAbilityList, charaData, commonModule, rankData  */

var abilityData = null;

$(function() {

	$(document).on('confirmation', '#abilityModal', function () {
		assessment.ConfirmRemodal();
	});

	$(document).on('closing', '#abilityModal', function () {
		assessment.ConfirmRemodal();
	});

	$('.plusButtonArea > .buttonAct').click(commonModule.changeAbility);
	$('.minusButtonArea > .buttonAct').click(commonModule.changeAbility);
	$('.basePointInput').on('change', assessment.changeBaseAbility);

	commonModule.setTabType(0);
	//特能一覧取得
	commonModule.getAsyncData(
		'abilityGroupList',
		JSON.stringify({pageType:0}),
		function(data) {
			abilityData = JSON.parse(data);
			charaData.init();
			assessment.calcAssessmentPoint();
		}
	);

});

var assessment = {
	abTypeClass: ['selectedAbility', 'selectedSAbility', 'selectedBAbility', 'selectedPAbility', 'selectedHAbility', 'selectedGAbility'],

	ConfirmRemodal: function() {

		var abilityList = charaData.getAbilityList(0);
		var str = '<ul class="abilityDisplay">';
		var count = 0;

		for (var i = 0; i < abilityData.length; i++) {
			var id = abilityData[i].id;

			if (abilityList[id] !== null) {
				var ability = abilityList[id];
				if (ability) {
					str += '<li class="' + assessment.abTypeClass[Number(ability.type)] + '"><span class="displayName">' + ability.name + '</span></li>';
					count++;
				}

			}
		}
		str += '</ul>';

		$(' .displayAbility').html(str);
		$(' .abilityCount').html(count + '個');
		assessment.calcAssessmentPoint();
		$.remodal.lookup[$('[data-remodal-id=modal]').data('remodal')].close();

	},

	calcAssessmentPoint: function () {

		var basePoint = $('.basePointInput').map(function(idx, elt){
			return baseAbilityList[idx][parseInt(Number($(elt).val() || 0)-1, 10)] || 0;
		}).get();

		basePoint = basePoint.reduce(function(pre, cur){
			return pre + cur;
		});
		basePoint =  basePoint + 7.84 * Math.round(basePoint/47.04) + 11.27;

		var list = charaData.getAbilityList(0);

		var getAbility = function(abList, id) {
			return abList.filter(function(elt){
				return elt.id === id;
			})[0];
		};
		var searchAbGr = function(elt) {
			return elt.id === i;
		};
		var abilityPoint= 0;

		for (var i = 0; i < list.length; i++) {
			if(!list[i]) {
				continue;
			}
			var abGr = abilityData.filter(searchAbGr)[0];
			var ab = getAbility(abGr.list, list[i].id);
			while(ab) {
				abilityPoint += Number(ab.assessment);
				ab = getAbility(abGr.list, ab.lower);
			}

		}

		var total = parseInt((basePoint + abilityPoint) / 14, 10) * 14;
		var rankStr = '';
		var rankNum = '';
		var gauge = 0;

		for (var i = 0; i < rankData.length; i++) {
			if (total >= rankData[i].pointFrom && total < rankData[i].pointTo) {
				rankStr = rankData[i].rankStr;
				if (rankStr.charAt(0) === 'G') {
					gauge = parseInt((rankData[i].pointTo - total)/14, 10);
					gauge = 10 - gauge;
					if (gauge < 0) {
						gauge = 0;
					}
				} else {
					gauge = parseInt((total - rankData[i].pointFrom)/14, 10);
				}
				break;
			}
		}
		if(rankStr.charAt(0) === 'S' && rankStr.charAt(1) === 'S' && rankStr.length >= 3) {
			rankNum = rankStr.charAt(2);
			rankStr = 'SS';
		} else if(rankStr.charAt(0) === 'S' && rankStr.length >= 2 && isFinite(rankStr.charAt(1))) {
			rankNum = rankStr.charAt(1);
			rankStr = 'S';
		}

		$('.meterGauge').css('width', (gauge*10)+'%');

		$('#displayRank').html('<img src="../img/rank' + rankStr + '.png">');
		$('#displayRankNum').html(rankNum);
		$('#displayShowAssessment').html(total);
		$('#displayRealAssessment').html(Math.round((basePoint + abilityPoint) * 100) / 100);

	},

	changeBaseAbility: function () {
		var array = $('.basePointInput');
		for (var i = 0; i < array.length; i++) {
			var value = parseInt(array.eq(i).val(), 10);
			if (value) {
				if (value > Number(array.eq(i).attr('max'))) {
					value = Number(array.eq(i).attr('max'));
				} else if (value < Number(array.eq(i).attr('min'))) {
					value = Number(array.eq(i).attr('min'));
				}
				array.eq(i).val(value);
			} else {
				array.eq(i).val('');
			}
		}
		assessment.calcAssessmentPoint();
	},


};
