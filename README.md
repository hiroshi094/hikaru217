# Php Engineer Tools hikaru217

[<img src="https://cdn.yutenji.biz/img/meta-icon_x100.png">](https://blog.yutenji.biz)     
ブログ：[還暦過ぎたエンジニアの挑戦](https://blog.yutenji.biz)のリポジトリです  

ブラウザ上で動かすPHPエンジニアのための開発用ツールです。  
MySQL Workbench を補完してphpのコーディングを助けます。   

## Important!

php7.0以上で動作します。  

開発時の便利ツールとして書いたものなので、ローカルな開発環境で使用してください。  
決して公開サーバー上では使用しないでください。  
データベースの接続情報などが漏れる危険があります。  

## Usage

1. ローカルマシンのDocumentRoot内にコピーしてアクセスしてください。    
`http://localhost/hikaru217`  

1. 最初にデータベース接続情報を入力してください  
<img src="https://cdn.yutenji.biz/img/hikaru217/series1_2.jpg" style="width:200px;">  

1. 各テーブル毎の詳細情報を参照し、Markdown形式で保存することができます。  
<img src="https://cdn.yutenji.biz/img/hikaru217/table_detail_md.jpg">  

## File Map

```
hikaru217
├ index.php
├ config.php
├ tools
│   ├ ajax
│   ├ components
│   ├ css
│   ├ js
│   ├ models
│   ├ index.php             [メニュー]
│   ├ show_tables.php       [テーブル一覧]
│   └ show_table_detail.php [テーブル詳細]
├ documents
│   └ tables                [生成したテーブル詳細MDファイルの保存場所]
└ json
```
