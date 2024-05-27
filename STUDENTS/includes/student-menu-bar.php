<div id="mySidebar" class="sidebar">
	<button type="button" title="Close Menu" class="closebtn close" onclick="closeNav()">×</button>
	<br>
	<div class="mymenubar">
	<ul class=" menu-overal list-unstyled">
			<li><a href="index.php"><i class="menu-icon fa fa-tasks"></i> Home Page </a></li>
		</ul>
		<?php if(isset($_SESSION['mystudentid'])){	?>
		<ul class=" menu-overal list-unstyled">
			<li>
				<a class="collapsed" data-toggle="collapse" href="#student-management">
					<i class="menu-icon fa fa-school"></i>
					<i class="fa fa-chevron-circle-down place-right"></i>
					<i class="fa fa-chevron-circle-up place-right"></i>
					<span>Manage Booking</span>
				</a>
				<ul id="student-management" class="collapse list-unstyled">
					<li>
						<a href="my-room-details.php">
							<i class="fa fa-calendar-check"></i>
							Pending Payment
						</a>
					</li>
					<li>
						<a href="booked-room-details.php">
							<i class="fa fa-user-check"></i>
							Successful Bookings
						</a>
					</li>
					<li>
					
						<a href="checkout.php">
							<i class="fa fa-money-bill-wave"></i>
							Checkout
						</a>
	
					</li>
			    </ul>
		    </li>
		</ul>
		<ul class=" menu-overal list-unstyled">
			<li>
				<a class="collapsed" data-toggle="collapse" href="#studentstatus">
					<i class="menu-icon fa fa-user"></i>
				    <i class="fa fa-chevron-circle-down place-right"></i>
				    <i class="fa fa-chevron-circle-up place-right"></i>
				    Manage Account
				</a>
				<ul id="studentstatus" class="collapse list-unstyled">
					<li>
						<a href="../ADMIN/download-details.php?studentid=<?php echo htmlentities($studentid);?>">
							<i class="menu-icon fa fa-download"></i>
							Download Your Details
						</a>
					</li>
					<li>
						<a href="edit-details.php">
							<i class="menu-icon fa fa-th-list"></i>
							Edit Details
						</a>
					</li>

				</ul>
			</li>
		</ul>
		<?php } ?>
		<ul class=" menu-overal list-unstyled">
			<li><a href="available-hostels.php"><i class="menu-icon fa fa-house-user"></i> Hostels Available </a></li>
		</ul>
		<ul class=" menu-overal list-unstyled">
			<li><a href="contact-us.php"><i class="menu-icon fa fa-envelope"></i> Contact Us </a></li>
			<li><a href="about-us.php"><i class="menu-icon fa fa-info-circle"></i> About Us </a></li>
		</ul>
		<ul class=" menu-overal list-unstyled">
			<?php if(isset($_SESSION['mystudentid'])){	?>
				<li><a href="log-out.php"><i class="menu-icon fa fa-eject"></i>Log Out</a></li>
			<?php
			}else{?>
				<li><a href="login.php"><i class="menu-icon fa fa-user-check"></i>Log In</a></li>
			<?php
			}
			?>   
			
    	</ul>
	</div>
</div>