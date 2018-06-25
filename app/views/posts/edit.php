<!DOCTYPE html>
<html>
<head>
	<title> Posts</title>
</head>
<body>

	<h3>Eidt Post</h3>
	<form action="/posts/1/edit/update" method="POST" role="form">
		<input type="hidden" name="_method" value="PUT">
		<div class="form-group">
			<label for="">Post Title</label>
			<input type="text" name="title" class="form-control" value="Awesome title" placeholder="Input field">
		</div>

		<div class="form-group">
			<label for="">Post Body</label>
			<input type="text" name="body" class="form-control" value="Awesome body" id="" placeholder="Input field">
		</div>
	
		<button type="submit" class="btn btn-primary">Update</button>
	</form>


</body>
</html>