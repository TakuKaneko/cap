// デバッグ用
const debug = true;

function logInfo(msg) {
  if(debug) console.log(msg);
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
  const $modalEl = $('#editUserModal');

  $modalEl.on('show.bs.modal', function (event) {
    logInfo('open modal');

    // クリックしたボタン要素を取得して、データ受け渡し
    const $button = $(event.relatedTarget);
    const user_id = $button.data('edit-user');
    const sei_kanji = $button.data('sei-kanji');
    const mei_kanji = $button.data('mei-kanji');
    const email = $button.data('email');

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
  const $modalEl = $('#deleteUserModal');

  $modalEl.off('show.bs.modal');
  $modalEl.on('show.bs.modal', function (event) {
    logInfo('open modal');

    // クリックしたボタン要素を取得して、データ受け渡し
    const $button = $(event.relatedTarget);
    const user_id = $button.data('delete-user');

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
(function() {
  //
  logInfo('[Start] settings.js');
  initialize();

})();