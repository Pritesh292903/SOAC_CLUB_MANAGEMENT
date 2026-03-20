<?php
include "database.php";

$result = mysqli_query($con,"SELECT * FROM User");
?>

<!DOCTYPE html>
<html>
<head>
<title>Users</title>
</head>

<body>

<h2>Registered Users</h2>

<table border="1" cellpadding="10">
        
<tr>
<th>ID</th>
<th>Image</th>
<th>Name</th>
<th>Email</th>
<th>Department</th>
<th>Enrollment</th>
<th>Mobile</th>
</tr>

<?php
while($row=mysqli_fetch_assoc($result))
{
?>

<tr>

<td><?php echo $row['id']; ?></td>

<td>
<img src="uploads/<?php echo $row['clubimage']; ?>" width="60">
</td>

<td><?php echo $row['fullname']; ?></td>

<td><?php echo $row['email']; ?></td>

<td><?php echo $row['department']; ?></td>

<td><?php echo $row['enrollment']; ?></td>

<td><?php echo $row['mobile']; ?></td>

</tr>

<?php
}
?>

</table>

</body>
</html>