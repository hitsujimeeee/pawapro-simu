/*jslint browser: true*/
/*global $, alert, IndividModule, ga */
/*jslint shadow:true*/

var abilityData = null;
var subPosData = null;

//選手データ格納クラス
var charaData = (function() {
	var abilityList = [[], []],	//{id:'', name:'', type:''}
		trickLevel = [],
		StrickLevel = [],
		subPosition = [[], []],	//{id:'', name:'', type:''}
		sense = 0;

	return {

		//配列初期化
		init: function () {
			var size = Number($('#abilityTotalCount').val());

			for (var i = 0; i < size; i++) {
				abilityList[0][i] = null;
				abilityList[1][i] = null;
				trickLevel[i] = 0;
				StrickLevel[i] = 0;
			}

			size = $('#tab1 li[name=subPosition]').length;
			for (var i = 0; i < size; i++) {
				subPosition[0][i] = null;
				subPosition[1][i] = null;
			}
			sense = 0;
		},

		getAbilityList: function (type, idx) {
			return typeof(idx) === "undefined" ? abilityList[type] : abilityList[type][idx];
		},

		setAbilityList: function (type, idx, val) {
			abilityList[type][idx] = val;
		},

		getTrickLevel: function (idx) {
			return typeof(idx) === "undefined" ? trickLevel : trickLevel[idx];
		},

		setTrickLevel: function (idx, val) {
			trickLevel[idx] = val;
		},

		getSTrickLevel: function (idx) {
			return typeof(idx) === "undefined" ? StrickLevel : StrickLevel[idx];
		},

		setSTrickLevel: function (idx, val) {
			StrickLevel[idx] = val;
		},

		getSubPosition: function (type, idx) {
			return typeof(idx) === "undefined" ? subPosition[type] : subPosition[type][idx];
		},

		setSubPosition: function (type, idx, val) {
			subPosition[type][idx] = val;
		},

		syncroAbility: function (idx) {
			abilityList[1][idx] = abilityList[0][idx];
		},

		clickSense: function () {
			$("input[name=senseGroup]").closest("label").removeClass('selectedSense');
			if($(this).val() == sense) {
				$(this).prop('checked', false);
				sense = 0;
			} else {
				sense = $(this).val();
				$(this).closest("label").addClass('selectedSense');
			}
		},

		getSense: function () {
			return sense;
		},

		getSensePer: function () {
			return 1 - Number(sense)/10;
		},

		fetchBasePoint: function (type) {
			var obj = $('#tab'+ (type + 1) + ' .basePointInput'),
				list = [];
			for (var i = 0; i < obj.length; i++) {
				list[i] = Number(obj.eq(i).val());
			}
			return list;
		},

		fetchBaseTrickLevel: function () {
			var obj = $('.baseTrickSlider'),
				list = [];
			for (var i = 0; i < obj.length; i++) {
				list[i] = Number(obj.eq(i).labeledslider("value"));
			}
			return list;
		},

		fetchBaseLimitBreak: function() {
			var obj = $('.baseLimitBreak'),
				list = [];
			for (var i = 0; i < obj.length; i++) {
				list[i] = Number(obj.eq(i).val());
			}
			return list;
		},

		fetchChangeBall: function (type) {
			var obj = $('#tab'+ (type + 1) + ' .changeBallInput'),
				list = [];
			for (var i = 0; i < obj.length; i++) {
				var v = Number(obj.eq(i).val());
				if(v > 0) {
					list[i] = {type:$('#tab'+ (type + 1) + ' .changeBallType').eq(i).val(), value:v};
				} else {
					list[i] = null;
				}
			}
			return list;
		},

		fetchChangeBallTrickLevel: function() {
			var obj = $('.changeBallTrickSlider'),
				list = [];
			for (var i = 0; i < obj.length; i++) {
				list[i] = Number(obj.eq(i).labeledslider("value"));
			}
			return list;
		},

		getSaveData: function (type) {
			var abilitys = [
				abilityList[0].map(function(elem) {
					return elem ? elem.id : null;
				}),
				abilityList[1].map(function(elem) {
					return elem ? elem.id : null;
				})
			];
			var data = {
				charaType:type,
				name:$('#charaName').val(),
				mainPosition:$('#mainPosition').val(),
				useHand:$('#useHand').val(),
				basePoint:[this.fetchBasePoint(0), this.fetchBasePoint(1)],
				baseTrickLevel:this.fetchBaseTrickLevel(),
				baseLimitBreak:this.fetchBaseLimitBreak(),
				ability:abilitys,
				trickLevel:trickLevel,
				StrickLevel:StrickLevel,
				subPosition:subPosition.map(function(elem) {
					return elem.map(function(e) {
						return e ? e.id : null;
					});
				}),
				sense:sense,
			};
			if (type === 1) {
				data.changeBall = [this.fetchChangeBall(0), this.fetchChangeBall(1)];
				data.changeBallTrickLevel = this.fetchChangeBallTrickLevel();
			}
			return data;
		},

		setSaveData: function (data) {
			['tab1', 'tab2'].forEach(function(str, tabIdx){
				$('#' + str + ' .basePointInput').each(function(idx, elt){
					$(elt).val(data.basePoint[tabIdx][idx]);
				});
			});
			var obj;

			obj = $('.baseTrickSlider');
			for (var i = 0; i < data.baseTrickLevel.length; i++) {
				obj.eq(i).labeledslider("value", data.baseTrickLevel[i]);
			}

			obj = $('.baseLimitBreak');
			if(data.baseLimitBreak) {
				for (var i = 0; i < data.baseTrickLevel.length; i++) {
					obj.eq(i).val(data.baseLimitBreak[i]);
				}
			}

			var list = $('.abilityButtonList > li');
			for (var i = 0; i < list.length; i++) {
				var obj = list.eq(i);
				var id = Number(obj.attr('idx'));

				obj.find('.abTrickLevel').html(data.trickLevel[id]);
				obj.find('.SabTrickLevel').html(data.StrickLevel[id]);
			}

			for (var i = 0; i < data.ability[0].length; i++) {
				abilityList[0][i] = data.ability[0][i];
				abilityList[1][i] = data.ability[1][i];
				trickLevel[i] = data.trickLevel[i];
				StrickLevel[i] = data.StrickLevel[i];
			}

			subPosition[0] = data.subPosition[0];
			subPosition[1] = data.subPosition[1];


			$('#charaName').val(data.name);
			$('#mainPosition').val(data.mainPosition);
			$('#useHand').val(data.useHand);

			if(Number(data.sense) !== 0) {
				$("input[name=senseGroup]").eq(Number(data.sense) > 0 ? 0 : 1).trigger('click');
			}

			if(data.changeBall) {
				obj = $('#tab1 .changeBallInput');
				for (var i = 0; i < data.changeBall[0].length; i++) {
					if(data.changeBall[0][i]) {
						$('#tab1 .changeBallType').eq(i).val(data.changeBall[0][i].type);
						obj.eq(i).val(data.changeBall[0][i].value);
					}
				}

				obj = $('#tab2 .changeBallInput');
				for (var i = 0; i < data.changeBall[1].length; i++) {
					if(data.changeBall[1][i]) {
						$('#tab2 .changeBallType').eq(i).val(data.changeBall[1][i].type);
						obj.eq(i).val(data.changeBall[1][i].value);
					}
				}
			}
		},


		convertStorageData: function() {
			for (var t = 0; t < 2; t++) {
				for (var i = 0; i < abilityList[t].length; i++) {
					if (abilityList[t][i] !== null) {
						for (var j = 0; j < abilityData.length; j++) {
							if (abilityData[j].id === i) {
								var list = abilityData[j].list;
								for (var k = 0; k < list.length; k++) {
									if (list[k].id === abilityList[t][i]) {
										abilityList[t][i] = {
											'id': abilityList[t][i],
											'name': list[k].name,
											'type': list[k].type
										};
									}
								}
							}
						}
					}
				}
			}

			for (var t = 0; t < 2; t++) {
				for (var i = 0; i < subPosition[t].length; i++) {
					if (subPosition[t][i] !== null) {
						for (var j = 0; j < subPosData.length; j++) {
							if (subPosData[j].id === Number(subPosition[t][i])) {
								subPosition[t][i] = {
									'id': subPosition[t][i],
									'name': subPosData[j].name,
									'color': subPosData[j].color
								};
							}
						}
					}
				}
			}

		},

		resetAbility: function(){
			for (var i = 0; i < abilityList.length;i++) {
				for (var j = 0; j < abilityList[i].length;j++) {
					abilityList[i][j] = null;
				}
			}

			for (var i = 0; i < trickLevel.length;i++) {
					trickLevel[i] = 0;
					StrickLevel[i] = 0;
			}
		}



	};
})();


