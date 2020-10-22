$(function () {
    $('#agents_create_form').validate({
        //検証ルール
        rules: {
            name: {
                required: true,
                minlength: 3,
            }
        },
        //入力項目ごとのエラーメッセージ定義
        messages: {
            name: {
                required: '名前を入力してください',
                minlength: '３文字以上で入力してください',

            }
        },

        //エラーメッセージ出力箇所
        errorPlacement: function (error, element) {
            error.insertAfter(element);
        },
        debug: true
    });
});





// rules: {
//     【name属性】: {
//         // 入力されているか（必須項目）【Boolean】
//         required: true,

//         // バリデーション結果をサーバに問い合わせる【オブジェクト】
//         remote: "check-email.php",

//         // メールアドレスの形式かどうか（xx@xx.xx）【Boolean】
//         email: true,

//         // URLの形式かどうか【Boolean】
//         url: true,

//         // 日付かどうか【Boolean】
//         date: true,

//         // ISO形式の日付かどうか【Boolean】
//         dateISO: true,

//         // 10進数かどうか【Boolean】
//         number: true,

//         // 整数の数値のみかどうか【Boolean】
//         digits: true,

//         // クレジットカード番号の形式かどうか【Boolean】
//         creditcard: true,

//         // 指定した値と一致しているか【セレクター】
//         equalTo: 'input[name=mail]', // '.email'、'#email'などセレクター

//         // 入力文字数・チェックボックスの選択数が設定値以下か【数値】
//         maxlength: 4,

//         // 入力文字数・チェックボックスの選択数が設定値以上か【数値】
//         minlength: 4,

//         // 入力文字数・チェックボックスの選択数が設定値の範囲内か【配列】
//         rengelength: [2, 6],

//         // 入力数値の値が設定値の範囲内か【配列】
//         renge: [13, 23],

//         // 入力数値の値が設定値の倍数か【数値】
//         step: [13, 23],

//         // 数値が設定値以下か【数値】
//         max: 10,

//         // 数値が設定値以上か【数値】
//         min: 10,
//     },
// },