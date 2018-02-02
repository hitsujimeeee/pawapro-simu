

//ファイル読み込み関係オブジェクト
var File = {

	//非同期通信を行う準備
	createHttpRequest : function () {
		if (window.XMLHttpRequest){
			return new XMLHttpRequest();
		}else{
			if (window.ActiveXObject){
				return new ActiveXObject("Microsoft.XMLHTTP");
			}
		}
		return null;
	},


	//CSVファイルを読み込む
	readCSVFile : function (xmlHttp, source) {
		var list;
		xmlHttp.open("GET", "../data/" + source + ".csv", false);
		xmlHttp.send(null);
		list = xmlHttp.responseText.split(/\r\n|\r|\n/);
		list.shift();
		list.pop();
		return list;
	},


	//特能を並べ替える
	sortAbilityList : function(abilityList) {
		for (var i  = 0; i < abilityList.length;i++) {
			abilityList[i] = abilityList[i].split(',');
		}


		abilityList.sort(function (a1, a2) {
			return Number(a1[4]) - Number(a2[4]);
		});
	}

};

var hiramekiList;
readTextFile();
var trainingList = [
	[0, 1, 2, 3, 8, 9],
	[4, 5, 6, 7, 8, 9],
	[0, 1, 2, 3, 4, 5, 6, 7, 8, 9]
];


$(function (){
	$('#myType').on('change', function() {
		changeMyType(this);
	});

	rewriteList();


	$('.SpecialtyTraining').on('click', function(){
		ChangeSpecialtyTraining(this);
	});
	$('.lockLayer').on('click', function(){
		ChangeSpecialtyTraining($('.SpecialtyTraining').eq($('.lockLayer').index(this)));
	});

	$('.EventCharaType').on('click', function(){
		ChangeCharacterType(this);
	});

	$('.lockButton').on('click', function(){
		lockTraining(this);
	});


});

function readTextFile(){
	var xmlHttp = File.createHttpRequest();

	hiramekiList = File.readCSVFile(xmlHttp, "hirameki");
	for (var i = 0; i < hiramekiList.length; i++) {
		hiramekiList[i] = hiramekiList[i].split(",");
		hiramekiList[i][21] = 0;
		hiramekiList[i][22] = 0;
		hiramekiList[i][23] = 0;
		hiramekiList[i][24] = -1;
	}

}
//ひらめき一覧を作成
function makeList(){
	var str = '';
	var myType=  $('#myType').val();
	var spList = getSpecialtyTrainingList();
	var hitCount = 0;
	var targetCount = 0;
	var hitTargetCount = 0;
	var dispList = [];
	var targetObj = $('.hiramekiTarget');
	var filterType = parseInt($('#filterType').val(), 10);
	var filterNum = parseInt($('#filterNum').val(), 10);

	//揃ってた項目、ターゲットの項目を上に持ってくる処理
	//所得済みの物は後で追加する
	for (var i = 0; i < hiramekiList.length; i++) {
		var line = hiramekiList[i];
		if (line[21] == 1 || line[2] != myType || !filter(i, filterType, filterNum))
			continue;
		if(isHitHirameki(spList, i, myType)) {
			line[23] = 1;
			//揃っている場合は一番上に持ってくる
			if(line[22] == 1) {
				hitTargetCount++;
				dispList.splice(0, 0, line.concat());
			} else {
				dispList.splice(hitTargetCount, 0, line.concat());
			}
			hitCount++;
		} else if (Number(line[22]) === 1){
			//ターゲット指定の場合は、揃っているものの後ろに
			dispList.splice(hitCount+targetCount, 0, line.concat());
			targetCount++;
		} else if (Number(line[21]) === 0){
			line[23] = 0;
			dispList[dispList.length] = line.concat();
		}
	}

	//所得済みの物をリストの後ろに追加していく
	for (var i = 0; i < hiramekiList.length; i++) {
		var line = hiramekiList[i];
		if (line[2] != myType || !filter(i, filterType, filterNum))
			continue;
		if (line[21] == 1){
			line[23] = 0;
			dispList[dispList.length] = line.concat();
		}
	}
	for (var i = 0; i < dispList.length; i++) {
		var line =  dispList[i];

		str += '<div class="hiramekiWrapper" value="' + line[0] + '">';

		str += '<div class="hiramekiContainer' + (line[23] == 1 ? " hiramekiContainerHit" : "") + '" style="display:' + (line[2] == myType ? 'inherit' : 'none') + ';">'

		str += '<div class="hiramekiName' + (line[23] == 1 ? ' hiramekiNameHit' : '') + '">' + line[1] + '</div>';
		for (var j =0; j < 10; j++) {
			var count = parseInt(line[3+j], 10);
			for (var k = 0; k < count; k++) {
				str += '<div class="hiramekiImage"><img src="../img/practice' + j + '.jpg"></div>'
			}
		}
		str += '<div class="hiramekiPer">' + (line[24] != -1 ? Math.floor( line[24] * Math.pow( 10, 1 ) ) / Math.pow( 10, 1 )+'%' : '')+ '</div>'
		str += '<div class="hiramekiDetail">' + line[19] +'</div>'
		str += '</div>'

		str += '<div class="hiramekiLearn' + (line[21] == 0 ? ' hiddenBlock' : '') + '"></div>'
		str += '<div class="hiramekiLearnStr  noneSelect' + (line[21] == 0 ? ' hiddenBlock' : '') + '">取得済み</div>'
		str += '<div class="hiramekiTarget noneSelect' + (line[22] == 0 ? ' hiddenBlock' : '') + '"><i class="fa fa-star" style="color:#FFA500"></i>Target</div>'
		str += '</div>'
	}

	return str;
}


