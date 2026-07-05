-- Add staff_name to submissions (manual entry per submission)
USE slgti_impact;

ALTER TABLE `submissions`
    ADD COLUMN `staff_name` VARCHAR(255) NOT NULL DEFAULT '' AFTER `department_id`;

-- Backfill existing rows from department default names
UPDATE submissions s
JOIN departments d ON d.id = s.department_id
SET s.staff_name = d.staff_name
WHERE s.staff_name = '';

ALTER TABLE `submissions` ALTER COLUMN `staff_name` DROP DEFAULT;
