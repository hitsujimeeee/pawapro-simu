<!DOCTYPE html>
<html lang="ja">

<head>
    <?php
    $title = 'パワプロアプリ　円卓高校練習レベル計算機';
    $description = 'パワプロアプリ円卓高校の初期練習レベルを計算するツールです。';
    require_once './headInclude.php';
    ?>
    <link rel="stylesheet" href="../css/entakuLevel.css?ver20171230">
    <script src="../js/entakuLevel.js?ver20180217"></script>
</head>

<body>
    <?php include('../php/header.php'); ?>

    <main>
        <header class="pageHeader">
            <h2><i class="fa fa-trophy" aria-hidden="true"></i>円卓高校練習レベル計算機</h2>
        </header>
        <section>
            <header class="secHeader"><span>■得意練習</span><button class="allReset" onclick="entakuLevel.resetAll()">リセット</button></header>

            <div class="secMain">
                <table class="modern eveCharaTable">
                    <tr>
                        <th></th>
                        <th>メイン</th>
                        <th>サブ</th>
                    </tr>
                    <tr>
                        <th>1</th>
                        <td><img class="charaType" src="../img/entakuBlank.jpg"></td>
                        <td><img class="charaType" src="../img/entakuBlank.jpg"></td>
                    </tr>
                    <tr>
                        <th>2</th>
                        <td><img class="charaType" src="../img/entakuBlank.jpg"></td>
                        <td><img class="charaType" src="../img/entakuBlank.jpg"></td>
                    </tr>
                    <tr>
                        <th>3</th>
                        <td><img class="charaType" src="../img/entakuBlank.jpg"></td>
                        <td><img class="charaType" src="../img/entakuBlank.jpg"></td>
                    </tr>
                    <tr>
                        <th>4</th>
                        <td><img class="charaType" src="../img/entakuBlank.jpg"></td>
                        <td><img class="charaType" src="../img/entakuBlank.jpg"></td>
                    </tr>
                    <tr>
                        <th>5</th>
                        <td><img class="charaType" src="../img/entakuBlank.jpg"></td>
                        <td><img class="charaType" src="../img/entakuBlank.jpg"></td>
                    </tr>
                    <tr>
                        <th>6</th>
                        <td><img class="charaType" src="../img/entakuBlank.jpg"></td>
                        <td><img class="charaType" src="../img/entakuBlank.jpg"></td>
                    </tr>
                </table>
            </div>

        </section>

        <section>
            <header class="secHeader">■高校固有キャラ</header>
            <div class="secMain">
                <div><input type="checkbox" id="checkArthur" class="spChara">阿麻</div>
                <div><input type="checkbox" id="checkMordred" class="spChara">望戸</div>
                <div><input type="checkbox" id="checkKunemia" class="spChara">久根</div>
                <div><input type="checkbox" id="checkLancelot" class="spChara">ランス</div>
                <div>※高校固有キャラによる練習Lvアップは、エンタクルス解放時</div>
            </div>
        </section>

        <section>
            <header class="secHeader">
               ■練習レベル
                <select id="targetType" onchange="entakuLevel.update();">
                    <option value="0">野手育成</option>
                    <option value="1">投手育成</option>
                </select>
            </header>
            <div class="secMain">
                <div class="divBatter">
                    <div class="playerType">野手</div>
                    <ul class="dispList dispListBatter">
                        <li>
                            <div><img src="../img/practice0.jpg"></div>
                            <div class="lvArea">Lv<span class="dispLevel"></span></div>
                        </li>
                        <li>
                            <div><img src="../img/practice1.jpg"></div>
                            <div class="lvArea">Lv<span class="dispLevel"></span></div>
                        </li>
                        <li>
                            <div><img src="../img/practice2.jpg"></div>
                            <div class="lvArea">Lv<span class="dispLevel"></span></div>
                        </li>
                        <li>
                            <div><img src="../img/practice3.jpg"></div>
                            <div class="lvArea">Lv<span class="dispLevel"></span></div>
                        </li>
                        <li>
                            <div><img src="../img/practice8.jpg"></div>
                            <div class="lvArea">Lv<span class="dispLevel"></span></div>
                        </li>
                        <li>
                            <div><img src="../img/practice9.jpg"></div>
                            <div class="lvArea">Lv<span class="dispLevel"></span></div>
                        </li>
                    </ul>
                </div>
                <div class="divPitcher">
                    <div class="playerType">投手</div>
                    <ul class="dispList dispListPitcher">
                        <li>
                            <div><img src="../img/practice4.jpg"></div>
                            <div class="lvArea">Lv<span class="dispLevel"></span></div>
                        </li>
                        <li>
                            <div><img src="../img/practice5.jpg"></div>
                            <div class="lvArea">Lv<span class="dispLevel"></span></div>
                        </li>
                        <li>
                            <div><img src="../img/practice6.jpg"></div>
                            <div class="lvArea">Lv<span class="dispLevel"></span></div>
                        </li>
                        <li>
                            <div><img src="../img/practice7.jpg"></div>
                            <div class="lvArea">Lv<span class="dispLevel"></span></div>
                        </li>
                        <li>
                            <div><img src="../img/practice8.jpg"></div>
                            <div class="lvArea">Lv<span class="dispLevel"></span></div>
                        </li>
                        <li>
                            <div><img src="../img/practice9.jpg"></div>
                            <div class="lvArea">Lv<span class="dispLevel"></span></div>
                        </li>
                    </ul>
                </div>

            </div>
        </section>
    </main>

    <div id="practiceModal" class="remodal" data-remodal-id="modal" data-remodal-options="hashTracking:false, closeOnCancel:false, closeOnConfirm:false, closeOnEscape:false">
        <button class="remodal-close"  onclick="$.remodal.lookup[$('[data-remodal-id=modal]').data('remodal')].close()"></button>

        <ul class="choicePraItems">
            <li><img src="../img/practice0.jpg" data-number="0"></li>
            <li><img src="../img/practice1.jpg" data-number="1"></li>
            <li><img src="../img/practice2.jpg" data-number="2"></li>
            <li><img src="../img/practice3.jpg" data-number="3"></li>
            <li><img src="../img/practice4.jpg" data-number="4"></li>
            <li><img src="../img/practice5.jpg" data-number="5"></li>
            <li><img src="../img/practice6.jpg" data-number="6"></li>
            <li><img src="../img/practice7.jpg" data-number="7"></li>
            <li><img src="../img/practice8.jpg" data-number="8"></li>
            <li><img src="../img/practice9.jpg" data-number="9"></li>
            <li><img src="../img/practice999.jpg" data-number="999"></li>
        </ul>

        <div class="modalButton">
            <button data-remodal-action="cancel" class="remodal-cancel" onclick="entakuLevel.resetPractice();">練習削除</button>
            <button data-remodal-action="cancel" class="remodal-confirm" onclick="$.remodal.lookup[$('[data-remodal-id=modal]').data('remodal')].close()">Close</button>
        </div>
    </div>


    <?php include('./optionMenu.php'); ?>

    <?php include('../html/footer.html'); ?>
</body>

</html>


<?php
    function makeCharaTypeList() {
        return '
            <select class="charaType" onchange="entakuLevel.calcStartLevel();">
                <option value="-1"></option>
                <option value="0">打撃</option>
                <option value="1">筋力</option>
                <option value="2">走塁</option>
                <option value="3">肩力</option>
                <option value="4">球速</option>
                <option value="5">ｺﾝﾄﾛｰﾙ</option>
                <option value="6">ｽﾀﾐﾅ</option>
                <option value="7">変化球</option>
                <option value="8">守備</option>
                <option value="9">精神</option>
                <option value="999">彼女</option>
        ';
    }
?>
