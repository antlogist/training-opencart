<?php
class ModelExtensionCustomSubscription extends Model {
	public function install() {
		$this->db->query("
			CREATE TABLE `" . DB_PREFIX . "custom_subscription` (
				`id` INT(11) NOT NULL AUTO_INCREMENT,
				`email` varchar(100) NOT NULL,
                `created__at` timestamp NOT NULL DEFAULT current_timestamp(),
				PRIMARY KEY (`id`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
		");
	}

	public function uninstall() {
		$this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "custom_subscription`");
	}
}
