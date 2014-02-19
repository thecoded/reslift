<?php 
$basePath = (strstr($_SERVER['PHP_SELF'], "/index.php")) ? "." : "..";
?>
<div class='navbar navbar-static-top'>
	<div class='navbar-inner'>
		<div class='container'>
			<a class='btn btn-navbar' data-target='.nav-collapse'
				data-toggle='collapse'> <span class='icon-bar'></span> <span
				class='icon-bar'></span> <span class='icon-bar'></span>
			</a>
			<ul class='nav pull-right' style="display:none">
				<?php if(isSignedIn()) {?>
				<li><a href="<?php echo $basePath;?>/user/profile.php">Profile</a></li>
				<li><a href="<?php echo $basePath;?>/user/sign_out.php">Sign out</a></li>
				<?php } else {?>
				<li><a href="<?php echo $basePath;?>/user/sign_in.php">Sign in</a></li>
				<li><a href="<?php echo $basePath;?>/user/sign_up.php">Sign up</a></li>
				<?php }?>
			</ul>
			<a class='brand' href='#'><img src="http://swankswap.com/site3/swankswap_files/logo1.png"></a>
			<div class='nav-collapse'>
				<ul class='nav' style="display:none">
					<li><a href="<?php echo $basePath;?>/index.php">Home</a></li>
					<?php
					if(isSignedIn()) {
						echo "<li><a href='$basePath/order/orders.php'>Orders</a></li>";
					}
					?>
				</ul>
			</div>
		</div>
	</div>
</div>
