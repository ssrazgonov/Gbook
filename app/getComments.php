<?php
require 'config/db.php';

$query = $db->prepare("SELECT 

c.id as comment_id, 
c.text as comment_text, 
c.date as comment_date, 
u.username as comment_username, 
ua.username as answer_username,
a.text as answer_text,
a.date as answer_date,
a.id as answer_id

FROM comment AS c

LEFT JOIN user AS u ON c.author_id = u.id 
LEFT JOIN answer AS a ON c.answer_id = a.id
LEFT JOIN user AS ua ON a.author_id = ua.id

ORDER BY c.id DESC");

$query->execute();

$comments = $query->fetchAll(PDO::FETCH_ASSOC);

ob_start();

require 'tpl/_comments.php';

echo ob_get_clean();