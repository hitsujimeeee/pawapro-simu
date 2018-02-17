/*jslint browser: true, jquery: true */
/*jslint shadow:true*/

$(function(){
    $('.spChara').on('change', entakuLevel.calcStartLevel);
    $('.charaType').on('click', entakuLevel.openModalWindow);
    $('.choicePraItems img').on('click', entakuLevel.setPractice);




//    entakuLevel.typeList[0][0] = 2;
//    entakuLevel.typeList[0][1] = 8;
//    entakuLevel.typeList[1][0] = 2;
//    entakuLevel.typeList[1][1] = 3;
//    entakuLevel.typeList[2][0] = 1;
//    entakuLevel.typeList[2][1] = 2;
//    entakuLevel.typeList[3][0] = 8;
//    entakuLevel.typeList[3][1] = 0;
//    entakuLevel.typeList[4][0] = 8;
////    entakuLevel.typeList[4][1] = 0;
//    entakuLevel.typeList[5][0] = 999;

//    entakuLevel.typeList[0][0] = 8;
//    entakuLevel.typeList[0][1] = 0;
//    entakuLevel.typeList[1][0] = 9;
////    entakuLevel.typeList[1][1] = 3;
//    entakuLevel.typeList[2][0] = 2;
//    entakuLevel.typeList[2][1] = 3;
//    entakuLevel.typeList[3][0] = 1;
////    entakuLevel.typeList[3][1] = 0;
//    entakuLevel.typeList[4][0] = 0;
//    entakuLevel.typeList[4][1] = 1;
//    entakuLevel.typeList[5][0] = 0;

    entakuLevel.updateGraph();


    entakuLevel.calcStartLevel();
});


