<?php foreach ($comments as $comment) : ?>

<div class="comment-item mb-5">

    <div class="card w-75">
        <div class="card-body">
            <h5 class="card-title">Комментарий от: <span class="badge badge-dark"><?= $comment['comment_username'] ?></span> <span class="text-muted"><?= $comment['comment_date'] ?></span></h5>
            <p class="card-text"><?= $comment['comment_text'] ?></p>
            <div class="admin-control">
                <a href="#" class="btn btn-dark answer-comment" data-commentId="<?= $comment['id'] ?>">Ответить</a>
                <a href="#" class="btn btn-warning btn-deleteComment" data-commentId="<?= $comment['comment_id'] ?>">Удалить</a>
            </div>

        </div>
    </div>

    <?php if ($comment['answer_text']): ?>
    <div class="ml-3 card w-50 comment-sub">
        <div class="card-body">
            <h5 class="card-title">Ответ от: <span class="badge badge-warning"><?= $comment['answer_username'] ?></span> <?= $comment['answer_date'] ?></h5>
            <p class="card-text">
                <span>
                    <?= $comment['answer_text'] ?>
                </span>
            </p>
            <div class="admin-control">
                <button class="btn btn-warning answer-delete" data-answerId="<?= $comment['answer_id'] ?>">Удалить</button>
            </div>
        </div>
    </div>
    <?php else: ?>
        <div class="ml-3 card w-50 comment-sub add-answer-field">
            <div class="card-body">
                <h5 class="card-title"><?= $comment['answer_username'] ?> <?= $comment['answer_date'] ?></h5>
                <p class="card-text">
                    <span class="form-group admin-control">
                        <input id="answer-text-<?= $comment['comment_id'] ?>" type="text" class="form-control">
                    </span>
                </p>
                <div class="admin-control">
                    <a href="#" class="btn btn-dark answer-add" data-commentId="<?= $comment['comment_id'] ?>">Сохранить</a>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

<?php endforeach; ?>