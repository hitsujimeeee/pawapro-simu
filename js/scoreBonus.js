/* jshint jquery:true, browser:true */


$(function(){
	$('.teamInput').on('change', function(){
		scoreBonus.updateBatterScore();
		scoreBonus.updatePitcherScore();
	});

	$('.batterOperate').on('change', scoreBonus.updateBatterScore);
	$('.pitchingOperate').on('change', scoreBonus.updatePitcherScore);
	scoreBonus.updateBatterScore();
	scoreBonus.updatePitcherScore();
});


var scoreBonus = {

	calcScoreBonus: function() {
		var teamRank = Number($('#teamRank').val());
		var limitBonus = Number($('#limitBonus').val());

		var mag = (1 + (teamRank / 20000)) * (1 + limitBonus / 100);
		var weakMag = (1 + (teamRank - 1500) / 20000) * (1 + limitBonus / 100);
		var pwflMag = (1 + (teamRank + 1000) / 20000) * (1 + limitBonus / 100);

		$('#scoreMag').html((mag*100).toFixed(0)+'%');
		$('#scoreMagWeak').html((weakMag*100).toFixed(0)+'%');
		$('#scoreMagPwfl').html((pwflMag*100).toFixed(0)+'%');
		$('#scoreSimulate').html(Math.floor(pwflMag*10000).toFixed(0)+'pt');

		return {
			mag: mag,
			weakMag: weakMag,
			pwflMag: pwflMag
		};

	},

	updateBatterScore: function() {
		var ret = scoreBonus.calcScoreBonus();
		var str = '';
		var opponent = Number($('#battingOpponent').val());
		var result = Number($('#battingResult').val());
		var score = Number($('#battingScore').val());
		var changeBall = Number($('#battingChangeBall').val());
		var scene = Number($('#battingScene').val());
		var sayonara = Number($('#battingSayonara').val());
		var bonus = [ret.weakMag, ret.pwflMag, ret.mag][opponent];

		str += (changeBall === 0 ? 'ストレート' : '変化量' + $('#battingChangeBall option:selected').text()) + 'を';
		str += $('#battingResult option:selected').text() + 'にした時(打点' + Number($('#battingScore option:selected').text()) +
			(scene === 0 ? '' : ',' + $('#battingScene option:selected').text()) +
			(sayonara === 0 ? '' : ',サヨナラ') +
			')のスコアは<span>';
		str += Math.floor((result + score + changeBall + scene + sayonara) * bonus);
		str += 'pt</span>です。';
		$('#battingDisplay').html(str);
	},

	updatePitcherScore: function() {
		var ret = scoreBonus.calcScoreBonus();
		var str = '';
		var opponent = Number($('#pitchingOpponent').val());
		var result = Number($('#pitchingResult').val());
		var strike = Number($('#pitchingStrike').val());
		var runner = Number($('#pitchingRunner').val());
		var outCount = Number($('#pitchingOutCount').val());
		var bonus = [ret.weakMag, ret.pwflMag, ret.mag][opponent];

		str += 'ランナー' + $('#pitchingRunner option:selected').text() + 'で、' + $('#pitchingResult option:selected').text() +
			'に抑えた時(' + $('#pitchingStrike option:selected').text() +
			'ストライク、' + $('#pitchingOutCount option:selected').text() +
			'アウト)のスコアは<span>';
		str += Math.floor((result + runner + outCount + strike) * bonus);
		str += 'pt</span>です。';
		$('#pitchingDisplay').html(str);
	},

	sendTwitter: function() {
		var str = 'http://twitter.com/share?url=http://studiowool.webcrow.jp/products/pawapro/php/scoreBonus.php&text=';
		var teamRank = Number($('#teamRank').val());
		var limitBonus = Number($('#limitBonus').val());
		var ret = scoreBonus.calcScoreBonus();
		str += '【パワプロアプリ　スコアボーナスチェッカー】%0aあなたのチームのスコア倍率は' + (ret.mag*100).toFixed(0) + '％です。%0a' +
			'チーム総合力: ' + teamRank + '%0a上限突破ボーナス: ' + limitBonus + '％%0a%0a';

		$('.shareLink').attr('href', str);
		$('.shareLink')[0].click();
	}
};
