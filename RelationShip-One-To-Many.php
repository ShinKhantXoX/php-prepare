<?php

// | Relationship     | Example            | Foreign Key        |
// | ---------------- | ------------------ | ------------------ |
// | **One-to-One**   | User → Profile     | `profiles.user_id` |
// | **One-to-Many**  | User → Posts       | `posts.user_id`    |
// | **Many-to-One**  | Posts → User       | `posts.user_id`    |
// | **Many-to-Many** | Students ↔ Courses | Pivot table        |

// One to Many

// ------------------- Database ----------------------

// users
// ---------
// id
// name

// posts
// ---------
// id
// user_id
// title

// ------------------- Pure Sql ----------------------
// SELECT *
// FROM posts
// WHERE user_id = 1;

// SELECT users.name, posts.title
// FROM users
// JOIN posts ON posts.user_id = users.id
// WHERE users.id = 1;

// --------------- PHP PDO Example -----------------
// $userId = 1;

// $sql = "SELECT * FROM posts WHERE user_id = :user_id";

// $stmt = $pdo->prepare($sql);
// $stmt->execute([
//     'user_id' => $userId
// ]);

// $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);


// ----------------------------------------------

// Important interview point:

// The foreign key is on the "many" side.

// users
//   |
//   | 1
//   |
//   | *
// posts