var commonModule = {
	tabType: 0,
	abTypeClass: ['selectedAbility', 'selectedSAbility', 'selectedBAbility', 'selectedPAbility', 'selectedHAbility', 'selectedGAbility'],
	subposTypeClass: ['catcher', 'infield', 'outfield', 'pitcher'],
	selAbility: null,
	selTrickType: 0,

	init: function() {

		$('#ui-tab').tabs();
		$(".baseTrickSlider").labeledslider({value:0, min: 0, max: 5, range:"min"});
		$(".changeBallTrickSlider").labeledslider({value:0, min: 0, max: 5, range:"min"});

		$(document).on('confirmation', '#abilityModal', function () {
			commonModule.ConfirmRemodal();
		});

		$(document).on('closing', '#abilityModal', function () {
			commonModule.ConfirmRemodal();
		});

		$(document).on('confirmation', '#resetAbilityModal', function () {
			charaData.init();
			for (var i =0; i < $('.basePointInput').length; i++) {
				$('.basePointInput').eq(i).val(0);
			}

			if (IndividModule.getMakingType() === 1) {
				for (var i =0; i < $('.changeBallInput').length; i++) {
					$('.changeBallInput').eq(i).val(0);
				}
				for (var i =0; i < $('.changeBallType').length; i++) {
					$('.changeBallType').eq(i).val(1);
				}
			}
			location.reload();
		});

		//センス○×のラジオボタンにクリック処理を加える
		$("input[name=senseGroup]").click(charaData.clickSense);

		$('.basePointInput').on('change', IndividModule.updateBaseAbilityRank);

		$('#sendFile').on('change', function (e) {
			commonModule.setPreviewImage(e);
		});

		$('.abTrickLevel').click(commonModule.openTrickLevelDropdown);
		$('.SabTrickLevel').click(commonModule.openTrickLevelDropdown);

		$('body').click(function() {
			$('#trickDropdown').css('display', 'none');
			commonModule.selAbility = null;
		});

		$('.plusButtonArea > .buttonAct').click(commonModule.changeAbility);
		$('.minusButtonArea > .buttonAct').click(commonModule.changeAbility);

		$('.trickLevelVal').click(function(e){
			var val = $('.trickLevelVal').index($(e.currentTarget));
			var id = Number($('.abilityButtonList li').eq(commonModule.selAbility).attr('idx'));

			if (commonModule.selTrickType === 0) {
				charaData.setTrickLevel(id, val);
			}else {
				charaData.setSTrickLevel(id, val);
			}
			$('.' + (commonModule.selTrickType === 0 ? 'abTrickLevel' : 'SabTrickLevel')).eq(commonModule.selAbility).html(val);
			$('#trickDropdown').css('display', 'none');
			commonModule.selAbility = null;
			e.stopPropagation();
			return false;
		});

		$(window).on('beforeunload', commonModule.saveSessionStorageData);

		//特能一覧取得
		commonModule.getAsyncData(
			'abilityGroupList',
			JSON.stringify({pageType:IndividModule.getMakingType()}),
			function(data) {
				data = JSON.parse(data);
				abilityData = data.abilityGroupList;
				subPosData = data.subPosGroupList;
				var param = commonModule.GetQueryString();
				if(param.userId && param.charaId) {
					var data = {'userId':Number(param.userId), 'charaId':param.charaId};
					commonModule.getAsyncData('getCharacter', JSON.stringify(data), function (res) {
						if (res.data) {
							$('#characterId').val(res.charaId);
							$('#charaImg').attr('src', res.imgURL);
							charaData.setSaveData(res.data);
							IndividModule.updateBaseAbilityRank();
							if(typeof IndividModule.updateChangeBallRank !== 'undefined') {
								IndividModule.updateChangeBallRank();
							}
							commonModule.refreshDisplayAbility(0);
							commonModule.refreshDisplaySubPosition(0);
							commonModule.refreshDisplaySubPosition(1);
							commonModule.calcExpPoint();
							$('.shareLinkBody').html(window.location.href);
						}

					});
				} else {
					var data = sessionStorage.getItem(IndividModule.getMakingStr() + 'SessionData');
					if(data) {
						data = JSON.parse(data);
						charaData.setSaveData(data);
						charaData.convertStorageData();
						if(typeof IndividModule.updateChangeBallRank !== 'undefined') {
							IndividModule.updateChangeBallRank();
						}
						commonModule.refreshDisplayAbility(0);
						commonModule.refreshDisplaySubPosition(0);
						commonModule.refreshDisplaySubPosition(1);
					}
					IndividModule.updateBaseAbilityRank();
				}


			},
			function() {
				alert("エラーが発生しました。ページを再読み込みしてください");
			}
		);

		charaData.init();

		commonModule.setTabType(0);
		//	$('.pointInput').eq(0).val(0);
		//	$('.pointInput').eq(1).val(0);
		//	$('.pointInput').eq(2).val(0);
		//	$('.pointInput').eq(3).val(0);
		//	$('.pointInput').eq(4).val(0);

		$('.pointInput').on('change', function () {
			var objs = $('.pointInput'),
				total = 0;
			for (var i = 0; i < objs.length; i++) {
				var value = parseInt(objs.eq(i).val(), 10);
				if (value) {
					if (value > Number(objs.eq(i).attr('max'))) {
						value = Number(objs.eq(i).attr('max'));
					} else if (value < Number(objs.eq(i).attr('min'))) {
						value = Number(objs.eq(i).attr('min'));
					}
					objs.eq(i).val(value);
					total += value;
				} else {
					objs.eq(i).val('');
				}
			}
			$('.ownPointTotal').html(total);
		});
	},

	setTabType: function (type) {
		commonModule.tabType = type;
	},

	getTabType: function () {
		return commonModule.tabType;
	},

	//モーダルウインドウを開く
	openModalWindow: function (type) {
		commonModule.tabType = type;
		commonModule.refreshAbilityList();
		$.remodal.lookup[$('[data-remodal-id=modal]').data('remodal')].open();
	},

	getAsyncData: function (method, data, callBackSuccess, callBackError) {
		if (typeof(callBackSuccess) !== 'undefined') {
			$.ajax({
				type: "POST",
				url: method + '.php',
				data: data || {},
				timeout: 5000,
				success: callBackSuccess,
				error: callBackError
			});
			return null;
		}
		var temp = $.ajax({
			type: "POST",
			url: method + '.php',
			data: data || {},
			async: false
		}).responseText;
		return JSON.parse(temp);
	},

	ConfirmRemodal: function () {
		commonModule.refreshDisplayAbility();
		$.remodal.lookup[$('[data-remodal-id=modal]').data('remodal')].close();
	},

	refreshDisplayAbility: function (idx) {
		//選択済み特能全取得
		if (typeof(idx) === 'undefined') {
			idx = commonModule.tabType;
		}
		var abilityList = charaData.getAbilityList(idx);
		var str = '<ul class="abilityDisplay">';
		var count = 0;

		for (var i = 0; i < abilityData.length; i++) {
			var id = abilityData[i].id;

			if (abilityList[id] !== null) {
				var ability = abilityList[id];
				if (ability) {
					var changeTypeStr = '';
					if(idx === 1) {
						changeTypeStr = charaData.getAbilityList(0, id) === null ? '<span class="changeTypeStr">new</span>' : (ability.id === charaData.getAbilityList(0, id).id ? '' : '<span class="changeTypeStr"><i class="fa fa-level-up changeIcon" aria-hidden="true"></i><i class="fa fa-level-up changeIcon" aria-hidden="true"></i></span>');
					}
					str += '<li class="' + commonModule.abTypeClass[Number(ability.type)] + '"><span class="displayName">' + ability.name + changeTypeStr + '</span></li>';
					count++;
				}

			}
		}
		str += '</ul>';

		$('#tab' + (idx + 1) +' .displayAbility').html(str);
		$('#tab' + (idx + 1) +' .abilityCount').html(count + '個');

	},

	refreshAbilityList: function() {
		var list = $('.abilityButtonList > li:not(.abSelectHeader)');

		for (var i = 0; i < list.length; i++) {
			var obj = list.eq(i);
			var id = Number(obj.attr('idx'));

			commonModule.updateAbilityDisplay(commonModule.getTabType(), id, obj);

		}

		list = $('.otherAbilityList li');

		for (var i = 0; i < list.length; i++) {
			var obj = list.eq(i);
			var id = Number(obj.attr('idx'));
			obj.find('button').removeClass('GAColor');
			var ab = charaData.getAbilityList(commonModule.getTabType(), id);
			if (ab !== null) {
				obj.find('button').html(ab.name).addClass('GAColor');
			} else {
				obj.find('button').html(obj.find('button').data('defname'));
			}
		}
	},

	refreshDisplaySubPosition: function (tab) {
		var list = charaData.getSubPosition(tab);

		for (var i = 0; i < list.length; i++) {
			var obj = $('#tab' + (tab + 1) +' .displaySubPosition > ul > li').eq(i);
			obj.removeClass(commonModule.subposTypeClass.join(' '));
			if (list[i] !== null) {
				var option = '';
				if (tab === 1) {
					option = !charaData.getSubPosition(0, i) ? '<span class="changeTypeStr">new</span>' : (charaData.getSubPosition(0, i).id != list[i].id ? '<span class="changeTypeStr"><i class="fa fa-level-up changeIcon" aria-hidden="true"></i><i class="fa fa-level-up changeIcon" aria-hidden="true"></i></span>' : '');
				}
				obj.addClass(commonModule.subposTypeClass[list[i].color]);
				obj.find('.displayName').html(list[i].name + option);
			} else {
				obj.find('.displayName').html(obj.attr('default'));
			}
		}

	},

	calcExpPoint: function () {
		var basePointNow = [],
			basePointAim = [],
			dataAbilityNow = [],
			dataAbilityAim = [],
			trickLevel = [],
			StrickLevel = [],
			baseTrickLevel = [],
			subPositionNow = [],
			subPositionAim = [],
			changeBallType = null,
			changeBallTrickLevel = null,
			changeBallNow = null,
			changeBallAim = null,
			pageType = 0,
			obj = $('#tab1 .basePointInput');
		for (var i = 0; i < obj.length; i++) {
			basePointNow[i] = Number(obj.eq(i).val());
		}

		obj = $('#tab2 .basePointInput');
		for (var i = 0; i < obj.length; i++) {
			basePointAim[i] = Number(obj.eq(i).val());
		}
		var abNow = charaData.getAbilityList(0);
		var abAim = charaData.getAbilityList(1);

		for (var i = 0; i < abNow.length; i++) {
			if ((abNow[i] !== null || abAim[i] !== null) && (abNow[i] ? abNow[i].id : null) !== (abAim[i] ? abAim[i].id : null)) {
				dataAbilityNow[dataAbilityNow.length] = (abNow[i] ? abNow[i].id : null);
				dataAbilityAim[dataAbilityAim.length] = (abAim[i] ? abAim[i].id : null);
				trickLevel[trickLevel.length] = charaData.getTrickLevel(i);
				StrickLevel[StrickLevel.length] = charaData.getSTrickLevel(i);
			}
		}
		obj = $('.baseTrickSlider');
		for (var i = 0; i < obj.length; i++) {
			baseTrickLevel[i] = Number(obj.eq(i).labeledslider("value"));
		}

		var posNow = charaData.getSubPosition(0);
		var posAim = charaData.getSubPosition(1);
		for (var i = 0; i < posNow.length; i++) {
			if ((posNow[i] !== null || posAim[i] !== null) && (posNow[i] ? posNow[i].id : null) !== (posAim[i] ? posAim[i].id : null)) {
				subPositionNow[subPositionNow.length] = Number((posNow[i] ? posNow[i].id : null));
				subPositionAim[subPositionAim.length] = Number((posAim[i] ? posAim[i].id : null));
			}
		}

		//変化球部分
		obj = $('#tab2 .changeBallType');
		if (obj.length > 0) {
			changeBallType = [];
			changeBallNow = [];
			changeBallAim = [];
			changeBallTrickLevel = [];
			for (var i = 0; i < obj.length; i++) {
				changeBallType[i] = Number(obj.eq(i).val());
			}

			obj = $('#tab2 .changeBallInput');
			for (var i = 0; i < obj.length; i++) {
				changeBallNow[i] = Number($('#tab1 .changeBallInput').eq(i).val());
				changeBallAim[i] = Number(obj.eq(i).val());
			}

			obj = $('.changeBallTrickSlider');
			for (var i = 0; i < obj.length; i++) {
				changeBallTrickLevel[i] = Number(obj.eq(i).labeledslider("value"));
			}
			pageType = 1;
		}

		var data = {
			"now":{"basePoint":basePointNow, ability:dataAbilityNow, subPosition:subPositionNow, changeBall:changeBallNow},
			"aim":{"basePoint":basePointAim, ability:dataAbilityAim, subPosition:subPositionAim, changeBall:changeBallAim},
			"trickLevel":trickLevel,
			"StrickLevel":StrickLevel,
			"baseTrickLevel": baseTrickLevel,
			"changeBallType": changeBallType,
			"changeBallTrickLevel": changeBallTrickLevel,
			"sense": charaData.getSensePer(),
			"pageType": pageType
		};

		var point = this.getAsyncData('calcExpPoint', JSON.stringify(data)),
			total = point.reduce(function(pre, current){
				return pre + current;
			});
		for (var i = 0; i < point.length; i++) {
			$('.needExp td').eq(i).html(point[i]);
		}
		$('.needExp td').eq(5).html(total);




		//選手データ書き込み
		$('#entryNameCharaData').html($('input#charaName').val());
		$('#mainPositionCharaData').html($('#mainPosition option:selected').text());

		var array = charaData.getSubPosition(1),
			mainPosition = Number($('#mainPosition option:selected').val()),
			str = '';
		for (var i = 0; i < array.length; i++) {
			if (i !== mainPosition && array[i] !== null) {
				str += $('#mainPosition option').eq(i).text() + '，';
			}
		}
		str = str.substring(0, str.length - 1);
		$('#subPositionCharaData').html(str || '無し');
		$('#useHandCharaData').html($('#useHand option:selected').text());

		str = '';
		for (var i = 0; i < basePointAim.length; i++) {
			if (i === 0) {
				str += basePointAim[i] ? (IndividModule.getMakingType() === 1 ? basePointAim[i] + 'km/h ' : '<span class="dispAbArea"><img class="dispBaseAbT" src="../img/trajectory' + basePointAim[i] + '.png"></span>' ) : '-';
			} else {
				str += '<span class="dispAbArea"><img class="dispBaseAb" src="../img/rank' + commonModule.getRankString(basePointAim[i]) + '.png"><span class="dispAbNum">' + basePointAim[i] + '</span></span>';
			}
		}
		$('#baseAbilityCharaData').html(str);


		if(IndividModule.getMakingType() === 1) {
			str = '';
			for (var i = 0; i < changeBallAim.length; i++) {
				if(changeBallAim[i] > 0) {
					var obj = $('#tab2 .changeBallType').eq(i).find('option').eq(changeBallType[i]-1);
					var text = obj.text();
					if (i === 0) {
						str += text;
					} else {
						str += text + changeBallAim[i];
					}
					str += ',';
				}
			}
			str = str.substr(0, str.length-1);
			$('#changeBallCharaData').html(str);
		}


		str = '';

		var charaAbility = charaData.getAbilityList(1);

		for (var i = 0; i < abilityData.length; i++) {
			var ability = charaAbility[abilityData[i].id];
			if(ability !== null) {
				str += '<li class="' + commonModule.abTypeClass[ability.type] + '">' + ability.name + '</li>';
			}
		}


		$('#abilityCharaData').html(str);

		if(IndividModule.getMakingType() === 0) {
			commonModule.updateAssessmentPoint();
		} else {
			commonModule.updateAssessmentPointPitcher();
		}

	},

	updateAssessmentPoint: function () {
		var chk = $('#nonAssessment').prop("checked");
		localStorage.setItem('nonAssessment', JSON.stringify(chk));

		if (chk) {
			$('#assessmentPointCharaData').html('');
			$('#assessmentPointMeter').val(0);
			return;
		}


		var obj = $('#tab2 .basePointInput'),
			basePoint = [];
		for (var i = 0; i < obj.length; i++) {
			basePoint[i] = Number(obj.eq(i).val());
		}

		var ability = charaData.getAbilityList(1).filter(function (elem){
			return elem !== null;
		}).map(function (elem){
			return elem.id;
		});

		var assessment = this.getAsyncData('getAssessmentPoint', JSON.stringify({"basePoint":basePoint, "ability":ability}));
		$('#assessmentPointCharaData').html(assessment.rank + '(' + assessment.point + ')');
		$('.meterGauge').css('width', (assessment.meter*10)+'%');

	},

	updateAssessmentPointPitcher: function() {
		var chk = $('#nonAssessment').prop("checked");
		localStorage.setItem('nonAssessment', JSON.stringify(chk));

		if (chk) {
			$('#assessmentPointCharaData').html('');
			return;
		}


		var obj = $('#tab1 .basePointInput'),
			baseNowPoint = [];
		for (var i = 0; i < obj.length; i++) {
			baseNowPoint[i] = Number(obj.eq(i).val());
		}

		var obj = $('#tab2 .basePointInput'),
			baseAimPoint = [];
		for (var i = 0; i < obj.length; i++) {
			baseAimPoint[i] = Number(obj.eq(i).val());
		}


		var changeBallType = [];
		var changeBallNow = [];
		var changeBallAim = [];
		obj = $('#tab2 .changeBallType');
		for (var i = 0; i < obj.length; i++) {
			changeBallType[i] = Number(obj.eq(i).val());
		}

		obj = $('#tab2 .changeBallInput');
		for (var i = 0; i < obj.length; i++) {
			changeBallNow[i] = Number($('#tab1 .changeBallInput').eq(i).val());
			changeBallAim[i] = Number(obj.eq(i).val());
		}

		var abilityNow = charaData.getAbilityList(0).filter(function (elem){
			return elem !== null;
		}).map(function (elem){
			return elem.id;
		});

		var abilityAim = charaData.getAbilityList(1).filter(function (elem){
			return elem !== null;
		}).map(function (elem){
			return elem.id;
		});

		var assessmentNow = this.getAsyncData('getAssessmentPointPitcher', JSON.stringify({"basePoint":baseNowPoint, "ability":abilityNow, "changeBallType":changeBallType, "changeBallValue":changeBallNow}));
		var assessmentAim = this.getAsyncData('getAssessmentPointPitcher', JSON.stringify({"basePoint":baseAimPoint, "ability":abilityAim, "changeBallType":changeBallType, "changeBallValue":changeBallAim}));
		var nowTotal = (assessmentNow.basePoint !== null ? assessmentNow.basePoint : 0) + assessmentNow.abPoint;
		var aimTotal = (assessmentAim.basePoint !== null ? assessmentAim.basePoint : 0) + assessmentAim.abPoint;
		$('#assessmentPointCharaData').html((assessmentNow.basePoint !== null ? parseInt(aimTotal) : '') + '(' + parseInt(aimTotal - nowTotal, 10) + '↑)');

	},

	isCatcher: function () {
		if(Number($('#mainPosition option:selected').val()) === 0 || charaData.getSubPosition(0, 0) !== null) {
			return true;
		}
		return false;
	},

	getRankString: function (val) {
		var rank = ['G', 'G', 'F', 'F', 'E', 'D', 'C', 'B', 'A', 'S', 'S'];
		return rank[parseInt(val/10)];
	},

	saveCharaData: function(type) {
		commonModule.showBlockMessage('<div id="blockMsg"><i class="fa fa-spinner fa-pulse"></i> <span id="blockMessage">処理中...</span><div id="errorMsg"></div></div>');
		var post = {
			'name':$('#loginUserName').val(),
			'password':$('#loginPassword').val(),
			'charaId':$('#characterId').val(),
			'data':charaData.getSaveData(type)
		};

		commonModule.getAsyncData('registCharacter', JSON.stringify(post), function (res) {
			if(res.status !== -1) {
				var newUrl = setParameter({'userId':res.userId, charaId:res.charaId});
				$('#characterId').val(res.charaId);
				history.replaceState('','',newUrl);
				$('.shareLinkBody').html(window.location.href);
				commonModule.uploadImage(res.charaId, '<i class="fa fa-check" aria-hidden="true" style="color:#008000"></i>' + res.msg);
			} else {
				res.msg = '<i class="fa fa-times" aria-hidden="true" style="color:#ff0000"></i>' + res.msg;
				$('#blockMsg').html(res.msg);
				$('.blockOverlay').click($.unblockUI).on('click', $.unblockUI);
				setTimeout($.unblockUI, 2000);
			}
		}, function (res) {
			res.msg = '<i class="fa fa-times" aria-hidden="true" style="color:#ff0000"></i>エラーが発生しました。電波状態の良い所でやり直してください。';
			$('#blockMsg').html(res.msg);
			$('.blockOverlay').click($.unblockUI).on('click', $.unblockUI);
			setTimeout($.unblockUI, 2000);
		});

		//パラメータを設定したURLを返す
		function setParameter( paramsArray ) {
			var resurl = '';
			for (var key in paramsArray ) {
				resurl += (resurl.indexOf('?') == -1) ? '?':'&';
				resurl += key + '=' + paramsArray[key];
			}
			return resurl;
		}

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

	uploadImage: function(charaId, successMsg) {
		var param = commonModule.GetQueryString();
		var fd = new FormData($('#sendForm').get(0));
		if ($("#sendFile").val().length === 0) {
			$('#blockMsg').html(successMsg);
			$('.blockOverlay').click($.unblockUI).on('click', $.unblockUI);
			setTimeout($.unblockUI, 2000);
			return false;
		}

		if (!param.charaId) {
			commonModule.showBlockMessage('<i class="fa fa-times" aria-hidden="true" style="color:#ff0000"></i>エラーが発生しました。');
			$('.blockOverlay').click($.unblockUI).on('click', $.unblockUI);
			setTimeout($.unblockUI, 3000);
			$('#faceLabel').append($("#sendForm").clone(true));
			$("#sendForm").remove();
			return false;
		}

		ga('send', 'event', 'action', 'click', 'uploadImage');
		fd.append('charaId', param.charaId || "");
		fd.append('userName', $('#loginUserName').val());
		fd.append('password', $('#loginPassword').val());
		$.ajax({
			url: "./uploadImage.php",
			type: "POST",
			data: fd,
			processData: false,
			contentType: false,
			dataType: 'json'
		}).done(function( data ) {
			switch(data.status) {
				case 0:
					$('#charaImg').attr('src', '../img/charaFace/' + data.dirName + '/' + data.charaId + '.jpg' + '?' + new Date().getTime());
					$('#blockMsg').html(successMsg);
					$('.blockOverlay').click($.unblockUI).on('click', $.unblockUI);
					setTimeout($.unblockUI, 2000);
					break;
				case -1:
					$('#blockMsg').html('<i class="fa fa-times" aria-hidden="true" style="color:#ff0000"></i>' + data.msg);
					$('.blockOverlay').click($.unblockUI).on('click', $.unblockUI);
					setTimeout($.unblockUI, 3000);
					break;
			}
		}).fail(function() {
			alert('エラーが発生しました。');
		});
		return false;
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
	},


	setPreviewImage: function(e) {
		var file = e.target.files[0],
		reader = new FileReader(),
		preview = $('#charaImg');
		if(file === void 0) {
			preview.attr('src', '../img/noface.jpg');
			return false;
		}

		if(!~file.type.indexOf('image')) {
			preview.attr('src', '../img/noface.jpg');
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


	saveAbilityTemplate: function () {
		//後で makingStr = IndividModule.getMakingStr()に変更
		var makingStr = (['batter', 'pitcher'])[IndividModule.getMakingType()];

		var ability = charaData.getAbilityList(0).map(function (el) {
			return el ? el.id : null;
		});

		localStorage.setItem(makingStr + 'AbilityTemplate', JSON.stringify(ability));
		$.remodal.lookup[$('[data-remodal-id=doneTemplateModal]').data('remodal')].open();
	},

	setAbilityTemplate: function () {
		//後で makingStr = IndividModule.getMakingStr()に変更
		var makingStr = (['batter', 'pitcher'])[IndividModule.getMakingType()];
		var template = localStorage.getItem(makingStr + 'AbilityTemplate');
		if (template === null) {
			alert('テンプレートが保存されていません');
			return;
		}

		template = [JSON.parse(template)];
		var count = charaData.getAbilityList(0).length;
		for (var i = 0; i < count; i++) {
			charaData.setAbilityList(0, i, null);
			charaData.setAbilityList(1, i, null);
		}

		var abData = commonModule.getAsyncData('convertSaveAbility', JSON.stringify({ability:template}));
		for (var i = 0; i < abData[0].length; i++) {
			charaData.setAbilityList(0, i, abData[0][i]);
			charaData.setAbilityList(1, i, abData[0][i]);
		}

		if(commonModule.getTabType() !== 2) {
			commonModule.refreshDisplayAbility(commonModule.getTabType());
		}
		$.remodal.lookup[$('[data-remodal-id=optionModal]').data('remodal')].close();
	},

	changeAbility: function(e) {

		var obj = $(e.currentTarget);
		var id = Number(obj.parents('li').attr('idx'));
		var upDown = obj.find('div').hasClass('plusButton') ? 1 : 0;


		var tabType = commonModule.getTabType();
		var abGr = abilityData.filter(function(e){
			return e.id === id;
		})[0];
		var pair = abGr.pair;
		abGr = abGr.list;

		var nowAb = charaData.getAbilityList(tabType, id);
		var ab = null;

		if (nowAb === null) {
			switch(upDown) {
				case 0:
					ab = abGr.filter(function(elt){
						return ((elt.type === 2 || elt.type === 3) && elt.upper === null);
					})[0];
					break;
				case 1:
					ab = abGr.filter(function(elt){
						return ((elt.type === 0 || elt.type === 1 || elt.type === 4) && elt.lower === null);
					})[0];
					break;
			}
		} else {
			nowAb = abGr.filter(function(elt){
				return elt.id === nowAb.id;
			})[0];
			var target = upDown === 0 ? nowAb.lower : nowAb.upper;
			if (target !== null) {
				ab = abGr.filter(function(elt){
					return elt.id === target;
				})[0];
			}
		}

		if (ab) {
			charaData.setAbilityList(tabType, id, {id:ab.id, name: ab.name, type: ab.type});

			if (upDown === 1 && tabType === 0) {
				charaData.syncroAbility(id);
			}

			//相反関係の特能を打ち消す
			if (pair !== null) {
				charaData.setAbilityList(tabType, Number(pair), null);
				var liobj = $('.abilityButtonList > li');
				for (var i = 0; i < liobj.length; i++) {
					if (Number(liobj.eq(i).attr('idx')) === Number(pair)) {
						commonModule.updateAbilityDisplay(tabType, Number(pair), liobj.eq(i));
						break;
					}
				}
			}
		} else {
			charaData.setAbilityList(tabType, id, null);
		}

		commonModule.updateAbilityDisplay(tabType, id, $(obj).parents('li'));

	},

	changeGAbility: function(id, obj) {
		var abGr = abilityData.filter(function(e){
			return e.id === id;
		})[0].list;

		$(obj).removeClass('GAbColor');

		var nowAb = charaData.getAbilityList(commonModule.tabType, id);
		if (nowAb === null) {
			var ab = abGr[0];
			charaData.setAbilityList(commonModule.tabType, id, {id:ab.id, name: ab.name, type: ab.type});
			$(obj).html(ab.name).addClass('GAbColor');
		} else {
			var abIdx = abGr.map(function(elt){
				return elt.id;
			}).indexOf(nowAb.id);
			if (abIdx + 1 >= abGr.length) {
				charaData.setAbilityList(commonModule.tabType, id, null);
				$(obj).html($(obj).data('defname'));
			} else {
				var ab = abGr[abIdx+1];
				charaData.setAbilityList(commonModule.tabType, id, {id:ab.id, name: ab.name, type: ab.type});
				$(obj).html(ab.name).addClass('GAbColor');
			}
		}
	},

	updateAbilityDisplay: function(tabType, id, targetLi){
		var nowAb = charaData.getAbilityList(tabType, id);
		var abGr = abilityData.filter(function(e){
			return e.id === id;
		})[0].list;
		var abColors = ['abColor', 'SAbColor', 'BAbColor', 'PAbColor', 'HAbColor'];
		var namePlate = targetLi.find('.abName');
		namePlate.removeClass(abColors.join(' '));
		if (nowAb !== null) {

			var ab = abGr.filter(function(elt){
				return elt.id === nowAb.id;
			})[0];
			namePlate.html(ab.name).addClass(abColors[ab.type]);

			if (ab.type === 2 || ab.type === 3 || ab.upper !== null) {
				targetLi.find('div:nth-child(1) .pmButton, div:nth-child(1) .buttonAct').css('visibility', 'visible');
			} else {
				targetLi.find('div:nth-child(1) .pmButton, div:nth-child(1) .buttonAct').css('visibility', 'hidden');
			}

			if (ab.type === 0 || ab.type === 1 || ab.type === 4 || ab.lower !== null) {
				targetLi.find('div:nth-child(3) .pmButton, div:nth-child(3) .buttonAct').css('visibility', 'visible');
			} else {
				targetLi.find('div:nth-child(3) .pmButton, div:nth-child(3) .buttonAct').css('visibility', 'hidden');
			}
		} else {
			namePlate.html(namePlate.data('defname'));
			var hasLower = abGr.filter(function(elt){
				return elt.type === 2 || elt.type === 3;
			}).length > 0;
			var hasUpper = abGr.filter(function(elt){
				return elt.type === 0 || elt.type === 1 || elt.type === 4;
			}).length > 0;

			if (hasUpper) {
				targetLi.find('div:nth-child(1) .pmButton, div:nth-child(1) .buttonAct').css('visibility', 'visible');
			} else {
				targetLi.find('div:nth-child(1) .pmButton, div:nth-child(1) .buttonAct').css('visibility', 'hidden');
			}

			if (hasLower) {
				targetLi.find('div:nth-child(3) .pmButton, div:nth-child(3) .buttonAct').css('visibility', 'visible');
			} else {
				targetLi.find('div:nth-child(3) .pmButton, div:nth-child(3) .buttonAct').css('visibility', 'hidden');
			}
		}
	},

	changeSubPosition: function(tabType, idx, id) {
		var data = subPosData.filter(function(elt){
			return Number(elt.headerId) === id;
		});
		var now = charaData.getSubPosition(tabType, idx);

		if (now === null) {
			now = {'id':data[0].id, 'name':data[0].name, 'color': data[0].color};
		} else {
			for (var i = 0; i < data.length; i++) {
				if (Number(data[i].id) === Number(now.id)) {
					if (i === data.length -1) {
						now = null;
					} else {
						now = {'id':data[i+1].id, 'name':data[i+1].name, 'color': data[i+1].color};
					}
					break;
				}
			}
		}
		charaData.setSubPosition(tabType, idx, now);

		var obj = $('#tab' + (tabType + 1) +' .displaySubPosition > ul > li').eq(idx);
		obj.removeClass(commonModule.subposTypeClass.join(' '));
		if (now !== null) {
			obj.addClass(commonModule.subposTypeClass[now.color]);
			var option = '';
			if (tabType === 1) {
				option = !charaData.getSubPosition(0, idx) ? '<span class="changeTypeStr">new</span>' : (charaData.getSubPosition(0, idx).id != charaData.getSubPosition(1, idx).id ? '<span class="changeTypeStr"><i class="fa fa-level-up changeIcon" aria-hidden="true"></i><i class="fa fa-level-up changeIcon" aria-hidden="true"></i></span>' : '');
			}
			obj.find('.displayName').html(now.name + option);
		} else {
			obj.find('.displayName').html(obj.attr('default'));
		}


		var obj = $('#tab' + (tabType + 1) +' .displaySubPosition > ul > li').eq(idx);
		obj.removeClass(commonModule.subposTypeClass.join(' '));
		if (now !== null) {
			obj.addClass(commonModule.subposTypeClass[now.color]);
			var option = '';
			if (tabType === 1) {
				option = !charaData.getSubPosition(0, idx) ? '<span class="changeTypeStr">new</span>' : (charaData.getSubPosition(0, idx).id != charaData.getSubPosition(1, idx).id ? '<span class="changeTypeStr"><i class="fa fa-level-up changeIcon" aria-hidden="true"></i><i class="fa fa-level-up changeIcon" aria-hidden="true"></i></span>' : '');
			}
			obj.find('.displayName').html(now.name + option);
		} else {
			obj.find('.displayName').html(obj.attr('default'));
		}

		if (tabType === 0 && charaData.getSubPosition(1, idx)) {
			obj = $('#tab2 .displaySubPosition > ul > li').eq(idx);
			var option = '';
			option = !charaData.getSubPosition(0, idx) ? '<span class="changeTypeStr">new</span>' : (charaData.getSubPosition(0, idx).id != charaData.getSubPosition(1, idx).id ? '<span class="changeTypeStr"><i class="fa fa-level-up changeIcon" aria-hidden="true"></i><i class="fa fa-level-up changeIcon" aria-hidden="true"></i></span>' : '');
			obj.find('.displayName').html(charaData.getSubPosition(1, idx).name + option);
		}

	},

	openTrickLevelDropdown: function(e) {
		var selIdx;
		var typeIdx;
		if ($(e.currentTarget).hasClass('abTrickLevel')) {
			selIdx = $('.abTrickLevel').index($(e.currentTarget));
			typeIdx = 0;
		} else {
			selIdx = $('.SabTrickLevel').index($(e.currentTarget));
			typeIdx = 1;
		}

		if ($('#trickDropdown').css('display') === 'flex' && selIdx === commonModule.selAbility && typeIdx === commonModule.selTrickType) {
			$('#trickDropdown').css('display', 'none');
			return;
		}
		$('#trickDropdown').css('display', 'none');

		commonModule.selAbility = selIdx;
		commonModule.selTrickType = typeIdx;

		$('#trickDropdown').insertAfter($(e.currentTarget));
		$('#trickDropdown').removeClass('normalAbility specialAbility').addClass(commonModule.selTrickType === 0 ? 'normalAbility' : 'specialAbility');
		$('#trickDropdown').css('display', 'flex');

		e.stopPropagation();
		return false;
	},

	saveSessionStorageData: function() {
		sessionStorage.setItem(IndividModule.getMakingStr() + 'SessionData', JSON.stringify(charaData.getSaveData(IndividModule.getMakingType())));
	},

	openResetAbilityModal: function() {
		$.remodal.lookup[$('[data-remodal-id=resetAbilityModal]').data('remodal')].open();
	},

};

