<?php
include_once __DIR__ . '../../php/session.php';
?>

<!DOCTYPE html>
<html>
  <head>
    <title>Cloud Storage - Your documents</title>
    <meta name="description" content=""/>
    <?php include_once __DIR__ . '../../php/head.php' ?>
  </head>

  <body>
    <!-- header -->
    <?php include_once __DIR__ . '../../php/header.php' ?>

    <main id="documents" class="page-content">
      <section class="container mt-3">
        <div class="card p-2">
          <form action="php/ajax/save_file.php" method="post" enctype="multipart/form-data">
            <input type="file" name="file_upload" id="file_upload" class="btn btn-primary">
            <input type="submit" value="Upload" name="upload" class="btn btn-primary">
          </form>
        </div>
      </section>

      <section class="container mt-3">
        <?php
      	$sql = "SELECT * FROM document WHERE user_id = '" . $_SESSION['user_id'] . "' ORDER BY document_date DESC";
      	$stmt = $conn->prepare($sql);
      	$stmt->execute();
      	$documents = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($documents as $document) {
        ?>
        <div class="card mt-3 p-2">
          <div class="data">
            <?php
            // get image from secure location
            $doc_name = pathinfo($document['document_name']);
            if ($doc_name['extension'] == 'png' || $doc_name['extension'] == 'jpg' || $doc_name['extension'] == 'jpeg' || $doc_name['extension'] == 'gif' || $doc_name['extension'] == 'jfif') {
              echo '<img src="php/getfile.php?file=' . htmlspecialchars($document['document_name']) . '"/>';
            }
            else if ($doc_name['extension'] == 'mp4') {
              echo '<video src="php/getfile.php?file=' . htmlspecialchars($document['document_name']) . '" type="mp4" controls></video>';
            }
            else {
              echo '<img src="design/no_image.png"/>';
            }
            ?>
            <p class="card-title"><?php echo htmlspecialchars($document['document_name']) ?></p>
            <p class="file-size"><?php file_size_calc(get_file_dir($document['document_name'])); ?></p>
            <p class="date"><?php echo date("d/M/Y H:i", strtotime($document['document_date'])); ?></p>
          </div>
          <div class="buttons">
            <a href="php/getfile.php?file=<?php echo htmlspecialchars($document['document_name']) ?>" class="btn btn-primary" download="<?php echo htmlspecialchars($document['document_name']) ?>">Download</a>
            <a href="#!" class="btn btn-info btn-share">
            <?php
            $sql = "SELECT user.user_id, user.user_mail FROM share INNER JOIN user ON share.user_id = user.user_id WHERE document_id=:document_id";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':document_id', $document['document_id'], PDO::PARAM_INT);
            $stmt->execute();
            $shares = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if (empty($shares)) { ?>Share<?php } else { ?>View shares<?php }
            ?>
            </a>
            <a href="#!" class="btn btn-danger btn-delete">Delete</a>
          </div>
          <input type="hidden" name="document_id" value="<?php echo $document['document_id'] ?>">
          <div class="share mt-2">
            <div class="current-share mt-2">
            <?php
            if (!empty($shares)) {
              foreach ($shares as $share) {
                ?><div class="container mb-1"><p><?php echo htmlspecialchars($share['user_mail']); ?></p><button class="btn btn-danger btn-remove-share">Remove share</button><input type="hidden" value="<?php echo $share['user_id'] ?>"></div><?php
              }
            }
            else {
              ?><p>This file isn't shared yet.</p><?php
            }
            ?>
            </div>
            <div class="add-share mt-4">
              <input class="form-control" type="text" placeholder="User mail">
              <button class="btn btn-primary">Add share</button>
            </div>
          </div>
        </div>
        <?php
        }
        ?>
      </section>
    </main>

    <!-- footer -->
    <?php include_once __DIR__ . '../../php/footer.php' ?>

    <!-- scripts -->
    <?php include_once __DIR__ . '../../php/js_include.php' ?>
  </body>
</html>
