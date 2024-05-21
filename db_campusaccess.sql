START TRANSACTION;
SET time_zone = "+08:00";

CREATE TABLE `campusaccess` (
  `campusaccess_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `timeofaccess` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

INSERT INTO `campusaccess` (`campusaccess_id`, `student_id`, `timeofaccess`) VALUES
(1, 1, '2024-05-18 07:00:00');

CREATE TABLE `student` (
  `student_id` int(11) NOT NULL,
  `student_name` varchar(255) NOT NULL,
  `yearandsection` varchar(255) NOT NULL,
  `qrcode` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

INSERT INTO `student` (`student_id`, `student_name`, `yearandsection`, `qrcode`) VALUES
(1, 'Kathryn B.', '1st - BSCA', 'Zhaydejk72y');

ALTER TABLE `campusaccess`
  ADD PRIMARY KEY (`campusaccess_id`);

ALTER TABLE `student`
  ADD PRIMARY KEY (`student_id`);

ALTER TABLE `campusaccess`
  MODIFY `campusaccess_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

ALTER TABLE `student`
  MODIFY `student_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
COMMIT;
