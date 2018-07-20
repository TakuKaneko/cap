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
 * アラート
 */
// function showAlert(msg, type) {
//   $.notify({
//     icon: "notifications",
//     message: "<h3>" + msg + "</h3>"

//   }, {
//     type: type,
//     timer: 1000,
//     placement: {
//       from: 'top',
//       align: 'center'
//     }
//   });
// }


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