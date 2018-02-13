<!DOCTYPE php>
<html lang="en">

<head>

    <meta name="viewport" content="width=device-width, initial-scale=1">

<style>
	* {
 font-size: small;
 font-family: Arial;
}
</style>


</head>

<?php

//Include the token creation file to give access to the variable $tokenVal
include('token.php');
//echo "<pre>$tokenVal</pre>";


?>


<body>
<h3> 1 Token Collection</h3>


<p>
	The current token is: <?php echo $tokenVal ?>
</p>


<h2>Projects</h2>
<h3> 1 Get Current User Project List</h3>
<p>
	curl -X GET -H "Content-Type: application/json" -H "token:<?php echo $tokenVal ?>" "http://api.3dusernet.com/3dusernetApi/api/project.json"
</p>

<h3> 2 Create a Project</h3>
<p>
	curl -X POST -H "Content-Type: application/json" -H "token:<?php echo $tokenVal ?>" -d '{"name": "<?php echo $ProjName ?>","description": "<?php echo $ProjDesc ?>","group_id": "<?php echo $GroupId ?>","latitude": "<?php echo $ProjLat ?>","logitude": "<?php echo $ProjLong ?>"}' "http://api.3dusernet.com/3dusernetApi/api/project.json"
</p>

<h3> 3 Update the Project with a new description and title</h3>
<p>
	curl -X PUT -H "Content-Type: application/json" -H "token:<?php echo $tokenVal ?>" -d '{"name": "<?php echo $ProjName1 ?>","description": "<?php echo $ProjDesc1 ?>","group_id": "<?php echo $GroupId ?>","latitude": "<?php echo $ProjLat1 ?>","logitude": "<?php echo $ProjLong1 ?>","id":"<?php echo $ProjID ?>"}' "http://api.3dusernet.com/3dusernetApi/api/project.json"
</p>

<h3> 4 Upload a Pointcloud to the Project</h3>
curl -X POST -H "Content-Type: multipart/form-data" -H "token:<?php echo $tokenVal ?>"  -F "files=@/Users/user/Desktop/UploadTests/Station.las" -F "file_name=StationAPI.las" -F "description=StationAPI Upload" -F "arguments=-a RGB INTENSITY –intensity-range 0 65535 –color-range 0 255" -F "project_id=<?php echo $ProjID ?>"  "http://api.3dusernet.com/3dusernetApi/api/point_cloud.json"

<h3> 5 Upload a Model to the Project</h3>
curl -X POST -H "Content-Type: multipart/form-data"  -H "token:<?php echo $tokenVal ?>"
-F "files=@/Users/user/Desktop/UploadTests/Male_Figure.zip"  -F "file_name=Male_Figure.zip" -F "description=Male Figure obj" -F "project_id=723" -F "extension=zip"  "http://api.3dusernet.com/3dusernetApi/api/models.json"

<h3> 6 Upload an image Thumbnail to go with a Pointcloud</h3>

<h3> 7 Upload an image Thumbnail to go with a Model</h3>

<h3> 8 Get details of a Single Project</h3>
<p>curl -X GET -H "Content-Type: application/json" -H "token:<?php echo $tokenVal ?>" -d '{ "id": 735  }' "http://api.3dusernet.com/3dusernetApi/api/project.json"
</p>


//////////////

<h2>Groups</h2>
<h3> 1 List all groups for that user with their ids</h3>
<p>
	curl -X GET -H "Content-Type: application/json" -H "token:<?php echo $tokenVal ?>"  "http://api.3dusernet.com/3dusernetApi/api/groups.json"
</p>

///////////////

<h2>Pointclouds</h2>
<h3> 1 Get list of all pointclouds of current user</h3>
curl -X GET -H "Content-Type: application/json" -H "token:<?php echo $tokenVal ?>"  "http://api.3dusernet.com/3dusernetApi/api/point_cloud.json"

<h3> 2 Get details of a single pointcloud</h3>
curl -X GET -H "Content-Type: application/json" -H "token:<?php echo $tokenVal ?>"  -d '{"id":676}' "http://api.3dusernet.com/3dusernetApi/api/point_cloud.json"  

<h3> 3 Download a single Pointcloud</h3>
curl **Insertlink** --output test.las

///////////////
<h2>Models</h2>
<h3> 1 Get list of all Models of Current User</h3>

<h3> 2 Get details of a single model</h3>

<h3> 3 Download a single model (with acompanying Transformation in JSON)</h3>


///////////////

<h2>Libraries</h2>
<h3> 1 List all Library Categories</h3>
<p>
	curl -X GET -H "Content-Type: application/json" -H "token:<?php echo $tokenVal ?>"  "http://api.3dusernet.com/3dusernetApi/api/library.json"
</p>

<h3> 2 Create a New Library Category</h3>

<h3> 3 Update the Library Category</h3>

<h3> 4 Get the details of a Single Category (The new one created)</h3>
curl -X GET -H "Content-Type: application/json" -H "token:<?php echo $tokenVal ?>" -d '{ "id": 90}' "http://api.3dusernet.com/3dusernetApi/api/library.json"

<h3> 5 Create a New Library Category (This returns an id for it)</h3> 
curl -X POST -H "Content-Type: application/json" -H "token:<?php echo $tokenVal ?>" -d '{"name":"DM API 1","description":"DM API Insert"}' "http://api.3dusernet.com/3dusernetApi/api/library.json"

<h3> 6 Upload pointcloud to a Library category</h3>

<h3> 7 Upload a model to a Library category</h3>

<h3> 8 Upload a snapshot to a Library category</h3>


</body>

</html>