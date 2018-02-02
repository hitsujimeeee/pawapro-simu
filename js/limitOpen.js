/*jslint browser: true, jquery: true */
/*jslint shadow:true*/


$(function(){
	var table = $('.perData');
	var trs = table.find('tr:not(:first-child)');
	for (var i = 0; i < trs.length; i++) {
		var tds = trs.eq(i).find('td');
		for (var j = 0; j < tds.length; j++) {
			tds.eq(j).html(Math.round(limitOpen.perList[i][j]*10000)/100+'%');
		}
	}
});


var limitOpen = {

	perList: [
		[1, 0.5, 2.3, 0.3, 0.3, 1.3, 0.05, 0.05, 0.15, 0.005, 0.005, 0.005],
		[1, 1, 3, 1, 0.5, 2.3, 0.3, 0.3, 1.3, 0, 0, 0],
		[1, 1, 3, 1, 1, 3, 1, 0.5, 2.3, 0.3, 0.3, 1.3]
	],
	OVER_MESSAGE: '<p>強化素材の枚数が多いため処理を行えません。</p><p>枚数を減らすか、素材合成を行ってください。</p>',

	outputResult: function() {
		ga('send', 'event', 'action', 'click', 'limitOpen/outputResult');
		var cards = [];
		var str = '';
		var targetLevel = $('#targetLevel').prop('selectedIndex');
		var targetRarelity = $('#targetRarelity').prop('selectedIndex');
		for (var i = 0; i < $('.cardCount').length; i++) {
			cards[i] = Number($('.cardCount').eq(i).val());
		}

		var cardCount = cards.reduce(function(x, y) {
			return x + y;
		});

		if (cardCount > 10000) {
			$('#hukidashi').html(limitOpen.OVER_MESSAGE);
			return;
		}

		var optCards;

		if ($('#optimise').prop('checked')) {
			var optValue = Number($('#optimiseValue').val());
			if (optValue < 0 || optValue >= 100) {
				$('#hukidashi').html('閾値は0%以上100%未満に設定してください');
				return;
			}

			optCards = this.optimiseCard(this.arrayCopy(cards), targetRarelity, optValue);
			if (cards.toString() !== optCards.toString()) {
				var nameList = ['PSR', 'PSR(別ver)', 'PSR+5', 'SR', 'SR(別ver)', 'SR+5', 'PR', 'PR(別ver)', 'PR+5', 'R', 'R(別ver)', 'R+5'];
				str += '<div class="optDispArea">';
				str += '<p>強化素材の合成を行いました。</p>';
				for (var i = 0; i < nameList.length/3; i++) {
					str += '<p>' + nameList[i*3] + ': ' + optCards[i*3] + '枚, ' + nameList[i*3+1] + ': ' + optCards[i*3+1] + '枚, ' + nameList[i*3+2] + ': ' + optCards[i*3+2] + '枚, ';
				}
				str += '<p>で処理を開始します</p>';
				str += '</div>';
			}
		} else {
			optCards = cards;
		}

		var feeds = this.getFeedList(optCards, targetRarelity);
		var confirmCount = 0;

		for (var i = 0; i < feeds.length; i++) {
			if (feeds[i] >= 1) {
				confirmCount++;
			}
		}

		if (this.nCr(feeds.length, 5-confirmCount-targetLevel) > 1500000) {
			$('#hukidashi').html(limitOpen.OVER_MESSAGE);
			return;
		}

		var ret = this.calc(feeds, targetLevel);

		var maxIndex = 0;
		for (var i = 0; i < ret.pArray.length; i++) {
			if (ret.pArray[i] >= ret.pArray[maxIndex]) {
				maxIndex = i;
			}
		}

		if (ret.pArray.length === 1 && ret.confirmCount === 0) {
			str += '<p>この合成素材では上限開放できません。</p>';
		} else {
			for (var i = 0; i < ret.pArray.length; i++) {
				str += '<p' + (i === maxIndex ? ' class="redColor"' : '') + '>+' + (i + ret.confirmCount) + '開放の確率は' + ret.pArray[i] + '%です。</p>';
			}
		}


		$('#hukidashi').html(str);

	},


	calc: function(feeds, targetLevel) {
		var confirmCount = 0;

		for (var i = 0; i < feeds.length; i++) {
			while (feeds[i] >= 1) {
				confirmCount++;
				feeds[i] -= 1;
			}
		}


		feeds = feeds.filter(function(elt){
			return elt > 0;
		});

		var pArray = [];
		var tryCount = Math.min(feeds.length, 5 - confirmCount - targetLevel);


		if (tryCount <= 0) {
			var resultSet = {
				pArray:[100],
				confirmCount: 5 - targetLevel >= confirmCount ? confirmCount : 5 - targetLevel
			};
			return resultSet;
		}

		for (var i = 0; i < tryCount; i++) {
			var combList = [];

			this.makeCombination(combList, feeds, [], 0, i);
			var p = 0;
			for (var j = 0;j < combList.length; j++) {
				p += combList[j].reduce(function(x, y){
					return x * y;
				});
			}
			pArray[i] = Math.round(p * 10000) / 100;
		}

		var pTotal = 0;
		if (pArray.length > 0) {
			pTotal = pArray.reduce(function(x, y){
				return x + y;
			});
		}

		pArray[pArray.length] = Math.round((100-pTotal)*1000)/1000;
		var resultSet = {
			pArray: pArray,
			confirmCount: confirmCount
		};

		return resultSet;

	},

	getFeedList: function(cards, rarelity) {
		var list = [];
		for (var i = 0; i < cards.length; i++) {
			var count = cards[i];
			if (this.perList[rarelity][i] !== 0) {
				for (var j = 0; j < count; j++) {
					list.push(this.perList[rarelity][i]);
				}
			}
		}
		return list;
	},

	makeCombination: function(combList, feeds, arr, depth, hitCount){
		if (depth >= feeds.length) {
			if (hitCount === 0) {
				combList.push(arr);
			}
			return;
		}

		if (hitCount > 0) {
			this.makeCombination(combList, feeds, this.arrayCopyPush(arr, feeds[depth]), depth+1, hitCount-1);
		}
		this.makeCombination(combList, feeds, this.arrayCopyPush(arr, 1-feeds[depth]), depth+1, hitCount);
	},

	optimiseCard: function(cards, targetRarelity, optValue) {
		for (var i = cards.length/3-1; i >= 0; i--) {
			if (i <= targetRarelity) {
				continue;
			}

			//上位があって、下位で+5に出来る可能性がある場合
			if ((cards[i*3] > 0 || cards[i*3+1]) && cards[(i+1)*3]+cards[(i+1)*3+1]+cards[(i+1)*3+2]*3 >= 5) {
				for (var x = 0; x <= Math.min(cards[(i+1)*3+2], 5); x++) {
					var tempCards = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
					tempCards[(i+1)*3+2] = x;
					var ret = this.calc(this.getFeedList(tempCards, i), 0);
					if (ret.pArray.length-1 >= 5-ret.confirmCount && ret.pArray[5-ret.confirmCount] >= optValue) {
						if (cards[i*3+1] > 0) {
							cards[i*3+1]--;
						} else {
							cards[i*3]--;
						}
						cards[i*3+2]++;
						cards[(i+1)*3+2] -= x;
						i++;
						break;
					}

					if (x === cards[(i+1)*3+2] || x >= 3) {
						var stopFlag = false;
						var targetVersion;
						//別verの回素材が多くて、かつ別verの上位がある場合、別verの上位を+5にするように処理
						if (cards[(i+1)*3+1] > cards[(i+1)*3] && cards[i*3+1] > 0) {
							targetVersion = 1;
						} else {
							targetVersion = 0;
						}

						for (var y = 1; y <= cards[(i+1)*3]+cards[(i+1)*3+1]; y++) {
							var tempCards = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
							tempCards[(i+1)*3+2] = x;
							if (targetVersion === 0) {
								tempCards[(i+1)*3] = Math.min(y, cards[(i+1)*3]);
								tempCards[(i+1)*3+1] = y > cards[(i+1)*3] ? y -cards[(i+1)*3] : 0;
							} else {
								tempCards[(i+1)*3] = Math.min(y, cards[(i+1)*3+1]);
								tempCards[(i+1)*3+1] = y > cards[(i+1)*3+1] ? y -cards[(i+1)*3+1] : 0;
							}

							var ret = this.calc(this.getFeedList(tempCards, i), 0);
							if (ret.pArray.length-1 >= 5-ret.confirmCount && ret.pArray[5-ret.confirmCount] >= optValue) {
								cards[i*3+targetVersion]--;
								cards[i*3+2]++;
								cards[(i+1)*3+2] -= x;
								if (targetVersion === 0) {
									cards[(i+1)*3+1] -= y > cards[(i+1)*3] ? y -cards[(i+1)*3] : 0;
									cards[(i+1)*3] -=  Math.min(y, cards[(i+1)*3]);
								} else {
									cards[(i+1)*3] -= y > cards[(i+1)*3+1] ? y -cards[(i+1)*3+1] : 0;
									cards[(i+1)*3+1] -=  Math.min(y, cards[(i+1)*3+1]);
								}
								i++;
								stopFlag = true;
								break;
							}
						}
						if (stopFlag) {
							break;
						}
					}
				}
			}
		}
		return cards;
	},


	arrayCopyPush: function(arr, add) {
		var result = this.arrayCopy(arr);
		result[result.length] = add;
		return result;
	},

	arrayCopy: function(arr) {
		var result = [];
		for (var i = 0; i < arr.length; i++) {
			result[i] = arr[i];
		}
		return result;
	},

	permutation: function(n, r){
		for (var i = 0, res = 1; i < r; i++) {
			res *= n - i;
		}
		return res;
	},

	nCr: function(n, r) {
		return this.permutation(n, r) / this.permutation(r, r);
	},

	syncCheckText: function(id, check) {
		$('#' + id).prop('disabled', !check);
	}

};
