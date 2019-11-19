ALTER TABLE `kl_taxonomy_term_data` CHANGE `name` `name` VARCHAR(255) CHARSET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'The term name.', CHANGE `status` `status` INT(11) DEFAULT 1 NOT NULL COMMENT '1:active,2:deactive'; 

ALTER TABLE `kl_org_opportunity` ADD COLUMN `show_in_banner` TINYINT(2) DEFAULT 0 NULL COMMENT '1:show on banner,0:normal opp' AFTER `department_id`; 


CREATE TABLE `kl_recent_opportunity_views` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `oid` bigint(20) DEFAULT NULL COMMENT 'opportunity ID',
  `user_id` bigint(20) DEFAULT NULL COMMENT 'user ID',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ;


CREATE VIEW kl_vw_txm_opportunity_count AS 
SELECT tid,COUNT(id) AS opp_count FROM kl_org_opportunity_terms_rel GROUP BY tid;

CREATE VIEW kl_vw_user_matched_opp
AS 
SELECT * FROM ( 
SELECT 
IF(a.tid=b.tid, 1,0) AS tidIsMatch,
b.user_id,a.oid,
COUNT(*) AS totalMatchedTids
FROM `kl_org_opportunity_terms_rel` AS a
JOIN `kl_user_interests` AS b
GROUP BY b.user_id,a.oid,tidIsMatch
) AS result WHERE tidIsMatch != 0 
ORDER BY totalMatchedTids DESC;

ALTER TABLE `kl_org_opportunity` ADD COLUMN `apply_before` TIMESTAMP NULL AFTER `end_date`; 