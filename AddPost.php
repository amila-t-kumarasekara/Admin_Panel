<?php
include('includes/header.php'); 
include('includes/navbar.php');
?>

<body>
	<div class="container">
		
		<h3 class="text-center" style="margin-top: 5px; padding-top: 0;">Insert A Blog Article</h3>
<hr>
		<div class="text-center">
			<?php 
				require_once "vendor/autoload.php";
				$client 	= new MongoDB\Client;
				$dataBase 	= $client->selectDatabase('foodblog');
				$collection = $dataBase->selectCollection('articles');
				if(isset($_POST['create'])) {
					$data 		= [
						'title' 		=> $_POST['title'],
						'description' 	=> $_POST['description'],
						'category' 		=> $_POST['category'],
						'createdOn' 	=> new MongoDB\BSON\UTCDateTime
					];

					if($_FILES['file']) {
						if(move_uploaded_file($_FILES['file']['tmp_name'], 'upload/'.$_FILES['file']['name'])) {
							$data['fileName'] = $_FILES['file']['name'];
						} else {
							echo "Failed to upload file.";
						}
					}

					$result = $collection->insertOne($data);
					if($result->getInsertedCount()>0) {
						echo "Article is created..";
					} else {
						echo "Failed to create Article";
					}
				}

				

			?>
		</div>
		<div class="row">
		    <div class="col-md-4">
			    <form class="form-horizontal" method="post" action="" enctype="multipart/form-data">
					<fieldset>
						<!-- Form Name -->
						<legend style="margin-top: 5px; padding-top: 0;">Article Details</legend>

						<!-- Text input-->
						<div class="form-group">
						  <label class="col-md-12" for="title">Title</label>  
						  <div class="col-md-12">
						  <input id="title" name="title" type="text" placeholder="" class="form-control input-md">
						  </div>
						</div>

						<!-- Text Area-->
						<div class="form-group">
						  <label class="col-md-12" for="description">Description</label>  
						  <div class="col-md-12">
						  <textarea id="description" name="description" placeholder="" class="form-control" rows="6"></textarea>
						  </div>
						</div>

						<!-- Text input-->
						<div class="form-group">
						  <label class="col-md-12" for="author">category</label>  
						  <div class="col-md-12">
						  <input id="category" name="category" type="text" placeholder="" class="form-control input-md">
						  </div>
						</div>

						<!-- File input-->
						<div class="form-group" id="fileInput">
						  <label class="col-md-12" for="file">Select Image</label>  
						  <div class="col-md-12">
						  <input id="file" name="file" type="file" placeholder="" class="form-control input-md">
						  </div>
						</div>

						<!-- Hidden article id -->
						<input type="hidden" name="aid" id="aid">

						<button id="create" name="create" class="btn btn-primary">Create Article</button>
						<button id="update" style="display: none;" name="update" class="btn btn-primary">Update Article</button>

					</fieldset>
				</form>
		    </div>
	

</body>
