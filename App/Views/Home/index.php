<!doctype html>
<html>
<head>
    <title>Home</title>
   
</head>

<body>
<div>
    <h1>Hello</h1>
    <p>Hello <?php echo htmlspecialchars($name); ?></p>

   <ul>
    	<?php foreach ($colors as $color): ?>
    		<li><?php echo htmlspecialchars($color); ?></li>
    	<?php endforeach; ?>

    </ul> 

</div>
</body>
</html>
