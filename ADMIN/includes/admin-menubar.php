<div id="mySidebar" class="sidebar">
	<button type="button" title="Close Menu" class="closebtn close" onclick="closeNav()">×</button>
	<br>
	<div class="mymenubar">
		<ul class=" menu-overal list-unstyled">
			<li>
				<a class="collapsed" data-toggle="collapse" href="#student-management">
					<i class="menu-icon fa fa-school"></i>
					<i class="fa fa-chevron-circle-down place-right"></i>
					<i class="fa fa-chevron-circle-up place-right"></i>
					<span>Student Booking</span>
				</a>
				<ul id="student-management" class="collapse list-unstyled">
					<li>
						<a href="student-todays-bookings.php">
							<i class="fa fa-calendar-check"></i>
							Today's Booking
							<?php
							$my_room=1;
							date_default_timezone_set('Africa/Nairobi');
							$starttym="00:00:00";
							$fromtym=date('Y-m-d')." ".$starttym;
							$endtym="23:59:59";
							$totym=date('Y-m-d')." ".$endtym;
							$today_totalstudents= "SELECT * FROM studentroombook where  bookingDate Between ? and ?";
							$stmt=$con->prepare($today_totalstudents);
							$stmt->bind_param('ss',$fromtym,$totym);
							$stmt->execute();
							$stmt->store_result();
							$total_students_today= $stmt->num_rows;
							{ ?>
								<b class="label orange place-right"><?php echo htmlentities($total_students_today); ?></b>
								<?php }	?>
						</a>
					</li>
					<li>
						<a href="student-unpaid-bookings.php">
							<i class="fa fa-money-bill-wave"></i>
							Unpaid Bookings
							<?php
							$paymentstatus="paid";
							$own=1;
							$unpaid_students="SELECT * FROM studentroombook where payment!=? AND roomownership=? ";
							$student__unpaid=$con->prepare($unpaid_students);
							$student__unpaid->bind_param('si',$paymentstatus,$own);
							$student__unpaid->execute();
							$student__unpaid->store_result();
							$total_unpaid= $student__unpaid->num_rows;
							{?>
								<b class="label orange place-right"><?php echo htmlentities($total_unpaid); ?></b>
						    <?php } ?>
						</a>
					</li>
					<li>
						<a href="student-paid-bookings.php">
							<i class="fa fa-user-check"></i>
							Paid Bookings
							<?php
							$student_paymentinfo='paid';
							$i_own=1;
							$all_paid_students= "SELECT * FROM studentroombook where payment=? AND roomownership=?";
							$students_paid=$con->prepare($all_paid_students);
							$students_paid->bind_param('si',$student_paymentinfo,$i_own);
							$students_paid->execute();
							$students_paid->store_result();
							$total_students_who_paid= $students_paid->num_rows;
							{?>
								<b class="label green place-right"><?php echo htmlentities($total_students_who_paid); ?></b>
								<?php } ?>
					    </a>
				    </li>

			    </ul>
		    </li>
		</ul>
		<ul class=" menu-overal list-unstyled">
			<li>
				<a class="collapsed" data-toggle="collapse" href="#studentstatus">
					<i class="menu-icon fa fa-school"></i>
				    <i class="fa fa-chevron-circle-down place-right"></i>
				    <i class="fa fa-chevron-circle-up place-right"></i>
				    Manage Students
				</a>
				<ul id="studentstatus" class="collapse list-unstyled">
					<li>
						<a href="students-details.php">
							<i class="menu-icon fa fa-th-list"></i>
							Student Details
						</a>
					</li>
					<li>
						<a href="active-students.php">
							<i class="menu-icon fa fa-th-list"></i>
							Active Students
						</a>
					</li>

				</ul>
			</li>
		</ul>
		<ul class=" menu-overal list-unstyled">
			<li><a href="create-hostel.php"><i class="menu-icon fa fa-tasks"></i> Create Hostel </a></li>
			<li><a href="create-rooms.php"><i class="menu-icon fa fa-tasks"></i>Create Rooms </a></li>
		</ul>
		<ul class=" menu-overal list-unstyled">
			<li><a href="manage-hostels.php"><i class="menu-icon fa fa-tasks"></i> Manage Hostel </a></li>
		</ul>
		<ul class=" menu-overal list-unstyled">
			<li><a href="log-out.php"><i class="menu-icon fa fa-eject"></i>Log Out</a></li>
    	</ul>
	</div>
</div>