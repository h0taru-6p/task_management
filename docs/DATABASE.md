# database.md DB設計
DB = task
カラム名 | データ型 | 内容 | その他

## users
id | int | ユーザID | primary key, auto increment
name | varchar(100) | ユーザ名 | not null
email | varchar(255) | メールアドレス | unique
password | varchar(100) | パスワード | not null
created_at | datetime | 作成日 | default current_timestamp

## tasks
id | int | タスクID | primary key, auto increment
user_id | int | ユーザID | references users(id)
<!-- category_id -->
title | varchar(100) | タイトル | not null
description | text | 説明文 |default null
due_date | datetime | 期限日 | default null
completed | boolean | 完了/未完了 | default false
updated_at | datetime | 更新日 | default current_timestamp on update current_timestamp
created_at | datetime | 作成日 | default current_timestamp

<!-- -categories
id
task_id
created_at -->