function rewriteList() {
	$('#hiramekiListArea').html(makeList());
	$('.hiramekiWrapper').on('click', function(e){
		ClickList(this, e);
	});
}


//選手タイプ変更時に
function changeMyType(obj) {
	for (var i = 0; i < hiramekiList.length; i++) {
		hiramekiList[i][21] = 0;
		hiramekiList[i][22] = 0;
		hiramekiList[i][24] = -1;
	}
	rewriteList();
	calcPoint();
}


function ClickList(obj, e){
	var index = parseInt($(obj).attr('value'), 10);
	var posX = obj.getBoundingClientRect().left + window.pageXOffset;
	var offsetX = e.pageX - posX;
	var area = parseInt($(obj).css('width'), 10)*4/5;
	if(offsetX >= area) {
		var item = $(obj).find('.hiramekiTarget');
		if (hiramekiList[index][22] == 0) {
			$(obj).find('.hiramekiLearn').addClass('hiddenBlock');
			$(obj).find('.hiramekiLearnStr').addClass('hiddenBlock');
			hiramekiList[index][21] = 0;
		}
		if(hiramekiList[index][22] == 0) {
			item.removeClass('hiddenBlock');
		} else {
			item.addClass('hiddenBlock');
		}
		hiramekiList[index][22] = (hiramekiList[index][22]+1)%2;
	} else {
		var vis = hiramekiList[index][21];
		if(vis == 0) {
			var item = $(obj).find('.hiramekiTarget');
			item.addClass('hiddenBlock');
			hiramekiList[index][22] = 0;
		}
		if (vis == 0) {
			$(obj).find('.hiramekiLearn').removeClass('hiddenBlock');
			$(obj).find('.hiramekiLearnStr').removeClass('hiddenBlock');
		} else {
			$(obj).find('.hiramekiLearn').addClass('hiddenBlock');
			$(obj).find('.hiramekiLearnStr').addClass('hiddenBlock');
		}
		hiramekiList[index][21] = (vis + 1) % 2;
	}

	calcPoint();
}

