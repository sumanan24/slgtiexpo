-- Rename hod_name to staff_name (run once on existing database)
USE slgti_impact;
ALTER TABLE `departments` CHANGE `hod_name` `staff_name` VARCHAR(255) NOT NULL;
