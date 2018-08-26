<?php
//create_cat.php
include 'connect.php';
include 'header.php';
 
if($_SERVER['REQUEST_METHOD'] != 'POST')
{
    //the form hasn't been posted yet, display it
    echo "<form method='post' action=''>
        Category name: <input type='text' name='cat_name' />
        Category description: <textarea name='cat_description' /></textarea>
        <input type='submit' value='Add category' />
     </form>";


$sql = "SELECT
					cat_id,cat_name,cat_description
        FROM
            categories";
 
$result = $dbconn->query($sql);
 
	if(!$result)
	{
			echo mysqli_error($dbconn);
	}
	else
	{
			if($result->num_rows == 0)
			{
					echo 'No categories defined yet.';
			}
			else
			{
					//prepare the table
					echo '<table border="1">
								<tr>
									<th>Category</th>
									<th>Last topic</th>
								</tr>'; 
							 
					while($row = $result->fetch_assoc())
					{               
							echo '<tr>';
									echo '<td class="leftpart">';
                  echo '<h3><a href="category.php?id">' . $row['cat_name'] . '</a></h3>' . $row['cat_description'];
									echo '</td>';
									echo '<td class="rightpart">';
															echo '<a href="topic.php?id=">Topic subject</a> at 10-10';
									echo '</td>';
							echo '</tr>';
					}
			}
	}
}


//////////////////posted
else
{
    //the form has been posted, so save it
    $sql = "INSERT INTO categories(cat_name, cat_description)
       VALUES('" . ($_POST['cat_name']) . "',
             '" . ($_POST['cat_description']) . "')";
    $result = $dbconn->query($sql);
    if(!$result)
    {
        //something went wrong, display the error
        echo 'Error' . mysqli_error($dbconn);
    }
    else
    {
        echo 'New category successfully added.';
    }
}
include 'footer.php';
?>