function ChangeCharacterType(obj){
	var classList = ["Batter", "Pitcher", "GF"],
		nameList = ["野手", "投手", "彼女"];
	nowValue = parseInt($(obj).attr('value'), 10),
		newValue = (nowValue+1) % 3,
		myIndex = $('.EventCharaType').index(obj),
		trainingIdx = $('.SpecialtyTraining').eq(myIndex).attr('value');
	switch(newValue){
		case 0:
			$('.SpecialtyTraining').eq(myIndex).attr('idx', '0');
			$('.SpecialtyTraining').eq(myIndex).attr('typ', '0');
			$('.SpecialtyTraining').eq(myIndex).attr('src', '../img/practice0.jpg');
			break;
		case 1:
			$('.SpecialtyTraining').eq(myIndex).attr('idx', '0');
			$('.SpecialtyTraining').eq(myIndex).attr('typ', '4');
			$('.SpecialtyTraining').eq(myIndex).attr('src', '../img/practice4.jpg');
			break;
		case 2:
			$('.SpecialtyTraining').eq(myIndex).attr('idx', '0');
			$('.SpecialtyTraining').eq(myIndex).attr('typ', '0');
			$('.SpecialtyTraining').eq(myIndex).attr('src', '../img/practice0.jpg');
			break;
	}

	$(obj).attr('value', newValue + '');
	$(obj).removeClass('EventChara' + classList[nowValue]);
	$(obj).addClass('EventChara' + classList[newValue]);
	$(obj).text(nameList[newValue]);
	rewriteList();
};


//得意練習押下時に実行。得意練習を一つ後ろのものに変更する
function ChangeSpecialtyTraining(obj){
	var myIndex = $('.SpecialtyTraining').index(obj),
		idx = $(obj).attr('idx'),
		charaType = $('.EventCharaType').eq(myIndex).attr('value'),
		nextIdx = (parseInt(idx, 10)+1)%trainingList[charaType].length;
	$(obj).attr('src', '../img/practice' + trainingList[charaType][nextIdx] + '.jpg');
	$(obj).attr('idx', nextIdx + '');
	$(obj).attr('typ', trainingList[charaType][nextIdx] + '');
	rewriteList();
}


function FilterHiramekiList() {
	rewriteList();
}





function BrainShaffule(count){
	var lock = $('.lockButton');
	for(var i = 0; i < lock.length;i++){
		var loc = lock.eq(i);
		if(loc.attr('value') ==  0) {
			ChangeTrainingType(i, 999);
		}
	}
	if(count == 0) {
		rewriteList();
		return;
	}
	setTimeout(BrainShaffule, 80, count-1);
}

function ChangeTrainingType(index, trainIdx){
	var charaType = parseInt($('.EventCharaType').eq(index).attr('value'));
	var nowIdx = parseInt($('.SpecialtyTraining').eq(index).attr('idx'), 10);
	var nextType,nextIdx;
	if(trainIdx === undefined) {
		nextIdx = (nowIdx + 1 ) % trainingList[charaType].length;
	} else if(trainIdx == 999) {
		while(true) {
			nextIdx = (Math.floor( Math.random() * trainingList[charaType].length ));
			if (nextIdx != nowIdx) {
				break;
			}
		}

	} else {
		nextIdx = trainIdx;
	}
	nextType = trainingList[charaType][nextIdx];
	$('.SpecialtyTraining').eq(index).attr('idx', nextIdx);
	$('.SpecialtyTraining').eq(index).attr('typ', nextType);
	$('.SpecialtyTraining').eq(index).attr('src', '../img/practice' + nextType + '.jpg');
}


//ロックボタン押下で起動、得意練習のロック/解除処理
function lockTraining(obj){
	var myIndex = $('.lockButton').index(obj);
	var v = (parseInt($(obj).attr('value'), 10) + 1 ) % 2;
	$(obj).attr('value', v);
	$('.lockLayer').eq(myIndex).css('visibility', v == 0 ? 'hidden' : 'visible');

}


function doCalc() {
	var myType = $('#myType').val(),
		checkCount = getNotLearnedCount(parseInt(myType, 10));
	$.blockUI({
		message: '<i class="fa fa-spinner fa-pulse"></i> <span id="blockMessage">計算中...  1/'+checkCount + '</div>',
		css:{
			border: 'none',
			padding: '15px',
			'-webkit-border-radius': '10px',
			'-moz-border-radius':'10px',
			opacity: '.5',
			color:'#000',
			'font-size':'1em'
		}
	});
	var total = 1;
	var $types = $('.EventCharaType');
	var $locks = $('.lockButton');
	var charaTypeList = [];
	for(var i = 0; i< $types.length; i++) {
		if($locks.eq(i).attr('value') == 0) {
			charaTypeList[charaTypeList.length] = parseInt($types.eq(i).attr('value'), 10);
			total *= trainingList[charaTypeList[charaTypeList.length-1] ].length;
		}
	}
	doCalc_Recall(0, total, charaTypeList, myType, checkCount);
}


