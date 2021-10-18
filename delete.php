<head>
<script src="js/jquery-3.6.0.min.js"></script>
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
<body>
	<div class="container">
		<h2 class="text-center" style="margin-top: 5px; padding-top: 0;">Delete Article</h2>
		
		<hr>
		<div class="text-center">
			<?php 
				require_once "vendor/autoload.php";
				$client 	= new MongoDB\Client;
				$dataBase 	= $client->selectDatabase('foodblog');
				$collection = $dataBase->selectCollection('articles');

                
				if(isset($_GET['action']) && $_GET['action'] == 'delete') {
					
					$filter		= ['_id' => new MongoDB\BSON\ObjectId($_GET['aid'])];

					$article = $collection->findOne($filter);
					if(!$article) {
						echo "Article not found.";
					}

					$fileName = 'upload/'.$article['fileName'];
					if(file_exists($fileName)) {
						if(!unlink($fileName)) {
							echo "Failed to delete file."; exit;
						}
					}

					$result = $collection->deleteOne($filter);

					if($result->getDeletedCount()>0) {
						echo "Article is deleted..";
					} else {
						echo "Failed to delete Article";
					}

					
				}

?>

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
                                <th>Date Article Created</th>
                                <th>Article Image</th>
                                <th>Title</th>
                                <th>Description</th>
                                <th>Category</th>
                                
                                <th>Delete</th>
                                </tr>
								<tr><td>'.$DateTime->format('d/m/Y H:i:s').'</td>
									<td width="180px"><img src="upload/'.$article['fileName'].'"</td>
										<td>'.$article['title'].'</td>
										<td>'.$article['description'].'</td>
										<td>'.$article['category'].'</td>
									';
						echo	"
									
									<td><a href='view.php?action=delete&aid=".$article['_id']."'>Delete</a></td>
							</table>";
		    		}
		    	?>
		    </div>
		</div>
	</div>
</body>
</html>

