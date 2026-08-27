<?php if (isset($_SESSION["message"])): ?>
  <div id="toast" class="toast">
    <?= hsc($_SESSION["message"]) ?>
  </div>
  <?php unset($_SESSION["message"]); ?>
<?php endif; ?>

