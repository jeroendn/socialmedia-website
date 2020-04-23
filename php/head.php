<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<link rel="stylesheet" type="text/css" href="css/style.css">
<link href="https://fonts.googleapis.com/css?family=Indie+Flower&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
<?php if (isset($user_data[0]['username'])) { ?><link rel="icon" type="image/png" href="php/get_profile_icon.php?user=<?php echo htmlspecialchars($user_data[0]['username']); ?>" /><?php } else { ?><link rel="icon" type="image/png" href="design/post-it_icon.png" /><?php } ?>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta charset="utf-8">
