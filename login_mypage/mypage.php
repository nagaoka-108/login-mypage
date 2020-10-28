<?php
mb_internal_encoding("utf8");

session_start();

if(empty($_SESSION['id'])){
    


try{
    //try,cacth文。DBに接続できなければエラーメッセージを表示。
    $pdo = new PDO("mysql:dbname=nagaoka;host=localhost;","root","root");
} catch(PDOException $e){
    die("<p>申し訳ございません。現在サーバーが混み合っており一時的にアクセスが出来ません。<br>しばらくしてから再度ログインをしてください。</p>
    <a href='http://localhost/login_mypage/login.php'>ログイン画面へ</a>"
       );
}

//prepared statement(プリペアードステートメント)でSQL文の型を作る。(DBとpostデータを照合。select文とwhere句を使用。)
$stmt = $pdo->prepare("select * from login_mypage where mail = ? && password = ?");

//bindValueを使用し、where句に何を入れるか。mailとpassword。パラメーターをセット。
$stmt->bindValue(1,$_POST["mail"]);
$stmt->bindValue(2,$_POST["password"]);

//executeでクエリを実行。
$stmt->execute();

$pdo = NULL;

//fetchとwhile文でデータを取得し、sessionに代入。
while($row = $stmt->fetch()){
    $_SESSION['id'] = $row['id'];
    $_SESSION['name'] = $row['name'];
    $_SESSION['mail'] = $row['mail'];
    $_SESSION['password'] = $row['password'];
    $_SESSION['picture'] = $row['picture'];
    $_SESSION['comments'] = $row['comments'];
}

//データが取得出来ずに(emptyを使用して判明)sessionがなければ、リダイレクト(エラー画面へ)
if(empty($_SESSION['id'])){
    header("Location:login_error.php");
    }
    
if(!empty($_POST['login_keep'])){
    $_SESSION['login_keep'] = $_POST['login_keep'];
    }
    
}

if(!empty($_SESSION['id']) && !empty($_SESSION['login_keep'])){
    setcookie('mail',$_SESSION['mail'],time()+60*60*24*7);
    setcookie('password',$_SESSION['password'],time()+60*60*24*7);
    setcookie('login_keep',$_SESSION['login_keep'],time()+60*60*24*7);
    
} else if(empty($_SESSION['login_keep'])){
    setcookie('mail','',time()-1);
    setcookie('password','',time()-1);
    setcookie('login_keep','',time()-1);
}

?>




<!DOCTYPE html>
<html　lang="ja">
    <head>
        <title>マイページ登録</title>
        <link rel="stylesheet" type="text/css" href="mypage.css">
    </head>
    
    <body>
        
        <header>
            <img src="4eachblog_logo.jpg">
            <div class="login"><a href="login.php">ログイン</a></div>
        </header>

        <main>
            <div class="confirm">
                <div class="form_contents">
                    <h2>会員情報</h2>
                    <div class="aisatu">
                        <?php echo "こんにちは！ " .$_SESSION['name']."さん";?>
                    </div>
                    
                    <div class="profile_pic">
                        <img src="<?php echo $_SESSION['picture'];?>">
                    </div>
                    
                    <div class="profile">
                        <p>氏名：<?php echo $_SESSION['name'];?></p>
                        <p>メール：<?php echo $_SESSION['mail'];?></p>
                        <p>パスワード：<?php echo $_SESSION['password'];?></p>
                    </div>
                    
                    <div class="comments">
                        <?php echo $_SESSION['comments'];?>
                    </div>
                    
                    <div class="buttons">
                            <form action="mypage_hensyu.php" method="post" class="form_center">
                                <input type="hidden" value="<?php echo rand(1,10);?>" name="from_mypage">
                                <input type="submit" class="submit_button" size="35" value="編集する">
                            </form>
                    </div>

                </div>

            </div>
        </main>
        
        <footer>
            ©️ 2018 InterNous.inc. All rights reserved
        </footer>
        
        
        
        
        
        
    </body>
</html>