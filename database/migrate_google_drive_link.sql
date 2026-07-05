-- Add Google Drive link column for submission documents
USE slgti_impact;

ALTER TABLE `submissions`
    ADD COLUMN `google_drive_link` VARCHAR(500) DEFAULT NULL AFTER `supporting_documents`;
