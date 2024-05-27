
/*Database Name : stagehostel*/
/*Table Admin*/
CREATE DATABASE stagehostel;

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `creationDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updationDate` timestamp NULL
);

INSERT INTO `admin` (`id`, `username`, `password`, `creationDate`, `updationDate`) VALUES
(1,'Kenoly', '12345678', '2021-01-24 14:17:37', NULL),
(2,'Kovi', '12345678', '2021-01-24 14:17:37', NULL);


ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `admin`
 MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

 /*Table Hostel*/


 CREATE TABLE`hostel`(
  `id` int(11) NOT NULL,
  `hostelName` varchar(255) NOT NULL,
  `hostelLocation` varchar(255)  NULL,
  `roomdescription` varchar(255)  NULL,
  `hostelCaretaker` varchar(255) NOT NULL,
  `careTakerContact` bigint(11)  NOT NULL,
  `creationDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updationDate` timestamp NULL,
  `hostelStatus` int(2)  NOT NULL

);


INSERT INTO `hostel`(`id`,`hostelName`, `hostelLocation`, `roomdescription`,`hostelCaretaker`, `careTakerContact`, `creationDate`, `updationDate`,`hostelStatus`) VALUES
(1,'Songwo Hostels', 'Behind Amatak Enterprises','Tiles and Water Available','Kenoly Wafula' ,0740438725,'2021-01-24 19:17:37',NULL,1),
(2,'Nature Springs Hostels', 'Near College','Tiles and Water Available','Peter Kovi' ,0729788547,'2021-01-24 19:17:37',NULL,1),
(3,'Mount Kenya Hostels', 'Near College','Tiles and Water Available','King Kovi' ,0739788547,'2021-01-24 19:17:37',NULL,0);


ALTER TABLE `hostel`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `hostel`
   MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;



CREATE TABLE `room`(
  `id` int(11) NOT NULL,
  `hostelid` int(11) DEFAULT NULL,
  `roomname`varchar(255) NOT NULL,
  `roomprice` int(11) DEFAULT NULL,
  `roomImage1` varchar(255) DEFAULT NULL,
  `creationDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updationDate` timestamp NULL,
  `roomavailability`varchar(255) NOT NULL, 
  `roomstatus` int(2)  NOT NULL
   
);

INSERT INTO `room`(`id`, `hostelid`, `roomname`,`roomprice`,`roomImage1`,`creationDate`, `updationDate`,`roomavailability`,`roomstatus`) VALUES
(1,1, 'Room 1',5000,'sonRoom1pic1.jpg','2021-01-24 19:17:37',NULL,'notavailable',1),
(2,1, 'Room 2',5000,'sonRoom2pic1.jpg','2021-01-24 19:17:37',NULL,'available',1),
(3,1, 'Room 3',5000,'sonRoom3pic1.jpg','2021-01-24 19:17:37',NULL,'available',1),
(4,1, 'Room 4',5000,'sonRoom4pic1.jpg','2021-01-24 19:17:37',NULL,'available',1),
(5,1, 'Room 5',5000,'sonRoom5pic1.jpg','2021-01-24 19:17:37',NULL,'notavailable',1),
(6,2,'Room B1',5000,'natRoomB1pic1.jpg','2021-01-24 19:17:37',NULL,'available',1),
(7,2,'Room 1',5000,'natRoom1pic1.jpg','2021-01-24 19:17:37',NULL,'available',1),
(8,2,'Room 2',5000,'natRoom2pic1.jpg','2021-01-24 19:17:37',NULL,'notavailable',1),
(9,2,'Room 3',5000,'natRoom3pic1.jpg','2021-01-24 19:17:37',NULL,'available',0),
(10,2,'Room 5',5000,'natRoom5pic1.jpg','2021-01-24 19:17:37',NULL,'available',1);


ALTER TABLE `room`
  ADD PRIMARY KEY (`id`),
  ADD CONSTRAINT `Room-Hostel` FOREIGN KEY (`hostelid`) REFERENCES `hostel`(`id`);
  

ALTER TABLE `room`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

  
CREATE TABLE `students` (
  `regNo` varchar(255) NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `yearofstudy` int(5) NOT NULL,
  `semester` int(5) NOT NULL,
  `email` varchar(255) NOT NULL,
  `contactno` bigint(11) NOT NULL,
  `password` varchar(255)NOT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `registrationDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updationDate` timestamp NULL
);

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`regNo`, `fullname`,`yearofstudy`,`semester`,`email`, `contactno`, `password`, `photo`,`registrationDate`, `updationDate`) VALUES
('COM/32/18','Kenoly Wafula',3,2,'wafulakenoly@gmail.com',0740438725,'251514511kenoly$','kenoly.jpg','2021-01-24 19:17:37',NULL),
('COM/15/18','Peter Kovi',3,2,'peterkovi@gmail.com',0729788547,'12345@kovi','kovi.jpg','2021-01-24 19:17:37',NULL ),
('TEC/34/18','Lucille Adhiambo',3,2,'lucille@gmail.com',0711212112,'12345@lucille','lucille.jpg','2021-01-24 19:17:37',NULL );

