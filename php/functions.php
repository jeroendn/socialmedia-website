<?php
function sql_error($e) {
  echo '<div class="alert">An error occured: ' . $e->getMessage() . '</div>';
}

function convert_post_message_links($text) {
  return preg_replace('/(?<!\S)http:\/\/([0-9a-zA-Z.\/?=_&-]+)/', '<a href="http://$1" target="_blank">$1</a>', preg_replace('/(?<!\S)https:\/\/([0-9a-zA-Z.\/?=_&-]+)/', '<a href="https://$1" target="_blank">$1</a>', htmlspecialchars($text)));
}
