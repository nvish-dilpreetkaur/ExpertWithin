ALTER TABLE `kl_notifications` CHANGE `type_of_notification` `type_of_notification` TINYINT(4) DEFAULT 0 NOT NULL COMMENT '1:share_opportunity,2:share_acknowledgement,3: new_ack_added,4: opportunity_complete,5: related_opportunity, 6: opportunity_invites'; 

ALTER TABLE `kl_opportunity_invites` CHANGE `created_at` `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP() NULL; 