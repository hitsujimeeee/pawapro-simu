/*jslint browser: true, jquery: true, shadow:true */
/* global d3, ga */


$(function(){
	$('.sRate').eq(0).val(0.5);
	$('.sRate').eq(1).val(3);
	$('.sRate').eq(2).val(20.95);
	$('.sRate').eq(3).val(75.55);
//	$('#pCount').eq(0).val(3);
//	$('#allCount').eq(0).val(100);
//	$('#pRate').eq(0).val(31.04);
});


var moneyCalc = {

	calc: function() {

		ga('send', 'event', 'action', 'click', 'moneyCalc/calc');
		moneyCalc.showBlockMessage('<div id="blockMsg"><i class="fa fa-spinner fa-pulse"></i> <span id="blockMessage">処理中...</span><div id="errorMsg"></div></div>');
		setTimeout(moneyCalc.calcMain, 500);

	},

	calcMain: function() {



		//入力値取得
		var target = Number($('#targetRarelity').val()),
			ownStatus = Number($('#ownStatus').val()),
			sRates = $('.sRate').map(function(idx, elm){
				return Number($(elm).val())/100;
			}),
			allCount = Number($('#allCount').val()),
			pCount = Number($('#pCount').val()),
			pRate = Number($('#pRate').val())/100,
			confCount = Number($('#confCount').val()) || 0,
			confRarelity = Number($('#confRarelity').val()) || 0,
			confType = Number($('input[name=confType]:checked').val()),
			mixFlag = $('#mixFlag').prop('checked'),
			simFlag = $('#simFlag').prop('checked'),
			psrseed = $('#psrseed').prop('checked');



		if (allCount+pCount <= 0) {
			d3.select('#chartArea').select("svg").remove();
			$('#displayArea').html('<i class="fa fa-warning" style="color:#f00"></i>ガチャから出現するイベキャラ数を入力してください。');
			$.unblockUI();
			return;
		}


		var perList = [
			[1, 0.3, 0.05, 0.005],
			[1, 1, 0.3, 0]
		];
		var SIMU_MAX_COUNT = simFlag ? 10000 : 1;
		var simuCount = SIMU_MAX_COUNT;
		var sampling = [];
		var botaiSampling = [];
		var chraGetRate = pCount === 0 ? 1 / allCount : pRate/pCount;

		ownStatus = (ownStatus === 0 ? null : ownStatus - 1);

		while(simuCount > 0) {
			var tryCount = 0;
			var cards = [0, 0, 0, 0];
			var limitOpen = ownStatus;
			var srG = null;
			var prtoSR = 0;
			var prG = null;


			while(true) {


				//ガチャを10連分引く
				for (var i = 0; i < 10; i++) {
					var p = Math.random();
					var totalp = 0;
					for (var j = sRates.length - 1; j >= 0; j--) {

						//レアリティ判定
						if (p < totalp + sRates[j]) {
							var rarelity = j;
							if (i < confCount && confRarelity + 1 < j) {
								rarelity = confRarelity + 1;
							}
							var pn = Math.random();

							//対象キャラが当たるか
							if (i < confCount && confType === 1) {
								// 1/ピックアップキャラ数の確率
								if(pn < 1 / pCount) {
									cards[rarelity]++;
								}
							} else {
								// pickup率/ピックアップキャラ数の確率
								if(pn < chraGetRate) {
									cards[rarelity]++;
								}
							}

							break;
						}
						totalp += sRates[j];
					}
				}


				tryCount += 10;

				//初母体確保時に処理
				if (limitOpen === null && cards[target] > 0)  {
					cards[target]--;
					limitOpen = 0;
					botaiSampling[botaiSampling.length] = tryCount;
				}

				if (limitOpen !== null) {

					//素材合成
					if (mixFlag) {
						switch(target) {
							case 0:
								//PSR50狙いの場合
								while(cards[3] > 0) {

									//PRの合成用が無ければ確保
									if (prG === null) {
										if(cards[2] > 0) {
											cards[2]--;
											prG = 0;
										} else {
											//PR持ってなければ終了
											break;
										}
									}


									var lp = Math.random();
									if (lp < 0.3) {
										prG++;
									}
									cards[3]--;
									if (prG >= 5) {
										prtoSR++;
										prG = null;
									}
								}

								//PR+5をSRの合成用に混ぜる
								while(prtoSR > 0 && (srG !== null || cards[1] > 0)) {
									//SRの合成用が無ければ確保
									if (srG === null) {
										if(cards[1] > 0) {
											cards[1]--;
											srG = 0;
										}
									}
									var lp = Math.random();
									if (lp < 0.3) {
										srG += 2;
									} else {
										srG++;
									}
									if (srG >= 5) {
										lp = Math.random();
										if (lp < 0.3) {
											limitOpen += 2;
										} else {
											limitOpen++;
										}
										srG = null;
									}

									prtoSR--;
								}


								while(cards[2] > 1) {

									//SRの合成用が無ければ確保
									if (srG === null) {
										if(cards[1] > 0) {
											cards[1]--;
											srG = 0;
										} else {
											//SR持ってなければ終了
											break;
										}
									}

									var lp = Math.random();
									if (lp < 0.3) {
										srG++;
									}
									cards[2]--;
									if (srG >= 5) {
										lp = Math.random();
										if (lp < 0.3) {
											limitOpen += 2;
										} else {
											limitOpen++;
										}
										srG = null;
									}
								}
								break;
							case 1:
								//SR45狙いの場合
								while(cards[3] > 0) {

									//PRの合成用が無ければ確保
									if (prG === null) {
										if(cards[2] > 0) {
											cards[2]--;
											prG = 0;
										} else {
											//PR持ってなければ終了
											break;
										}
									}


									var lp = Math.random();
									if (lp < 0.3) {
										prG++;
									}
									cards[3]--;
									if (prG >= 5) {
										lp = Math.random();
										if (lp < 0.3) {
											limitOpen += 2;
										} else {
											limitOpen++;
										}
										prG = null;
									}
								}

								break;
						}
					}

					//実際に混ぜてくとこ
					for (var i = 0; i < cards.length; i++) {

						//上限開放率0%なら処理しない
						if (perList[target][i] === 0) {
							continue;
						}

						//PSRをSRの素材にするフラグがOFFなら処理しない
						if (!psrseed && i === 0) {
							continue;
						}

						while (cards[i] > 0) {
							if (mixFlag && i === 2 && cards[i] === 1) {
								break;
							}
							var lp = Math.random();
							if (lp < perList[target][i]) {
								limitOpen++;
							}
							cards[i]--;
						}
					}
				}
				if(limitOpen >= 5) {
					break;
				}

			}
			simuCount--;
			sampling[sampling.length] = tryCount;
		}


		var compS = moneyCalc.makeStatistic(sampling, SIMU_MAX_COUNT, 'skyblue');
		var botaiS = ownStatus === null ? moneyCalc.makeStatistic(botaiSampling, SIMU_MAX_COUNT, 'orange') : null;

		var disp = $('#displayArea');
		var str = '';

		str += '<h4>▼シミュレーション結果</h4>';
		str += '<div class="mainText">';
		if (simFlag) {
			str += '平均して' + Math.round(compS.average) + '回のガチャで目標を達成しました(金額:&yen' + moneyCalc.separate(Math.round(compS.average / 30 * 9800)) + ')<br>';
			str += '中央値は' + compS.center + '回です(金額:&yen' + moneyCalc.separate(Math.round(compS.center / 30 * 9800)) + ')<br>';
			str += '最頻値は' + compS.frequency + '回です(金額:&yen' + moneyCalc.separate(Math.round(compS.frequency / 30 * 9800)) + ')<br>';
			str += '最小回数は' + compS.min + '回です(金額:&yen' + moneyCalc.separate(Math.round(compS.min / 30 * 9800)) + ')<br>';
			str += '最大回数は' + compS.max + '回です(金額:&yen' + moneyCalc.separate(Math.round(compS.max / 30 * 9800)) + ')<br>';
			str += '標準偏差は' + Math.round(compS.hensa) + '回です<br><br>';
			if(botaiS) {
				str += '母体確保の平均は' + Math.round(botaiS.average) + '回です(金額:&yen' + moneyCalc.separate(Math.round(botaiS.average / 30 * 9800)) + ')<br>';
				str += '母体確保の中央値は' + botaiS.center + '回です(金額:&yen' + moneyCalc.separate(Math.round(botaiS.center / 30 * 9800)) + ')<br>';
			}
		} else {
			str += compS.total + '回目のガチャで目標を達成しました。(金額:\\' + moneyCalc.separate(Math.round(compS.total / 30 * 9800)) + ')<br>';
			if(botaiS) {
				str += botaiS.total + '回目のガチャで母体を確保しました。<br>';
			}
		}
		str += '</div>';

		disp.html(str);


		if (simFlag) {
			moneyCalc.displayGraph(compS.plot, compS.max, compS.countList[compS.frequency], compS, '#compChartArea');
//			if(botaiS) {
//				moneyCalc.displayGraph(botaiS.plot, botaiS.max, botaiS.countList[botaiS.frequency], botaiS, '#botaiChartArea');
//			}
			d3.select('#chartArea').select("svg").remove();
		} else {
			d3.select('#chartArea').select("svg").remove();
		}

		$.unblockUI();

	},

	makeStatistic: function(sampling, MAX_COUNT, plotColor){

		sampling.sort(function(x, y){
			return parseInt(x, 10) > parseInt(y, 10) ? 1 : -1;
		});

		//合計
		var total = sampling.reduce(function(pre, cur){
			return pre + cur;
		});
		//平均
		var average = total/MAX_COUNT;

		//中央値
		var centerValue = (sampling[parseInt(MAX_COUNT/2, 10)]+sampling[parseInt(MAX_COUNT/2, 10)-1])/2;

		//最大最小
		var max = sampling[sampling.length-1];
		var min = sampling[0];

		//標準偏差
		var bunsan = 0;
		for (var i = 0; i < sampling.length; i++) {
			bunsan += Math.pow(sampling[i] - average, 2);
		}
		var hensa = Math.sqrt(bunsan/MAX_COUNT);

		//出現頻度のリスト作成
		var samplingCountList = [];
		for (var i = 0; i < sampling.length; i++) {
			var idx = sampling[i];
			if (!samplingCountList[idx]) {
				samplingCountList[idx] = 0;
			}
			samplingCountList[idx]++;
		}

		//最頻値
		var frequency = null;
		for (var key in samplingCountList) {
			if (frequency === null || samplingCountList[key] > samplingCountList[frequency]) {
				frequency = key;
			}
		}


		var plot = [{'回数':0, '出現数':0, '色': plotColor}];
		var ruiseki = [{'回数':0, '累積比率':0}];
		var ruisekiTotal = 0;

		for (var key in samplingCountList) {
			ruisekiTotal += samplingCountList[key];
			ruiseki.push({'回数':parseInt(key, 10), '累積比率':ruisekiTotal*100/MAX_COUNT});
			plot.push({
				'回数':parseInt(key, 10),
				'出現数':samplingCountList[key],
				'色': plotColor
			});
		}


		return {
			total: total,
			average: average,
			center: centerValue,
			max: max,
			min: min,
			hensa: hensa,
			frequency: frequency,
			countList: samplingCountList,
			ruiseki: ruiseki,
			plot: plot
		};

	},

	displayGraph: function(data, xMax, yMax, statistics, targetArea) {

		// 軸の分も表示されるように、マージンを作っておく。
		var margin = {top: 20, right: 40, bottom: 60, left: 40},
			width =  Math.min(640, parseInt(window.innerWidth*0.8, 10)) - margin.left - margin.right,
			height = width*2/3 - margin.top - margin.bottom;

		d3.select(targetArea).select("svg").remove();

		// transfromでマージンの分だけ位置をずらしている。
		var svg = d3.select(targetArea)
		.append("svg")
		.attr("width", width + margin.left + margin.right)
		.attr("height", height + margin.top + margin.bottom)
		.append("g")
		.attr("transform", "translate(" + margin.left + "," + margin.top + ")");


		//スケール設定
		var xScale = d3.scale.linear()
		.domain([0,xMax])
		.range([0,width]);

		var yLeftScale = d3.scale.linear()
		.domain([0,Math.round(yMax*1.1)])
		.range([height,0]);

		var yRightScale = d3.scale.linear()
		.domain([0,100])
		.range([height,0]);

		// 軸を設定する。
		var xAxis = d3.svg.axis()
		.scale(xScale)
		.orient("bottom")
		.tickSize(6, -height) // 棒の長さと方向。
		.tickFormat(function(d){ return d; }); // 数字に年をつけている。

		var yLeftAxis = d3.svg.axis()
		.ticks(5) // 軸のチックの数。
		.scale(yLeftScale)
		.orient("left")
		.tickSize(6, -width);

		var yRightAxis = d3.svg.axis()
		.ticks(5) // 軸のチックの数。
		.scale(yRightScale)
		.orient("right")
		.tickSize(6, -width)
		.tickFormat(function(d){ return d+'%'; });



		//累積比率の描画
		var ruisekiLine = d3.svg.line()
			.x(function(d) { return xScale(d["回数"]); })
			.y(function(d) { return yRightScale(d["累積比率"]); })
			.interpolate("cardinal"); // 線の形を決める。
		svg.append("path")
			.datum(statistics.ruiseki)
			.attr("class", "line")
			.attr("d", ruisekiLine);



		//散布図描画
		svg.selectAll("circle")
			.data(data)
			.enter()
			.append("circle")
			.attr("r",2)
			.attr("fill", function(d){ return d["色"]; })
			.attr("cx", function(d){ return xScale(d["回数"]); })
			.attr("cy", function(d){ return yLeftScale(d["出現数"]); });



		//出現頻度軸描画
		svg.append("g")
			.attr("class", "y axis")
			.call(yLeftAxis)
			.append("text")
			.attr("y", -10)
			.attr("x",10)
			.style("text-anchor", "end")
			.text("出現頻度");


		// 累積比率の軸描画
		svg.append("g")
			.attr("class", "y axis")
			.attr('transform', 'translate(' + width + ' ,0)')
			.call(yRightAxis)
			.append("text")
			.attr("y", -10)
			.attr("x",10)
			.style("text-anchor", "end")
			.text("累積比率");


		//x軸描画
		svg.append("g")
			.attr("class", "x axis")
			.attr("transform", "translate(0," + height + ")")
			.call(xAxis)
			.append("text")
			.text("ガチャ回数")
			.attr("x", width-50)
			.attr("y", 30);


		//中央値描画
		var carray = [[width*(statistics.center/xMax), 0], [width*(statistics.center/xMax), height]];
		var line = d3.svg.line()
			.x(function(d){return d[0];})
			.y(function(d){return d[1];});

		svg.append('path')
			.attr({
				'd': line(carray),
				'stroke': 'red',
				'stroke-width': 1
		});

		svg.append("text").attr({
			x:  width*(statistics.center/xMax)+10,
			y: 45,
			fill:'#f00',
			'font-size': '0.8em'
		}).text("中央値");

		//平均値描画
		carray = [[width*(statistics.average/xMax), 0], [width*(statistics.average/xMax), height]];
		line = d3.svg.line()
		.x(function(d){return d[0];})
		.y(function(d){return d[1];});

		svg.append('path')
			.attr({
			'd': line(carray),
			'stroke': 'green',
			'stroke-width': 1,
		});

		svg.append("text").attr({
			x:  width*(statistics.average/xMax)+10,
			y: 60,
			fill:'green',
			'font-size': '0.8em'
		}).text("平均値");

	},

	separate: function(n){
		return String(n).replace( /(\d)(?=(\d\d\d)+(?!\d))/g, '$1,');
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


};
