/*jslint browser: true*/
/*global $, commonModule, charaData */
/*jslint shadow:true*/

var calcMaxAssessmentPitcherModule = (function() {
	var MAP_MAX_SIZE = 15000;
	var pointList = null;
	var outsideFlag = false;	//現在の能力では査定が出せない場合true

	return {

		//査定最大化
		calcMaxAssessmentPitcher: function() {
			var ability = [],
				expPoint = [];

			commonModule.showBlockMessage('<i class="fa fa-spinner fa-pulse"></i> <span id="blockMessage">処理中...</span><div id="errorMsg"></div>');

			//基礎能力
			var basePointNow = Array.prototype.map.call(document.querySelectorAll('#tab1 .basePointInput'), function(elt){
				return Number(elt.value);
			});


			//基礎能力コツ
			var baseTrickLevel = Array.prototype.map.call(document.querySelectorAll('.baseTrickSlider'), function(elt){
				return Number($(elt).labeledslider("value"));
			});

			//基礎上限突破
			var baseLimitBreak = Array.prototype.map.call(document.querySelectorAll('.baseLimitBreak'), function(elt){
				return Number($(elt).val());
			});

			//変化球
			var changeBallType = Array.prototype.map.call(document.querySelectorAll('#tab1 .changeBallType'), function(elt){
				return Number(elt.value);
			});

			var changeBallValue = Array.prototype.map.call(document.querySelectorAll('#tab1 .changeBallInput'), function(elt){
				return Number(elt.value);
			});

			//特能
			var abNow = charaData.getAbilityList(0);
			for (var i = 0; i < abNow.length; i++) {
				ability[i] = {
					"id":abNow[i] ? abNow[i].id: null,
					"trickLevel":charaData.getTrickLevel(i),
					"StrickLevel":charaData.getSTrickLevel(i),
				};
			}

			//経験点
			var expPoint = Array.prototype.map.call(document.querySelectorAll('.pointInput'), function(elt){
				return Number(elt.value);
			});

			var data = {
				"basePoint":basePointNow,
				"ability":ability,
				"baseTrickLevel": baseTrickLevel,
				"baseLimitBreak": baseLimitBreak,
				"sense": charaData.getSensePer(),
				"expPoint": expPoint,
				"changeBallType": changeBallType,
				"changeBallValue": changeBallValue,
				"abilityOnly": $('#abilityOnly').prop("checked"),
				"nonStamina":$('#nonStamina').prop("checked")
			};

			$.ajax({
				type:"POST",
				url:'./getTargetListPitcher.php',
				timeout: 10000,
				data: JSON.stringify(data)
			}).done(function(data){

				calcMaxAssessmentPitcherModule.outsideFlag = data.outsideFlag;
				var map = [[[0, 0, 0, 0, 0], [0, 0], '', 0, 0]];
				pointList = data.pointList;
				calcMaxAssessmentPitcherModule.RecallMaxAssessment(map, data.targetList, 0, expPoint, data.baseNowAssessment, data.abNowAssessment);
			}).fail(function(res){
				calcMaxAssessmentPitcherModule.ErrorCalcMaxAssessment();
			});
		},

		RecallMaxAssessment: function(map, targetList, depth, expPoint, baseNowAssessment, abNowAssessment) {
			//最後の階層の場合
			if(depth == targetList.length) {

				map.sort(function (m1, m2) {
					return m2[3] - m1[3];
				});

				var basePointNow = [];
				var obj = $('#tab1 .basePointInput');

				for (var i = 0; i < obj.length; i++) {
					basePointNow[i] = Number(obj.eq(i).val());
				}
				map[0][2] = map[0][2].substr(0, map[0][2].length-1);
				map[0][2] = map[0][2].split(',');
				var data = {
					map:map[0],
					basePoint:basePointNow,
					ability:charaData.getAbilityList(0)
				};

				//終了時処理
				$.ajax({
					type:"POST",
					url:'./getMaxAssessmentStatusPitcher.php',
					timeout: 10000,
					data: JSON.stringify(data)
				}).done(function(data){
					calcMaxAssessmentPitcherModule.finishCalcMaxAssessment(data, parseInt(map[0][1][1]/100));
				}).fail(function(){
					calcMaxAssessmentPitcherModule.ErrorCalcMaxAssessment();
				});
				return;
			}


			var target = targetList[depth],
				mapCount = map.length,
				startTime;

			//mapとtargetListの掛け合わせ
			for (var i = 0; i < mapCount; i++) {
				for (var j = 0; j < target.length; j++) {
					var point = calcMaxAssessmentPitcherModule.getMultArray(map[i][0], target[j].point, expPoint);
					if(point === null){
						continue;
					}
					var val = [map[i][1][0], map[i][1][1]];
					val[target[j].type] = val[target[j].type] + target[j].val;
					var realPoint = calcMaxAssessmentPitcherModule.getRealAssessmentPoint(val, baseNowAssessment, abNowAssessment);
					var totalPoint = calcMaxAssessmentPitcherModule.getTotalPoint(point);
					map[map.length] = [point, val, map[i][2]+target[j].id+',', realPoint, totalPoint];
				}
			}



			//			下位互換の組み合わせを排除
			if (map.length <= MAP_MAX_SIZE && depth <= 15) {
				map.sort(function (m1, m2) {
					return m2[3] - m1[3];
				});
				startTime = +new Date();
				for (var i = 0; i < map.length; i++) {
					for (var j = i+1; j < map.length; j++) {
						var cutFlag = true;
						if (map[j][1][0] <= map[i][1][0] && map[j][1][1] <= map[i][1][1]) {
							if (map[i][4] <= map[j][4]) {
								for (var k = 0; k < map[i][0].length; k++) {
									if (map[i][0][k] > map[j][0][k]) {
										cutFlag = false;
										break;
									}
								}
								if (cutFlag) {
									map.splice(j, 1);
									j--;
								}
							}
						}
					}
					if((+new Date()) - startTime  > 10000) {
						break;
					}
				}
			}

			//足切り処理
			if(map.length >= MAP_MAX_SIZE * 5) {
				//査定値の降順でソート後、上位5000番目までを残す
				map.sort(function (m1, m2) {
					return m2[3] - m1[3];
				});
				map = map.slice(0, MAP_MAX_SIZE);
				startTime = +new Date();
				for (var i = 0; i < map.length; i++) {
					for (var j = i+1; j < map.length; j++) {
						var cutFlag = true;
						if (map[j][1][0] <= map[i][1][0] && map[j][1][1] <= map[i][1][1]) {
							if (map[i][4] <= map[j][4]) {
								for (var k = 0; k < map[i][0].length; k++) {
									if (map[i][0][k] > map[j][0][k]) {
										cutFlag = false;
										break;
									}
								}
								if (cutFlag) {
									map.splice(j, 1);
									j--;
								}
							}
						}
					}
					if((+new Date()) - startTime  > 5000) {
						break;
					}
				}
			}

			var showMessage;
			if (calcMaxAssessmentPitcherModule.outsideFlag) {
				showMessage = '<p>処理中... ' + Math.round((depth + 1)*100/targetList.length) + '%<p>';
				showMessage += '<p>※変化球の構成が査定最大化に対応していないため、変化球査定を0として計算しています</p>';
			} else {
				showMessage = '処理中... ' + Math.round((depth + 1)*100/targetList.length) + '%';

			}
			$('#blockMessage').hide().html(showMessage).show();
			setTimeout(calcMaxAssessmentPitcherModule.RecallMaxAssessment, 0, map, targetList, depth+1, expPoint, baseNowAssessment, abNowAssessment);

		},


		getRealAssessmentPoint: function(array, baseNowAssessment, abNowAssessment){

			var newbaseNowAssessment = pointList[baseNowAssessment + array[0]] * 100;
			var newabNowAssessment = abNowAssessment + array[1];
			return newbaseNowAssessment + newabNowAssessment;
		},


		getMultArray: function (mapPoint, targetPoint, expPoint) {
			var point = [];
			for (var i = 0; i < mapPoint.length; i++) {
				var p = mapPoint[i] + targetPoint[i];
				if (p > expPoint[i]) {
					return null;
				}
				point[i] = p;
			}
			return point;
		},

		getTotalPoint: function(point) {
			var sum = 0;
			for (var i = 0; i < point.length; i++) {
				sum += point[i];
			}
			return sum;
		},


		finishCalcMaxAssessment: function(data, addAssessment) {
			var obj = $('#tab2 .basePointInput');

			//基礎能力
			for(var i = 0; i < data.baseAbility.length; i++) {
				obj.eq(i).val(data.baseAbility[i]);
			}

			//変化球
			obj = $('#tab1 .changeBallType');
			if (obj.length > 0) {
				for (var i = 0; i < obj.length; i++) {
					$('#tab2 .changeBallType').eq(i).val(obj.eq(i).val());
				}

				obj = $('#tab1 .changeBallInput');
				for (var i = 0; i < obj.length; i++) {
					$('#tab2 .changeBallInput').eq(i).val(obj.eq(i).val());
				}
			}


			//特能
			for (var i = 0; i < data.ability.length; i++) {
				charaData.setAbilityList(1, i, data.ability[i]);
			}

			for (var i = 0; i < charaData.getSubPosition(1).length; i++) {
				charaData.setSubPosition(1, i, charaData.getSubPosition(0, i));
			}

			//サブポジキャッチャー
			if(!commonModule.isCatcher() && charaData.getAbilityList(1, 6) !== null) {
				charaData.setSubPosition(1, 0, {id:"1", name:"捕手", color:"0"});
				$('#tab2 .subPositionList a').eq(0).addClass('selectedSubPosition');
			}
			$('#assessmentPointCharaData').html('+' + addAssessment);

			commonModule.calcExpPoint();
			$.unblockUI();
		},

		ErrorCalcMaxAssessment: function () {
			$('#blockMessage').html('エラーが発生しました。電波状態の良い所でやり直してください。');
			$('.blockOverlay').click($.unblockUI).on('click', $.unblockUI);
			setTimeout($.unblockUI, 2000);
		},


		unionBaseAbility: function(list, expPoint, nowAssessment) {
			var newList = [{
				'id':'',
				'type':0,
				'point':[0, 0, 0, 0, 0],
				'val':0
			}];
			var depth = 0;

			while(depth < list.length) {

				var makeCount = newList.length;
				for (var i = 0; i < makeCount; i++) {

					for (var j = 0; j < list[depth].length; j++) {
						var point = [0, 0, 0, 0, 0];
						var addFlag = true;
						for (var e = 0; e < 5; e++) {
							point[e] = newList[i].point[e] + list[depth][j].point[e];
							if (point[e] > expPoint[e]) {
								addFlag = false;
								break;
							}
						}
						var val = newList[i].val + list[depth][j].val;
						var id = newList[i].id + list[depth][j].id + ',';
						if (addFlag) {
							newList.push({
								'id':id,
								'type':0,
								'point':point,
								'val':val
							});
						}
					}
				}
				depth++;
			}
			newList.splice(0, 1);


			newList.sort(function (a, b) {
				return b.val - a.val;
			});

			for (var i = 0; i < newList.length; i++) {
				for (var j = i+1; j < newList.length; j++) {
					var cutFlag = true;
					if (newList[j][1] <= newList[i][1]) {
						for (var k = 0; k < newList[i][0].length; k++) {
							if (newList[i][0][k] > newList[j][0][k]) {
								cutFlag = false;
								break;
							}
						}
						if (cutFlag) {
							newList.splice(j, 1);
							j--;
						}
					}
				}
			}

			for (var i= 0; i < newList.length; i++) {
				var total = newList[i].point.reduce(function(pre, cur) {
					return pre + cur;
				});
				newList[i].id = newList[i].id.substr(0, newList[i].id.length-1);
				newList[i].val = (pointList[newList[i].val+nowAssessment-100] - pointList[nowAssessment-100]) * 100;
				newList[i].eff = newList[i].val / total;
			}

			newList.sort(function (a, b) {
				return b.eff - a.eff;
			});

			var result = [];

			for (var i = 0; i < newList.length; i++) {
				result.push([newList[i]]);
			}


			return result;

		},

	};
})();
