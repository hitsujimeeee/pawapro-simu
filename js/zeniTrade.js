/*jslint shadow:true, browser: true, jquery: true */


$(function(){
	$('.tradeAmount').on('change', zeniTrade.calc);
	$('#discountPer').on('change', zeniTrade.changePrice);
});


var zeniTrade = {

	calc: function() {
		var amountList = $('.tradeAmount').map(function(idx, elt){
			return Number($(elt).val());
		}).get();

		var priceList = $('#zeniTable tr td:nth-child(2)').map(function(idx, elt){
			return Number($(elt).find('.price').text().replace("\\","").replace(/,/g,""));
		}).get();

		var total = 0;
		for (var i = 0; i < amountList.length; i++) {
			if (amountList[i] > 0) {
				total += amountList[i] * priceList[i];
			}
		}

		$('#totalValue').html(zeniTrade.separate(total));

	},

	changePrice: function() {
		var discountPer = Number($('#discountPer').val());
		$('#zeniTable tr td:nth-child(2)').each(function(idx, elt){
			var newPrice = Number($(elt).find('.basePrice').val()) * ((100-discountPer) / 100);
			$(elt).find('.price').html(zeniTrade.separate(newPrice));
		});
		zeniTrade.calc();
	},

	separate: function(num){
		return String(num).replace( /(\d)(?=(\d\d\d)+(?!\d))/g, '$1,');
	}

};
