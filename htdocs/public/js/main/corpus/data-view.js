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
/******/ 	return __webpack_require__(__webpack_require__.s = 2);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/assets/js/main/corpus/data-view.js":
/***/ (function(module, exports) {

// デバッグ用
var debug = true;

function logInfo(msg) {
  if (debug) console.log(msg);
}

/**
 * クラス/テキスト追加モーダル
 */
function setAddClassTextModal() {
  var $modalEl = $('#addClassTextModal');

  $modalEl.off('show.bs.modal');
  $modalEl.on('show.bs.modal', function (event) {
    // クリックしたボタン要素を取得して、データ受け渡し
    var $button = $(event.relatedTarget);
    var dataType = $button.data('datatype');
    var modalTitle = $button.data('mtitle');

    var $modal = $(this);
    // 各種値をセット
    $modal.find('.add_data_type').val(dataType);
    $modal.find('.modal-title').text(modalTitle);

    $select = $modal.find('#selectClass');

    $select.off('change');
    $select.on('change', function () {
      logInfo('change');

      var $targetEl = $('#add-class-form-area');
      var idx = this.selectedIndex;
      var value = this.options[idx].value; // 値

      if (value !== "") {
        $targetEl.hide();
      } else {
        $targetEl.show();
      }
    });

    $select.trigger('change');
  });
}

/**
 * クラス/テキスト編集モーダル
 */
function seteditClassTextModal() {
  var $modalEl = $('#editClassTextModal');

  $modalEl.off('show.bs.modal');
  $modalEl.on('show.bs.modal', function (event) {
    var $modal = $(this);
    var $editModalContent = $modal.find('#edit-content');
    var $delModalContent = $modal.find('#del-content');

    $delModalContent.hide();
    $editModalContent.show();

    // クリックしたボタン要素を取得して、データ受け渡し
    var $button = $(event.relatedTarget);
    var dataType = $button.data('datatype');
    var modalTitle = $button.data('mtitle');
    var content = $button.data('content');
    var classId = $button.data('classid');
    var creativeId = $button.data('creativeid');

    // 各種値をセット
    $modal.find('#addContent').val(content);
    $modal.find('.modal-title').text(modalTitle);
    $modal.find('.add_data_type').val(dataType);
    $modal.find('.creative_id').val(creativeId);

    // セレクトボックス値チェック
    $select = $modal.find('#selectClass');
    $select.val(classId);

    $delConfBtn = $modal.find('#delConflBtn');
    $delConfBtn.off('click');
    $delConfBtn.on('click', function () {
      $editModalContent.hide();
      $delModalContent.show();
    });

    $closeBtn = $modal.find('#closeBtn');
    $closeBtn.off('click');
    $closeBtn.on('click', function () {
      $modal.modal('hide');
    });
  });
}

function initialize() {
  setAddClassTextModal();
  seteditClassTextModal();
}

// 
(function () {
  //
  logInfo('[Start] data-view.js');
  initialize();
})();

/***/ }),

/***/ 2:
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__("./resources/assets/js/main/corpus/data-view.js");


/***/ })

/******/ });