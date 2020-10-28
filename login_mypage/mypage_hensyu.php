<?php

mb_internal_encoding("utf8");

session_start();

if(empty($_POST['from_mypage'])){
    header("Location:login_error.php");
}

?>



<!DOCTYPE html>
<html　lang="ja">
    <head>
        <title>マイページ登録</title>
        <link rel="stylesheet" type="text/css" href="mypage_hensyu.css">
    </head>
    
    <body>
        
        <header>
            <img src="4eachblog_logo.jpg">
            <div class="login"><a href="login.php">ログイン</a></div>
        </header>

        <main>
            <div class="confirm">
            <form action="mypage_update.php" method="post">
                <div class="form_contents">
                    <h2>会員情報</h2>
                    <div class="aisatu">
                        <?php echo "こんにちは！ " .$_SESSION['name']."さん";?>
                    </div>
                    
                    <div class="profile_pic">
                        <img src="<?php echo $_SESSION['picture'];?>">
                    </div>
                    
                    <div class="profile">
                        <p>氏名：<input type="text" size="30" value="<?php echo $_SESSION['name'];?>" name="name"></p>
                        <p>メール：<input type="text" size="30" value="<?php echo $_SESSION['mail'];?>" name="mail"></p>
                        <p>パスワード：<input type="text" size="30" value="<?php echo $_SESSION['password'];?>" name="password"></p>
                    </div>
                    
                    <div class="comments">
                        <textarea rows="3" cols="65" name="comments"><?php echo $_SESSION['comments'];?></textarea>
                    </div>
                    
                    <div class="buttons">
                        <div>
                            
                            <input type="submit" class="submit_button" size="50" value="この内容に変更する">
                        </div>
                    </div>

                </div>
            </form>
            </div>
        </main>
        
        <footer>
            ©️ 2018 InterNous.inc. All rights reserved
        </footer>
        
        
        
        
        
        
    </body>
</html>