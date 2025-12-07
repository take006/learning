<?php
//よく使用するエラーメッセージを事前に定義
define("MESSAGE_SIGNIN_ERROR", "サインインエラー.");
define("MESSAGE_SIGNUP_ERROR", "サインアップエラー.");
define("MESSAGE_DB_CONNECTION_ERROR", "データベース接続エラー.");

// ===========================
// PDO接続共通関数
// ===========================
function getPDO() {
    static $pdo;
    if (!$pdo) {
        try {
            $pdo = new PDO(
                "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4",
                DB_USER,
                DB_PASS,
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false
                ]
            );
        } catch (PDOException $e) {
            exit('DB接続エラー: ' . $e->getMessage());
        }
    }
    return $pdo;
}


//エスケープ処理
function h($str){
  return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}

//CSRFトークン
function setToken(){
    $csrf_token = bin2hex(random_bytes(32));
    $_SESSION['csrf_token'] = $csrf_token;

    return $csrf_token;
}

//メッセージ
function set_message($message){
    $_SESSION['SESSION_MESSAGE'] = $message;
}

function get_message(){
    if(isset($_SESSION['SESSION_MESSAGE']) === false ){
        return false;
    }
    $message = $_SESSION['SESSION_MESSAGE'];
    unset($_SESSION['SESSION_MESSAGE']);
    return $message;
}

// ===========================
// アカウント関数
// ===========================
function sign_in($account){
    session_regenerate_id();
    $_SESSION['session_account'] = $account;
}
function is_sign_in(){
    return isset($_SESSION['session_account']);
} 
?>
