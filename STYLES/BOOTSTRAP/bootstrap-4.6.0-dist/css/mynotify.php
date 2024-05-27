 <div id="floating-cart-container">
        <div id="cart-icon-container">
            <img id="cart-icon" src="./view/images/cart-icon.png"
                alt="cartimg">
            <div id="count">
            <?php echo $cartModel->cartSessionItemCount; ?>
        </div>
        </div>


<a href="student-unpaid-bookings.php">

						
						<?php
						
						$myunpaid_students="SELECT * FROM AdminNotifications  ";
						$mystudent_unpaid=$con->prepare($myunpaid_students);
						$mystudent_unpaid->execute();
						$mystudent_unpaid->store_result();

						$total_studunpaid= $mystudent_unpaid->num_rows;


						{?><b class="label notification"><?php echo htmlentities($total_studunpaid); ?></b>
							<?php
	
							}?>

					</a>
		
		
		
		
			<span class="fa fa-bell"></span>