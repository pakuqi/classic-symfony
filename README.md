# 基本からしっかり学ぶSymfony2 入門の写経です

## 開発環境
- Mac  
- PHP 5.5.38(Macにデフォルトで入っていたもの)
- php.ini  
/private/etc/php.ini.defaultを/etc/php.iniにコピーしました。  
- MySQL   
Vagrant上のUbuntuにver5.7をインストールしました。

## 開発環境の準備
要件はほぼ全て満たしていたのでtimezoneの設定をしただけです。
- PHP 5.3.9以上: OK  
- PHPのJSONサポート: OK
- PHPのctype関数サポート: OK
- データベースのPDOモジュールがインストールされている: OK
- SQLiteモジュールがインストールされている: OK
- timezoneが設定されている: NG  
config.phpの実行でtimezoneの設定がされていないと言われたので/etc/php.iniのdate.timezoe = Asia/Tokyoを設定しました。

## 動作確認
手軽に確認できるので、ビルトインサーバを使いました。  
$ php app/console server:run  
書籍では"server/start"になっていましたが
>This command needs the pcntl extension to run.
>You can either install it or use the server:run command instead to run the built-in web server.

と表示されます。
pcntl extensionが必要らしいですね。  
サポートページによるとserver:runでも書籍の内容を進められるので構わないそうです。  
https://github.com/hidenorigoto/symfony2-book/issues/15

## 実行
1. ソースの取得  
$ git clone https://github.com/pakuqi/classic-symfony.git

2. composerのインストール  
$ curl -sS https://getcomposer.org/installer | php  
$ sudo mv composer.phar /usr/local/bin/composer  
$ sudo chmod a+x /usr/local/bin/composer
3. モジュールのインストール  
$ composer install

3. ビルトインサーバ実行  
$ php app/console server:run  

# 4.3 メール通知機能の作成に関して
メール送信すると  
Failed to authenticate on SMTP server with username using 1 possible authenticators  
と表示されてエラーになります。Gmailのセキュリティで弾かれているようです。  
ブロックされたログインについてご確認くださいというメールがGoogleから送られてきます。  
安全性の低いアプリへのアクセスを許可のリンクを押して画面遷移します。  
安全性の低いアプリの許可: 有効  
するとエラーが出なくなります。安全性が低くなるので、開発用のアカウントを別途作成した方が良いと思います。

メール送信時に  
Connection could not be established with host 127.0.0.1 [Connection refused #61]  
と表示された場合は以下のコマンドを実行してsmtpサーバを起動して下さい。  
$ sudo postfix start
