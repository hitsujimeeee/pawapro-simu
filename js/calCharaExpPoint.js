/*jslint shadow:true, browser: true, jquery: true */
$(function(){
	$('#nowLv, #restNextLv, #targetLv, .canUseFlag, #doSuperExp').on('change', calcCharaExpPoint.calc);
});

var calcCharaExpPoint = {
	calc: function() {
		var nowLv = parseInt($('#nowLv').val(), 10) || 0;
		var restNextLv = parseInt($('#restNextLv').val(), 10) || 0;
		var targetLv = parseInt($('#targetLv').val(), 10) || 0;

		if(!nowLv || !restNextLv){
			return;
		}

		var expList = $('#expList tr td:nth-child(2)').map(function(idx, elt){
			return parseInt($(elt).html(), 10);
		}).get();

		var nowExpPoint = calcCharaExpPoint.getTotalExp(expList, nowLv+1) -restNextLv;
		$('#nowExpPoint').html(nowExpPoint);

		if (!targetLv) {
			return;
		}

		var targetTotalExp = calcCharaExpPoint.getTotalExp(expList, targetLv);
		var restExpPoint = targetTotalExp - nowExpPoint;

		$('#restExpPoint').html(restExpPoint);

		var canUseFlag = $('.canUseFlag').map(function(idx, elt){
			return $(elt).prop('checked');
		}).get();
		var doSuperExpFlag = $('#doSuperExp').prop('checked');

		var magPer = doSuperExpFlag ? 1.5 : 1;
		var items = [80, 160, 320, 1280, 5120, 10240];
		var useCount = [0, 0, 0, 0, 0, 0];
		var itemIdx = items.length -1;

		while(itemIdx >= 0) {
			if (!canUseFlag[itemIdx] || items[itemIdx] * magPer > restExpPoint) {
				itemIdx--;
				continue;
			}
			useCount[itemIdx]++;
			restExpPoint -= items[itemIdx] * magPer;
		}

		itemIdx = 0;
		while(itemIdx < items.length) {
			if (canUseFlag[itemIdx] && items[itemIdx] * magPer > restExpPoint) {
				useCount[itemIdx]++;
				break;
			}
			itemIdx++;
		}

		useCount.forEach(function(val, idx){
			$('#itemList tr:nth-child(' + (idx+2) + ') > td:nth-child(2)').css('font-weight', val ? 'bold' : 'nomarl').html(val);
		});

		var totalGetPointRow = useCount.map(function(elt, idx){
			return elt * items[idx];
		}).reduce(function(pre, cur){
			return pre + cur;
		});
		var totalGetPointMag = parseInt(totalGetPointRow * 1.5, 10);
		$('#totalGetPointRow').html(totalGetPointRow);
		$('#totalGetPoint').html(totalGetPointMag);
	},

	//引数Lvまでに必要な経験値を取得
	getTotalExp: function(expList, lv) {
		return expList.slice(0, lv).reduce(function(pre, cur){
			return pre + cur;
		});
	}
};
