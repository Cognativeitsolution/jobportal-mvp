ALTER TABLE `joborbit`.`job_applies` 
ADD COLUMN `full_name` varchar(255) NULL AFTER `user_id`,
ADD COLUMN `email` varchar(255) NULL AFTER `full_name`,
ADD COLUMN `phone` varchar(255) NULL AFTER `email`,
ADD COLUMN `resume` varchar(255) NULL AFTER `phone`
