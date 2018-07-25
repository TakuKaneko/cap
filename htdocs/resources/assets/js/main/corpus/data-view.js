// デバッグ用
const debug = true;

function logInfo(msg) {
  if(debug) 
    console.log(msg);
}


/**
 * コーパスの編集
 */
function setEditCorpusModal() {
  const $modalEl = $('#editCorpusModal');

  $modalEl.off('show.bs.modal');
  $modalEl.on('show.bs.modal', function (event) {

    // フォームのバリデーション
    window.addEventListener('load', function() {
      const $forms = $('#edit-corpus-form');

      const validation = Array.prototype.filter.call($forms, function(form) {
        form.addEventListener('submit', function(event) {
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
  const $modalEl = $('#addClassTextModal');

  $modalEl.off('show.bs.modal');
  $modalEl.on('show.bs.modal', function (event) {
    // クリックしたボタン要素を取得して、データ受け渡し
    const $button = $(event.relatedTarget);
    const dataType = parseInt($button.data('datatype'));
    const modalTitle = $button.data('mtitle');

    var $modal = $(this);
    // 各種値をセット
    $modal.find('.add_data_type').val(dataType);
    $modal.find('.modal-title').text(modalTitle);

    
    if(dataType === 0) {
      $modal.find('#selectClass option[value=""]').hide();
    } else {
      $modal.find('#selectClass option[value=""]').show();
    }

    $select = $modal.find('#selectClass');
    $select.off('change');
    $select.on('change', function() {
      logInfo('change');

      const $targetEl = $('#add-class-form-area');
      const $addClassNameField = $('#addClass');
      const idx = this.selectedIndex;
      const value = this.options[idx].value; // 値
    
      if(value !== "") {
        $targetEl.hide();
    
      } else {
        $targetEl.show();
        $addClassNameField.prop('required', true);

      }
    });


    // フォームのバリデーション
    window.addEventListener('load', function() {
      const forms = $('#add-content-form');

      const validation = Array.prototype.filter.call(forms, function(form) {
        form.addEventListener('submit', function(event) {
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
  const $modalEl = $('#editClassTextModal');

  $modalEl.off('show.bs.modal');
  $modalEl.on('show.bs.modal', function (event) {
    const $modal = $(this);
    const $editModalContent = $modal.find('#edit-content');
    const $delModalContent = $modal.find('#del-content');
  
    $delModalContent.hide();
    $editModalContent.show();

    // クリックしたボタン要素を取得して、データ受け渡し
    const $button = $(event.relatedTarget);
    const dataType = $button.data('datatype');
    const modalTitle = $button.data('mtitle');
    const content = $button.data('content');
    const classId = $button.data('classid');
    const creativeId = $button.data('creativeid');

    
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
    $delConfBtn.on('click', function() {
      $editModalContent.hide();
      $delModalContent.show();
    });

    $closeBtn = $modal.find('#closeBtn');
    $closeBtn.off('click');
    $closeBtn.on('click', function() {
      $modal.modal('hide');
    });


    // フォームのバリデーション
    window.addEventListener('load', function() {
      const forms = $('#edit-content-form');

      const validation = Array.prototype.filter.call(forms, function(form) {
        form.addEventListener('submit', function(event) {
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
    url:'/corpus/training/check/' + corpus_id,
    type:'GET',
    async:true
  })
  // Ajaxリクエストが成功した時発動
  .done( (res) => {

    res = JSON.parse(res);
    console.log(res);

    if(!res['result']) {
      // 処理に失敗しました
      logInfo(res['error']['message']);
      clearInterval(checker);

    } else {
      
      if(res['data']['corpus_status'] === parseInt(check_status)) {
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
  .fail( (error) => {

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

  let param = $('#data-view-js').data('checker-param');
  param = param.split('|');

  logInfo(param);


  const corpus_id = param[0];
  const check_status = param[1];
  const timer = 60000;

  if(corpus_id === undefined || check_status === undefined) {
    logInfo('[execTrainingStatusChecker] undefined param...');
    return;
  }


  const checker = setInterval(function(){
    checkTrainingStatus(corpus_id, check_status, checker);
  } , timer);

  checkTrainingStatus(corpus_id, check_status, checker);
}



function initialize() {
  setAddClassTextModal();
  seteditClassTextModal();
  setEditCorpusModal();

  execTrainingStatusChecker();
}

// 
(function() {
  //
  logInfo('[Start] data-view.js');
  initialize();

})();