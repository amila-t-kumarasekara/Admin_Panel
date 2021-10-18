<head>

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
		<h2 class="text-center" style="margin-top: 5px; padding-top: 0;">User Details</h2>
		
		<hr>
		<div class="text-center">
			<?php 
				require_once "vendor/autoload.php";
				$client 	= new MongoDB\Client;
				$dataBase 	= $client->selectDatabase('foodblog');
				$collection = $dataBase->selectCollection('user');

?>

<div class="col-md-8">
		    	
		    	<?php 
		    		$articles = $collection->find();
		    		foreach ($articles as $key => $article) {
		    			
		    			$data = json_encode( [
							'id' 			=> (string) $article['_id'],
							'first_name' 		=> $article['first_name'],
							'email' 	=> $article['email']
						], true);

		    			echo '<table>
                                <tr>
                                <th>ID</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Email</th>
                                </tr>
								<tr>
                                        <td>'.$article['_id'].'</td>
										<td>'.$article['first_name'].'</td>
										<td>'.$article['last_name'].'</td>
										<td>'.$article['email'].'</td>

										
							</table>';
		    		}
		    	?>
		    </div>
		</div>
	</div>
</body>
</html>