function doCalc_Recall(idx, total, charaTypeList, myType, checkCount) {
	if (idx >= hiramekiList.length) {
		$.unblockUI();
		rewriteList();
		calcAtLeast();
		return;
	}

	var hList = getHiramekiList(idx, myType);
	if (hList == null || hiramekiList[idx][21] == 1 || !filter(idx)) {
		hiramekiList[idx][24] = -1;
		idx++;
		while(getHiramekiList(idx, myType) == null || hiramekiList[idx][21] == 1 || !filter(idx)) {
			hiramekiList[idx][24] = -1;
			idx++
			if (idx >= hiramekiList.length) break;
		}
		setTimeout(doCalc_Recall, 0, idx, total, charaTypeList, myType, checkCount);
		return;
	}
	var spList = getSpecialtyTrainingList();
	var $locks = $('.lockButton');
	for (var i = 0; i < $locks.length; i++) {
		if($locks.eq(i).attr('value') == 1) {
			var anker = hList.indexOf(parseInt(spList[i], 10));
			if(anker != -1) {
				hList.splice(anker, 1);
			}
		}
	}

	var startTime = new Date();
	var result = calcTraining_Recall(charaTypeList, hList, 0, [-1,-1,-1, -1, -1, -1]);
	var endTime = new Date();
	var time = endTime - startTime;
	var ans = result*100/total;
	hiramekiList[idx][24] = ans;
	$('#blockMessage').hide().html('計算中... ' + Math.round((idx - (myType == '1' ? 39 : 0) + 1)*100/checkCount) + '%' ).show();
	setTimeout(doCalc_Recall, (time)/10, idx+1, total, charaTypeList, myType, checkCount);
}


function calcTraining_Recall(charaTypeList, targetList, depth, idxList) {
	if (charaTypeList.length == depth) {
		if (check_Recall(targetList, idxList)) {
			return 1;
		}
		return 0;
	}
	var count = 0;

	for (var i = 0; i < trainingList[charaTypeList[depth]].length; i++) {
		idxList[depth] = trainingList[charaTypeList[depth]][i];
		count += calcTraining_Recall(charaTypeList, targetList, depth+1, idxList);
	}
	return count;
}


function check_Recall(targetList, idxList) {
	var tempList = [];
	for (var i = 0; i < targetList.length; i++)
		tempList[i] = targetList[i];

	for (var i = 0; i < idxList.length; i++) {
		for (var j = 0; j < tempList.length; j++) {
			if (tempList[j] === idxList[i]) {
				tempList.splice(j, 1);
				break;
			}
		}
	}
	if(tempList.length > 0) return false;
	return true;
}



//idxの番号の練習リストを取得
function getHiramekiList(idx, myType) {
	var hList = [];
	var hSplit = hiramekiList[idx];
	if(hSplit[2] != myType) return null;
	for (var i = 0; i < 10; i++) {
		for (var j = 0; j < hSplit[3+i]; j++) {
			hList[hList.length] = i
		}
	}
	return hList;
}


//get


function HitHirameki(myType) {
	var objs = $('.SpecialtyTraining');
	var trainList = [];
	for (var i = 0; i < objs.length ; i++) {
		trainList[i] = parseInt(objs.eq(i).attr('typ'), 10);
	}
	for (var i = 0; i < hiramekiList.length; i++) {
		var hList = getHiramekiList(i, myType);
		if(hList == null) continue;
		if (check_Recall(hList, trainList)) {
			$('.hiramekiContainer').eq(i).addClass('hiramekiContainerHit');
			$('.hiramekiName').eq(i).addClass('hiramekiNameHit');
		} else {
			$('.hiramekiContainer').eq(i).removeClass('hiramekiContainerHit');
			$('.hiramekiName').eq(i).removeClass('hiramekiNameHit');
		}

	}
}