var entakuLevel = {

    typeList: [[-1, -1], [-1, -1], [-1, -1], [-1, -1], [-1, -1], [-1, -1]],
    selectedIdx: -1,


    calcStartLevel: function() {
        var typeList = entakuLevel.typeList;

        var levelList = [2, 1, 2, 1, 2, 1, 2, 1, 2, 1];
        var updownList = [
            [
                [0, 1, -1, 1, 0, 0, 0, 0, -1, 0],
                [0, 0, -1, 1, 0, 0, 0, 0, -1, 0],
                [0, 0, 0, 1, 0, 0, 0, 0, -1, 0],
                [0, 0, 0, 0, 0, 0, 0, 0, -1, 0],
                [0, 0, 0, 0, 0, 0, 0, 0, 0, 0],//球速
                [0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
                [0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
                [0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
                [0, 0, 0, 0, 0, 0, 0, 0, 0, 0],//守備
                [0, 0, 0, 0, 0, 0, 0, 0, 0, 0]
            ],
            [
                [0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
                [0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
                [0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
                [0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
                [0, 0, 0, 0, 0, 1, -1, 1, -1, 0],//球速
                [0, 0, 0, 0, 0, 0, -1, 1, -1, 0],
                [0, 0, 0, 0, 0, 0, 0, 1, -1, 0],
                [0, 0, 0, 0, 0, 0, 0, 0, -1, 0],
                [0, 0, 0, 0, 0, 0, 0, 0, 0, 0],//守備
                [0, 0, 0, 0, 0, 0, 0, 0, 0, 0]
            ]
        ];

        var updownStock = [[0, 0], [0, 0], [0, 0], [0, 0], [0, 0], [0, 0], [0, 0], [0, 0], [0, 0], [0, 0]];
        var girlFriend = false;

        var tokuiListSingle = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0];   //メイン練習のみ
        var tokuiListAll = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0];      //メインサブ含めた得意練習

        var targetType = Number($('#targetType').val());

        //メインサブ含めた得意練習を取得
        for (var i = 0; i < typeList.length; i++) {
            if (typeList[i][0] != 999) {
                //得意練習ごとにループ
                for (var j = 0; j < typeList[i].length; j++) {
                    var charaType = typeList[i][j];
                    tokuiListAll[charaType]++;
                }
            } else {
                girlFriend = true;
            }
        }

        //メイン練習の得意練習数を取得
        for (var i = 0; i < typeList.length; i++) {
            if (typeList[i][0] != 999) {
                var charaType = typeList[i][0];
                tokuiListSingle[charaType]++;
            }
        }

        //各練習の増減値を反映
        for (var i = 0; i < tokuiListSingle.length; i++) {
            if (tokuiListSingle[i] > 0) {
                for (var j = 0; j < updownList[targetType][i].length; j++) {
                    var t = updownList[targetType][i][j];
                    if (t === 1) {
                        updownStock[j][1]++;
                    } else if (t === -1){
                        updownStock[j][0]++;
                    }
                }
            }
        }

        //増減値 +が奇数なら練習レベル+1,-が奇数なら練習レベル-1
        for (var i = 0; i < updownStock.length; i++) {
            if (updownStock[i][0] % 2 === 1 && levelList[i] > 1) {
                levelList[i]--;
            } else if (updownStock[i][1] % 2 === 1){
                levelList[i]++;
            }
        }

        //メインサブ含めた得意練習のレベルを1にする
        if(girlFriend) {
            for (var i = 0; i < tokuiListSingle.length; i++) {
                if (tokuiListSingle[i] > 0) {
                    levelList[i] = 1;
                }
            }
        } else {
            for (var i = 0; i < tokuiListAll.length; i++) {
                if (tokuiListAll[i] > 0) {
                    levelList[i] = 1;
                }
            }
        }

        //彼女あり
        if (girlFriend) {
            //得意練習のレベルを2に、得意練習以外でレベル2のものを3に
            for (var i = 0; i < tokuiListAll.length; i++) {
                if (tokuiListSingle[i] > 0) {
                    levelList[i] = 2;
                } else if(tokuiListAll[i] === 0 && levelList[i] === 2){
                    levelList[i] = 3;
                }
            }
        }

        //得意練習が3つ以上重なった場合はレベル1
        for (var i = 0; i < tokuiListSingle.length; i++) {
            if (tokuiListSingle[i] >= 3) {
                levelList[i] = 1;
            }
        }

        //精神のレベルを1に
        levelList[9] = 1;

        //アーサーチェック
        if ($('#checkArthur').prop('checked')) {
            levelList[1]++;
            levelList[6]++;
        }

        //モルドレッドチェック
        if ($('#checkMordred').prop('checked')) {
            levelList[0]++;
        }

        //グィネヴィアチェック
        if ($('#checkKunemia').prop('checked')) {
            levelList[2]++;
            levelList[5]++;
        }

        //ランスロットチェック
        if ($('#checkLancelot').prop('checked')) {
            levelList[8]++;
        }

        entakuLevel.output(levelList);

    },

    output: function(list) {
        for (var i = 0; i < list.length; i++) {
            var idx;
            if (i <= 3) {
                idx = i;
            } else if (i <= 7) {
                idx = i + 2;
            } else {
				var padding = 0;
				if (i === 8 && $('#checkLancelot').prop('checked')) {
					padding++;
				}

				$('.dispLevel').eq(i-4).html(list[i]-padding);
                $('.dispLevel').eq(i+2).html(list[i]);
                continue;
            }
            $('.dispLevel').eq(idx).html(list[i]);
        }
    },

    openModalWindow: function () {
        entakuLevel.selectedIdx = $('.charaType').index(this);
        $.remodal.lookup[$('[data-remodal-id=modal]').data('remodal')].open();
    },

    setPractice: function() {
        entakuLevel.typeList[parseInt(entakuLevel.selectedIdx / 2, 10)][entakuLevel.selectedIdx % 2] = $(this).data('number');
        $.remodal.lookup[$('[data-remodal-id=modal]').data('remodal')].close();
        entakuLevel.updateGraph();
        entakuLevel.calcStartLevel();
    },

    resetPractice: function() {
        entakuLevel.typeList[parseInt(entakuLevel.selectedIdx / 2, 10)][entakuLevel.selectedIdx % 2] = -1;
        $.remodal.lookup[$('[data-remodal-id=modal]').data('remodal')].close();
        entakuLevel.updateGraph();
        entakuLevel.calcStartLevel();
    },

    resetAll: function() {
        for (var i = 0; i < 12; i++) {
            entakuLevel.typeList[parseInt(i / 2, 10)][i % 2] = -1;
        }
        entakuLevel.updateGraph();
        entakuLevel.calcStartLevel();
    },

    updateGraph: function() {
        for (var i = 0; i < 12; i++) {
            var typ = entakuLevel.typeList[parseInt(i / 2, 10)][i % 2];
            if(typ !== -1) {
                $('.charaType').eq(i).attr('src', '../img/practice' + typ + '.jpg');
            } else {
                $('.charaType').eq(i).attr('src', '../img/entakuBlank.jpg');
            }
        }

        var targetType = Number($('#targetType').val());

        if(targetType === 0) {
            $('.divBatter').removeClass('noneDisp');
            $('.divPitcher').addClass('noneDisp');
        } else {
            $('.divBatter').addClass('noneDisp');
            $('.divPitcher').removeClass('noneDisp');
        }
    },

    update: function() {
        entakuLevel.updateGraph();
        entakuLevel.calcStartLevel();
    }

};

