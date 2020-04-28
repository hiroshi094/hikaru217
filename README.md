# Php Engineer Tools hikaru217

ブラウザ上で動かすPHPエンジニアのための開発用ツールです  <img src="//cdn.yutenji.biz/img/meta-icon.png">  

## Important!

開発用時の便利ツールとして書いたものなので、ローカルな開発環境で使用してください。  
決して公開サーバー上では使用しないでください  
データベースの接続情報などが漏れる危険があります  

## Usage

ローカルマシンのDocumentRoot内にコピーしてアクセスしてください。    
`http://localhost/hikaru217`  

最初にデータベース接続情報を入力してください  
<img src="//cdn.yutenji.biz/img/hikaru217/series1_2.jpg" style="width:200px;">

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
