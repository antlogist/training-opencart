<?php

class ModelExtensionModuleCustomSubscription extends Model
{
    /**
     * Add email address to the database
     *
     * @param String $email
     * @return void
     */
    public function add(String $email)
    {
        $this->db->query("
        INSERT INTO `" . DB_PREFIX . "custom_subscription` (email)
            VALUES('" . $this->db->escape($email) . "');
    ");
    }
}