ALTER TABLE `students`
  ADD PRIMARY KEY (`regNo`);


CREATE TABLE`studentroombook`(
  `id` int(11) NOT NULL,
  `registrationNo` varchar(255) NOT NULL,
  `bookedroomid` int(11) NOT NULL,
  `bookingDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `payment` varchar(55) DEFAULT NULL,
  `moveStatus` varchar(255) NOT NULL,
  `amount` int(11) NOT NULL,
  `paymentdate` timestamp NULL,
  `roomownership` int(11) NOT NULL,
  `isExpired` int(11) NOT NULL,
  `StartingTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ExpiryTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `CompletionStatus` int(11) NOT NULL
   
);

INSERT INTO `studentroombook`(`id`,`registrationNo`,`bookedroomid`,`bookingDate`, `payment` ,`moveStatus`,`amount`,`paymentdate`,`roomownership`,`isExpired`,`StartingTime`,`ExpiryTime`,`CompletionStatus`) VALUES
(1, 'COM/32/18',1,'2021-01-24 19:17:37','paid' ,'occupied',5000,'2021-03-01 19:17:37',1,1,'2021-01-24 19:17:37','2021-04-21 19:17:37',1),
(2, 'COM/15/18',8,'2021-01-24 19:17:37','paid','notoccupied',7000,'2021-03-01 19:30:37',1,0,'2021-01-24 19:17:37','2021-04-21 19:17:37',0),
(3, 'TEC/34/18',5,'2021-01-24 19:17:37','unpaid','notoccupied',13000,NULL,1,0,'2021-01-24 19:17:37','2021-04-21 19:17:37',0);


ALTER TABLE `studentroombook`
  ADD PRIMARY KEY (`id`),
  ADD CONSTRAINT `studentroombook-student` FOREIGN KEY (`registrationNo`) REFERENCES `students`(`regNo`),
  ADD CONSTRAINT `studentroombook-room`  FOREIGN KEY (`bookedroomid`) REFERENCES `room`(`id`);

ALTER TABLE `studentroombook`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;


CREATE TABLE`studentnotifications`(
  `id` int(11) NOT NULL,
  `studregNo` varchar(255) NOT NULL,
  `sentmessage`varchar(255) NOT NULL,
  `readstatus`int(11) NOT NULL,
  `notificationDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `studentoverview`int(11) NOT NULL
   
);

INSERT INTO `studentnotifications`(`id`,`studregNo`,`sentmessage`,`readstatus`,`notificationDate`,`studentoverview`) VALUES
(1, 'COM/32/18','Thank You For Using Our System. You Have Succesfully Booked, Paid and Occupied Your Room',0,'2021-03-01 19:17:37',0),
(2, 'COM/15/18','Thank You For Using Our System. You Have Succesfully Booked, Paid But Not Occupied Your Room',0,'2021-03-01 19:30:37',0),
(3, 'TEC/34/18','Your Payment Is Pending',0,'2021-03-09 14:17:37',1);


ALTER TABLE `studentnotifications`
  ADD PRIMARY KEY (`id`),
  ADD CONSTRAINT `studentnotifications-student` FOREIGN KEY (`studregNo`) REFERENCES `students`(`regNo`);

  ALTER TABLE `studentnotifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;


CREATE TABLE`AdminNotifications`(
  `id` int(11) NOT NULL,
  `adminid` int(11) NOT NULL,
  `receiverstudregNo` varchar(255) NOT NULL,
  `adminmessage`varchar(255) NOT NULL,
  `adminreadstatus`int(11) NOT NULL,
  `adminnotificationDate` timestamp NULL,
  `admnoverview`int(11) NOT NULL
   
);

INSERT INTO `AdminNotifications`(`id`,`adminid`,`receiverstudregNo`,`adminmessage`,`adminreadstatus`,`adminnotificationDate`,`admnoverview`) VALUES
(1,1,'COM/32/18','Payment Reminder Sent To Kenoly Wafula',0,'2021-03-01 19:17:37',0),
(2,1,'COM/15/18','Payment Reminder Sent To Peter Kovi',0,'2021-03-01 19:30:37',0),
(3,1,'TEC/34/18','Payment Reminder Sent To Lucille Adhiambo',0,'2021-03-09 14:17:37',0),
(4,2,'COM/32/18','Payment Reminder Sent To Kenoly Wafula',0,'2021-03-01 19:17:37',0),
(5,2,'COM/15/18','Payment Reminder Sent To Peter Kovi',0,'2021-03-01 19:30:37',0),
(6,2,'TEC/34/18','Payment Reminder Sent To Lucille Adhiambo',0,'2021-03-09 14:17:37',0);


ALTER TABLE `AdminNotifications`
  ADD PRIMARY KEY (`id`),
  ADD CONSTRAINT `AdminNotifications-student` FOREIGN KEY (`receiverstudregNo`) REFERENCES `students`(`regNo`),
  ADD CONSTRAINT `AdminNotifications-Admin` FOREIGN KEY (`adminid`) REFERENCES `admin`(`id`);

ALTER TABLE `AdminNotifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;