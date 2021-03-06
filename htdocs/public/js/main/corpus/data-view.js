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
 * コーパスの編集
 */
function setEditCorpusModal() {
  var $modalEl = $('#editCorpusModal');

  $modalEl.off('show.bs.modal');
  $modalEl.on('show.bs.modal', function (event) {

    // フォームのバリデーション
    window.addEventListener('load', function () {
      var $forms = $('#edit-corpus-form');

      var validation = Array.prototype.filter.call($forms, function (form) {
        form.addEventListener('submit', function (event) {
          if (form.checkValidity() === false) {
            event.preventDefault();
            event.stopPropagation();
          }

          form.classList.add('was-validated');
        }, false);
      });
    }, false);
  });
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
    var dataType = parseInt($button.data('datatype'));
    var modalTitle = $button.data('mtitle');

    var $modal = $(this);
    // 各種値をセット
    $modal.find('.add_data_type').val(dataType);
    $modal.find('.modal-title').text(modalTitle);

    if (dataType === 0) {
      $modal.find('#selectClass option[value=""]').hide();
    } else {
      $modal.find('#selectClass option[value=""]').show();
    }

    $select = $modal.find('#selectClass');
    $select.off('change');
    $select.on('change', function () {
      logInfo('change');

      var $targetEl = $('#add-class-form-area');
      var $addClassNameField = $('#addClass');
      var idx = this.selectedIndex;
      var value = this.options[idx].value; // 値

      if (value !== "") {
        $targetEl.hide();
      } else {
        $targetEl.show();
        $addClassNameField.prop('required', true);
      }
    });

    // フォームのバリデーション
    window.addEventListener('load', function () {
      var forms = $('#add-content-form');

      var validation = Array.prototype.filter.call(forms, function (form) {
        form.addEventListener('submit', function (event) {
          if (form.checkValidity() === false) {
            event.preventDefault();
            event.stopPropagation();
          }

          form.classList.add('was-validated');
        }, false);
      });
    }, false);

    // 初期処理
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
    $modal.find('#edit-content .modal-title').text(modalTitle);
    $modal.find('.current_data_type').val(dataType);
    $modal.find('.creative_id').val(creativeId);

    logInfo('data-type: ' + dataType);

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

    // フォームのバリデーション
    window.addEventListener('load', function () {
      var forms = $('#edit-content-form');

      var validation = Array.prototype.filter.call(forms, function (form) {
        form.addEventListener('submit', function (event) {
          if (form.checkValidity() === false) {
            event.preventDefault();
            event.stopPropagation();
          }

          form.classList.add('was-validated');
        }, false);
      });
    }, false);
  });
}

function checkTrainingStatus(corpus_id, check_status, checker) {
  logInfo('[checkTrainingStatus] corpus_id: ' + corpus_id);

  $.ajax({
    url: '/corpus/training/check/' + corpus_id,
    type: 'GET',
    async: true
  })
  // Ajaxリクエストが成功した時発動
  .done(function (res) {

    res = JSON.parse(res);
    console.log(res);

    if (!res['result']) {
      // 処理に失敗しました
      logInfo(res['error']['message']);
      clearInterval(checker);
    } else {

      if (res['data']['corpus_status'] === parseInt(check_status)) {
        alert('コーパスの学習が完了しました');
        clearInterval(checker);

        // 画面再読み込み
        location.reload();
      } else {
        // ステータス確認継続
      }
    }
  })
  // Ajaxリクエストが失敗した時発動
  .fail(function (error) {

    // リクエストに失敗しました
    logInfo(error);
    clearInterval(checker);
  });
}

/**
 * bladeテンプレートから呼び出す
 */
function execTrainingStatusChecker() {
  logInfo('[execTrainingStatusChecker] start');

  var param = $('#data-view-js').data('checker-param');
  param = param.split('|');

  logInfo(param);

  var corpus_id = param[0];
  var check_status = param[1];
  var timer = 180000;

  if (corpus_id === undefined || check_status === undefined) {
    logInfo('[execTrainingStatusChecker] undefined param...');
    return;
  }

  var checker = setInterval(function () {
    checkTrainingStatus(corpus_id, check_status, checker);
  }, timer);

  checkTrainingStatus(corpus_id, check_status, checker);
}

/**
 * 学習実行確認アラート表示
 */
function setConfirmExecTraining() {

  logInfo('[setConfirmExecTraining] start');

  var corpus_id = $('#data-view-js').data('cid');
  logInfo(corpus_id);

  $('#exec_corpus_training_btn').off();
  $('#exec_corpus_training_btn').on('click', function () {

    if (corpus_id !== undefined) {
      if (confirm('学習の実行には料金が掛かります。\n本当に実行しますか？')) {
        location.href = "/corpus/training/exec/" + corpus_id;
      }
    }
  });
}

function initialize() {
  setAddClassTextModal();
  seteditClassTextModal();
  setEditCorpusModal();

  setConfirmExecTraining();
  execTrainingStatusChecker();
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