function isHitHirameki(trainList, idx, myType){
	var hList = getHiramekiList(idx, myType);
	if(hList == null) return false;

	return check_Recall(hList, trainList);

}

//最低でも何か一つひらめき特訓が揃う確率を計算
function calcAtLeast() {
	var per = 1;
	var myType = parseInt($('#myType').val(), 10);
	for(var i = 0; i < hiramekiList.length; i++) {
		var hirameki = hiramekiList[i];
		if (myType == parseInt(hirameki[2], 10) && hirameki[24] > 0) {
			per *= (1-hirameki[24]/100);
		}
	}
	$('#atLeastPer').html(Math.floor( ((1-per)*100) * Math.pow( 10, 1 ) ) / Math.pow( 10, 1 )+'%');
}



function calcHirameki() {
	setTimeout(function() {
		var chara = [{type:0}, {type:0}, {type:0}, {type:0}, {type:0}, {type:2}];
		//alert(SingleAtLeast(3, chara, 5));
		var size = 6;
		for (var i = 0; i < hiramekiList.length; i++) {
			var hirameki = hiramekiList[i];
			//if (hirameki[2] != '0') continue;
			//if(i != 1) continue;
			var list = [];
			for(var j = 0; j < 10; j++){
				list.push(hirameki[3+j] - 0);
			}

			var count = 0;
			for(var a = 0; a < 6; a++) {
				for(var b = 0; b < 6; b++){
					for(var c = 0; c < 6; c++) {
						for(var d = 0; d < 10; d++){
							for(var e = 0; e < 10; e++){
								for(var f = 0; f < 10; f++){
									//if(check([2,1,0,0,0,0], [a, b, c, d, e, f])){
									if(check(list.concat(), [a, b, c, d, e, f])){
										count++;
									}
								}
							}
						}
					}

				}
			}
			var x = $('.hiramekiPer');
			var y = x.eq(i);

			y.text(Math.round(count/(Math.pow(6, 6))*100) + '%');
			//alert(count);
			//alert(count/(Math.pow(6, size)));

		}


	}, 0);
}



function check(list, pra) {
	var tra = [0, 0, 0, 0, 0, 0];
	for(var i = 0; i < pra.length; i++) {
		list[pra[i]]--;
		tra[pra[i]]++;
	}

	var a = i;

	for(var i = 0; i < list.length; i++) {
		if(list[i] > 0) return false;
	}

	//if(tra[0] == 0 && tra[1] == 0) return true;
	//return false;
	return true;
}



//現在の得意練習を配列で取得
function getSpecialtyTrainingList() {
	var list = [];
	var objs = $('.SpecialtyTraining');
	for (var i = 0; i < objs.length; i++) {
		list[i] = parseInt(objs.eq(i).attr('typ'));
	}
	return list;
}

//取得済みになっていないひらめきの数取得
function getNotLearnedCount(myType) {
	var count = 0;
	for (var i = 0; i < hiramekiList.length; i++) {
		if(hiramekiList[i][2] == myType) {
			count++;
		}
	}
	return count;
}


function filter(idx, f_type, f_num) {
	var filterType = f_type || parseInt($('#filterType').val(), 10);
	var filterNum = f_num ||parseInt($('#filterNum').val(), 10);
	hirameki = hiramekiList[idx];
	return (filterType == 0 || (parseInt(hirameki[12+filterType], 10) >= filterNum || (filterType == 6 && parseInt(hirameki[12+filterType], 10) == 1)))
}

function calcPoint() {
	var point = [0, 0, 0, 0, 0, 0];
	for (var i = 0; i < hiramekiList.length; i++) {
		var hirameki = hiramekiList[i];
		if (hirameki[21] == 1) {
			for (var j = 0; j < 5; j++) {
				if(hirameki[j+13] != "") {
					point[j] += parseInt(hirameki[j+13], 10);
				}
			}
		}
	}
	for (var i = 0; i < 5; i++) {
		point[5] += point[i];
	}

	var objs = $('#pointTable td');
	for (var i = 0; i < objs.length; i++) {
		objs.eq(i).html(point[i]);
	}
}

