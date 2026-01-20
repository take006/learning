# 概要
自分のプログラミング学習履歴をを記録するアプリケーション。Slack、ChatWorkなどのチャットツールやNotionなどのアプリで管理していたが、学習時間の集計が出来ない、カテゴリーごとに円滑に管理できないなど原体験を元に作成。

## 目的
- 日々の学習内容を記録する（学習日記）
- カテゴリーごとの学習時間をデータ化する（集計）

# 技術構成
- Vanilla PHP
- TailwindCSS(CDN)
- MySQL

## 選定理由
- PHPを使用することでCRUDの基本ロジックを理解する
- PDOでSQL文を作成することでSQL文に触れる

# テーブル設計
DB名：Learning-app

## records
| id | 型 | null | 内容 |
| --- | --- | --- | --- |
| id | int | not | Unique id・Auto Increment |
| category | string | not | カテゴリーを記述 |
| comment | text | not | 学習内容を記述する。文字制限無し |
| created_at | timestamp | not | 作成日時 |
| updated_at | timestamp | not | 更新日時 |


#　追加予定機能
## ピン止め機能
テーブルにlockedカラムを追加して0=OFF, 1=ONとしてピン止め機能を実装。

## TODO表示機能
TODOを表示してカテゴリーごとのTODOリストの進捗管理ができるようにする。
## ログイン機能
現在はベーシック認証を掛けているが、PHPでユーザー機能を実装する

## グラフ生成
集計値から円グラフ、棒グラフを作成して学習記録を可視化する
