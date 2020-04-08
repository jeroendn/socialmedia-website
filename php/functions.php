<?php
function sql_error($e) {
  echo '<div class="alert">An error occured: ' . $e->getMessage() . '</div>';
}
