/*jslint browser: true, jquery: true */

$(function() {
	$('#loginUserName, #loginPassword, #loginPawaproId, #loginTwitterId').on('change', function() {
		var v = $(this).val();
		var max = Number($(this).data('maxlength'));
		var min = Number($(this).data('minlength'));
		if (v !== '' && (v.length > max || v.length < min)) {
			alert((min ? min + '文字以上' : '') + max + '文字以下にしてください。');
			$(this).val('');
			return;
		}
		var data = localStorage.getItem('userData') || "{}";
		data = JSON.parse(data);
		data[$(this).attr('id')] = v;
		localStorage.setItem('userData', JSON.stringify(data));
	});

	var userData = localStorage.getItem('userData');

	if(userData) {
		userData = JSON.parse(userData);
		$('#loginUserName').val(userData.loginUserName != null ? userData.loginUserName : userData.name);
		$('#loginPassword').val(userData.loginPassword != null ? userData.loginPassword : userData.password);
		$('#loginPawaproId').val(userData.loginPawaproId != null ? userData.loginPawaproId : '');
		$('#loginTwitterId').val(userData.loginTwitterId != null ? userData.loginTwitterId : '');
	}


	$('#passWatch').on('mouseenter mouseleave', function() {
		$('#confirmPassword').val($('#loginPassword').val()).toggle();
		$('#loginPassword').toggle();
	});
});

window.onpageshow = function(event) {
	if (event.persisted) {
		var userData = localStorage.getItem('userData');
		if(userData) {
			userData = JSON.parse(userData);
			$('#loginPassword').val(userData.loginPassword != null ? userData.loginPassword : userData.password);
		}
	}
};
