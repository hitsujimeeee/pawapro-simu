/*jslint browser: true*/
/*global $, commonModule, charaData */
/*jslint shadow:true*/

var calcMaxAssessmentModule = (function() {
	var MAP_MAX_SIZE = 15000;
	return {

		//査定最大化
		calcMaxAssessment: function() {
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
				"isCather":commonModule.isCatcher(),
				"isFirst":commonModule.isFirst(),
				"nonMoody":$('#nonMoody').prop("checked"),
				"nonCatcher":$('#nonCatcher').prop("checked")
			};

			$.ajax({
				type:"POST",
				url:'./getTargetList.php',
				timeout: 10000,
				data: JSON.stringify(data)
			}).done(function(data){
				var map = [[[0, 0, 0, 0], [0, 0], '', 0, 0]];

				//現在の査定がマイナスの時に挙動がおかしくなるのを回避
				var nowAssessment = calcMaxAssessmentModule.getRealAssessmentPoint([0, 0], data.baseNowAssessment, data.abNowAssessment);
				if (nowAssessment < 0) {
					map[0][3] = nowAssessment;
				}

				expPoint.splice(3, 1);
				calcMaxAssessmentModule.optimiseTargetList(data.targetList);
				calcMaxAssessmentModule.RecallMaxAssessment(map, data.targetList, 0, expPoint, data.baseNowAssessment, data.abNowAssessment);
			}).fail(function(){
				calcMaxAssessmentModule.ErrorCalcMaxAssessment();
			});
		},



		RecallMaxAssessment: function(map, targetList, depth, expPoint, baseNowAssessment, abNowAssessment) {
			//最後の階層の場合
			if(depth == targetList.length) {

				map.sort(function (m1, m2) {
					return calcMaxAssessmentModule.getRealAssessmentPoint(m2[1], baseNowAssessment, abNowAssessment) - calcMaxAssessmentModule.getRealAssessmentPoint(m1[1], baseNowAssessment, abNowAssessment);
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
					url:'./getMaxAssessmentStatus.php',
					timeout: 10000,
					data: JSON.stringify(data)
				}).done(function(data){
					calcMaxAssessmentModule.finishCalcMaxAssessment(data);
				}).fail(function(){
					calcMaxAssessmentModule.ErrorCalcMaxAssessment();
				});
				return;
			}


			var target = targetList[depth],
				mapCount = map.length;

			//mapとtargetListの掛け合わせ
			for (var i = 0; i < mapCount; i++) {
				for (var j = 0; j < target.length; j++) {
					var point = calcMaxAssessmentModule.getMultArray(map[i][0], target[j].point, expPoint);
					if(point === null){
						continue;
					}
					var val = [map[i][1][0], map[i][1][1]];
					val[target[j].type] = val[target[j].type] + target[j].val;
					var realPoint = calcMaxAssessmentModule.getRealAssessmentPoint(val, baseNowAssessment, abNowAssessment);
					var totalPoint = calcMaxAssessmentModule.getTotalPoint(point);
					map[map.length] = [point, val, map[i][2]+target[j].id+',', realPoint, totalPoint];
				}
			}



//			下位互換の組み合わせを排除
			if (map.length <= MAP_MAX_SIZE && depth <= 15) {
				map.sort(function (m1, m2) {
					return m2[3] - m1[3];
				});
				calcMaxAssessmentModule.cutUnderInterchangeable(map);
			}

			//足切り処理
			if(map.length >= MAP_MAX_SIZE * 5) {
				//査定値の降順でソート後、上位5000番目までを残す
				map.sort(function (m1, m2) {
					return m2[3] - m1[3];
				});
				map = map.slice(0, MAP_MAX_SIZE);
				calcMaxAssessmentModule.cutUnderInterchangeable(map);
			}

			$('#blockMessage').hide().html('処理中... ' + Math.round((depth + 1)*100/targetList.length) + '%' ).show();
			setTimeout(calcMaxAssessmentModule.RecallMaxAssessment, 0, map, targetList, depth+1, expPoint, baseNowAssessment, abNowAssessment);

		},

		optimiseTargetList: function(targetList) {
			var newTargetList = targetList.map(function(arr) {
				var list = arr;
				for (var i = 0; i < arr.length; i++) {
					for (var j = i + 1; j < arr.length; j++) {
						if (arr[j].val <= arr[i].val && arr[j].total >= arr[i].total) {
							var cutFlag = true;
							for (var k = 0; k < 4; k++) {
								if (arr[i].point[k] > arr[j].point[k]) {
									cutFlag = false;
									break;
								}
							}
							if (cutFlag) {
								list.splice(j, 1);
								j--;
							}
						}
					}
				}
				return list;
			});
			return newTargetList;
		},

		cutUnderInterchangeable: function(map) {
			var startTime = +new Date();
			for (var i = 0; i < map.length - 1; i++) {
				for (var j = i+1; j < map.length && map[j][3] + 784 > map[i][3]; j++) {
					if (map[j][1][0] <= map[i][1][0] && map[j][1][1] <= map[i][1][1] && map[i][4] <= map[j][4]) {
						var cutFlag = true;
						for (var k = 0; k < 4; k++) {
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
				for (var j = map.length-1; map[j][3] + 784 <= map[i][3]; j--) {
					if (map[i][4] <= map[j][4]) {
						var cutFlag = true;
						for (var k = 0; k < 4; k++) {
							if (map[i][0][k] > map[j][0][k]) {
								cutFlag = false;
								break;
							}
						}
						if (cutFlag) {
							map.splice(j, 1);
						}
					}
				}
				if((+new Date()) - startTime  > 15000) {
					break;
				}
			}
		},


		getRealAssessmentPoint: function(array, baseNowAssessment, abNowAssessment){
			var newbaseNowAssessment = baseNowAssessment + array[0];
			var newabNowAssessment = abNowAssessment + array[1];
			return newbaseNowAssessment + 784 * Math.round(newbaseNowAssessment/4704) + 1127 + newabNowAssessment;
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


		finishCalcMaxAssessment: function(data) {
			var obj = $('#tab2 .basePointInput');

			//基礎能力
			for(var i = 0; i < data.baseAbility.length; i++) {
				obj.eq(i).val(data.baseAbility[i]);
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
				var option = '';
				option = !charaData.getSubPosition(0, 0) ? '<span class="changeTypeStr">new</span>' : (charaData.getSubPosition(0, 0).id != charaData.getSubPosition(1, 0).id ? '<span class="changeTypeStr"><i class="fa fa-level-up changeIcon" aria-hidden="true"></i><i class="fa fa-level-up changeIcon" aria-hidden="true"></i></span>' : '');
				$('#tab2 .displaySubPosition > ul > li').eq(0).addClass('catcher');
				$('#tab2 .displaySubPosition > ul > li').eq(0).find('.displayName').html('捕手' + option);
			}

			//サブポジファースト
			if(!commonModule.isFirst() && charaData.getAbilityList(1, 147) !== null) {
				charaData.setSubPosition(1, 1, {id:"4", name:"一塁", color:"1"});
				var option = '';
				option = !charaData.getSubPosition(0, 1) ? '<span class="changeTypeStr">new</span>' : (charaData.getSubPosition(0, 1).id != charaData.getSubPosition(1, 1).id ? '<span class="changeTypeStr"><i class="fa fa-level-up changeIcon" aria-hidden="true"></i><i class="fa fa-level-up changeIcon" aria-hidden="true"></i></span>' : '');
				$('#tab2 .displaySubPosition > ul > li').eq(1).addClass('first');
				$('#tab2 .displaySubPosition > ul > li').eq(1).find('.displayName').html('一塁' + option);
			}
			
			//サブポジセカンド
			if(!commonModule.isSecond() && charaData.getAbilityList(1, 150) !== null) {
				charaData.setSubPosition(1, 2, {id:"7", name:"二塁", color:"1"});
				var option = '';
				option = !charaData.getSubPosition(0, 2) ? '<span class="changeTypeStr">new</span>' : (charaData.getSubPosition(0, 2).id != charaData.getSubPosition(1, 2).id ? '<span class="changeTypeStr"><i class="fa fa-level-up changeIcon" aria-hidden="true"></i><i class="fa fa-level-up changeIcon" aria-hidden="true"></i></span>' : '');
				$('#tab2 .displaySubPosition > ul > li').eq(2).addClass('second');
				$('#tab2 .displaySubPosition > ul > li').eq(2).find('.displayName').html('二塁' + option);
			}		

			commonModule.calcExpPoint();
			$.unblockUI();
		},

		ErrorCalcMaxAssessment: function () {
			$('#blockMessage').html('エラーが発生しました。電波状態の良い所でやり直してください。');
			$('.blockOverlay').click($.unblockUI).on('click', $.unblockUI);
			setTimeout($.unblockUI, 2000);
		},

	};
})();
