<head><script src="js/jquery-3.6.0.min.js"></script>
<style>
table {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

td, th {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 8px;
}
</style>
</head>
<?php
include('includes/header.php'); 
include('includes/navbar.php');
?>

<div class="container">
		<h2 class="text-center" style="margin-top: 5px; padding-top: 0;">Update Article</h2>
		
		<hr>
<div class="text-center">
			<?php 
				require_once "vendor/autoload.php";
				$client 	= new MongoDB\Client;
				$dataBase 	= $client->selectDatabase('foodblog');
				$collection = $dataBase->selectCollection('articles');
		


				if(isset($_POST['update'])) {
					
					$filter		= ['_id' => new MongoDB\BSON\ObjectId($_POST['aid'])];

					$data 		= [
						'title' 		=> $_POST['title'],
						'description' 	=> $_POST['description'],
						'category' 		=> $_POST['category']
					];

					$result = $collection->updateOne($filter, ['$set' => $data]);

					if($result->getModifiedCount()>0) {
						echo "Article is updated..";
					} else {
						echo "Failed to update Article";
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
						  <label class="col-md-12" for="category">category</label>  
						  <div class="col-md-12">
						  <input id="category" name="category" type="text" placeholder="" class="form-control input-md">
						  </div>
						</div>

						<!-- Hidden article id -->
						<input type="hidden" name="aid" id="aid">

                    
						<button id="update"  name="update" class="btn btn-primary">Update Article</button>

					</fieldset>
				</form>
		    </div>
		    <div class="col-md-8">
		    	<!-- Show Articles -->
		    	<?php 
		    		$articles = $collection->find();
		    		foreach ($articles as $key => $article) {
		    			$UTCDateTime 	= new MongoDB\BSON\UTCDateTime((string)$article['createdOn']);
		    			$DateTime 		= $UTCDateTime->toDateTime();

		    			$data = json_encode( [
							'id' 			=> (string) $article['_id'],
							'title' 		=> $article['title'],
							'description' 	=> $article['description'],
							'category' 		=> $article['category']
						], true);

		    			echo '<table>
                                <tr>
                             
                                <th>Title</th>
                                <th>Description</th>
                                <th>Category</th>
                                <th>Update</th>
                                
                                </tr>
								<tr>
										<td>'.$article['title'].'</td>
										<td>'.$article['description'].'</td>
										<td>'.$article['category'].'</td>
									';
						echo	"
									
                               <td> <a href='javascript:updateArticle($data)'>Edit</a><br><br></td></tr>
							</table>";
		    		}
		    	?>
		    </div>
		</div>
	</div>
</body>
</html>
<script type="text/javascript">
	function updateArticle(article) {
		console.log(article);
		$('#aid').val(article.id);
		$('#title').val(article.title);
		$('#description').val(article.description);
		$('#category').val(article.category);

		$('#update').show();
	}
</script>