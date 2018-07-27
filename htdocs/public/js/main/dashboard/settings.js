/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, {
/******/ 				configurable: false,
/******/ 				enumerable: true,
/******/ 				get: getter
/******/ 			});
/******/ 		}
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "";
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 3);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/assets/js/main/dashboard/settings.js":
/***/ (function(module, exports) {

// デバッグ用
var debug = true;

function logInfo(msg) {
  if (debug) console.log(msg);
}

/**
 * 3点リーダー
 */
function setThreeDots(classname) {
  $('.' + classname).each(function () {

    var $target = $(this);
    var rest = "";

    // オリジナルの文章を取得
    var html = $target.html();

    // 対象の要素を、高さにautoを指定し非表示で複製する
    var $clone = $target.clone();
    $clone.css({
      display: 'none'
    }).width($target.width()).height('auto');

    // 目印クラスをつけて
    // DOMを追加
    $clone.addClass(classname + "-rest");
    $target.after($clone);

    // 指定した高さになるまで、1文字ずつ消去していく
    while (html.length > 0 && $clone.height() > $target.height()) {
      rest = html.substr(html.length - 1, 1) + rest;
      html = html.substr(0, html.length - 1);
      $clone.html(html + "..."); // 高さ更新
    }

    // 文章差し替え
    if (rest == "") {
      $target.html(html);
    } else {
      $target.html(html + '...');
    }
    // リサイズ用に次の要素に残りの文章を入れておく
    $clone.html(rest);
  });

  // リサイズした時のイベント
  setThreeDotsResize(classname);
}

function setThreeDotsResize(classname) {

  var timer = false;
  $(window).resize(function () {
    // タイマーによって、リサイズ単位毎に関数が実行され、重くなるのを防ぐ
    if (timer !== false) {
      clearTimeout(timer);
    }
    timer = setTimeout(function () {
      $('.' + classname).each(function () {

        var $target = $(this);
        var rest;
        // 以前にリサイズしたか(document.readyで必ず<p class="three-dots-card-rest">
        // は存在するのでこの条件文はtrueを返すが、念のため)
        if ($target.next().hasClass(classname + "-rest")) {
          // 省略していた文章を取得
          rest = $target.next().html();
          // 省略していた文章が空ではなかったとき、本文には３点リーダーが表示されて
          // いるので、その３文字を削除
          if (rest != "") {
            $target.html($target.html().slice(0, -3)); // 末尾の...を削除
          }
          // これがないと永遠に<p class="three-dots-card-rest">が増えていく
          $target.next().remove();
        } else {
          rest = "";
        }

        // オリジナルの文章を復元
        var html = $target.html() + rest;

        // 対象の要素を、高さにautoを指定し非表示で複製する
        // 方針としては、このクローン(オリジナルの文章を保持)を非表示でブラウザに配置させ、
        // クローンの文字消去と元のボックスとの高さ比較を行うことによって、
        // クローンが元のボックスと同様の高さになったときの文章で差し替える
        var $clone = $target.clone();
        $clone.html(html);
        $clone.css({
          display: 'none'
        }).width($target.width()).height('auto');

        // 目印クラスをつけて
        // DOMを追加 (これにより高さを獲得)
        $clone.addClass(classname + "-rest");
        $target.after($clone);

        rest = "";
        // 指定した高さになるまで、1文字ずつ消去していくと同時に、
        // 文章が完全消去されないように rest に退避させておく
        while (html.length > 0 && $clone.height() > $target.height()) {
          rest = html.substr(html.length - 1, 1) + rest;
          html = html.substr(0, html.length - 1);
          $clone.html(html + "..."); // 高さ更新
        }

        // 文章差し替え
        // rest が空っぽということは、三点リーダーを表示する必要がないということ
        if (rest == "") {
          $target.html(html);
        } else {
          $target.html(html + '...');
        }
        // 次のリサイズ用に次の要素に残りの文章を入れておく
        $clone.html(rest);
      });
    }, 100);
  });
}

/**
 * ユーザ編集モーダル
 */
function setEditCorpusModal() {
  var $modalEl = $('#editUserModal');

  $modalEl.on('show.bs.modal', function (event) {
    logInfo('open modal');

    // クリックしたボタン要素を取得して、データ受け渡し
    var $button = $(event.relatedTarget);
    var user_id = $button.data('edit-user');
    var sei_kanji = $button.data('sei-kanji');
    var mei_kanji = $button.data('mei-kanji');
    var email = $button.data('email');

    var $modal = $(this);
    // 各種値をセット
    $modal.find('#editSeiKanjiField').val(sei_kanji);
    $modal.find('#editSeiKanjiField').parents('.form-group').addClass('is-filled');

    $modal.find('#editMeiKanjiField').val(mei_kanji);
    $modal.find('#editMeiKanjiField').parents('.form-group').addClass('is-filled');

    $modal.find('#editEmailField').val(email);
    $modal.find('#editEmailField').parents('.form-group').addClass('is-filled');

    $modal.find('#editUserId').val(user_id);
  });
}

/**
 * ユーザ削除モーダル
 */
function setDeleteCorpusModal() {
  var $modalEl = $('#deleteUserModal');

  $modalEl.off('show.bs.modal');
  $modalEl.on('show.bs.modal', function (event) {
    logInfo('open modal');

    // クリックしたボタン要素を取得して、データ受け渡し
    var $button = $(event.relatedTarget);
    var user_id = $button.data('delete-user');

    var $modal = $(this);
    // 各種値をセット
    $modal.find('#deleteUserId').val(user_id);
  });
}

function initialize() {
  setEditCorpusModal();
  setDeleteCorpusModal();

  setThreeDots('three-dots-card');
}

// 
(function () {
  //
  logInfo('[Start] settings.js');
  initialize();
})();

/***/ }),

/***/ 3:
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__("./resources/assets/js/main/dashboard/settings.js");


/***/ })

/******/ });