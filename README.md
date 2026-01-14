# 学習内容
PHPを使用することでCRUDの基本ロジックを理解する
SQLについても基本構文は使用できる状態にする

# 技術構成
- Vanilla PHP
- TailwindCSS(CDN)

# 目的
- 学習内容を記録する
- カテゴリーごとの学習時間をデータ化する

# やらないこと
* ログイン機能：PHPで実装すると開発時間が長時間化するので最小リリース。あくまで個人の記録用
* グラフ生成

# DB
records
| id | 型 | null | 内容 |
| --- | --- | --- | --- |
| id | int | not | ID |
| category | string | not | カテゴリーを記述 |
| comment | text | not ||||
## テーブル設計・リレーション