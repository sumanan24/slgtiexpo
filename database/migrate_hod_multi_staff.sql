-- Allow multiple staff accounts per department
USE slgti_impact;

ALTER TABLE `hod_users`
    DROP INDEX `hod_users_department_id_unique`,
    ADD KEY `hod_users_department_id_index` (`department_id`);
