<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class ConfigManager {

    private $table = "shp_config";
    private $CI;

    public function __construct() {
        $this->CI = & get_instance();
    }

    public function getConfig($key) {
        $query = $this->CI->db->query("SELECT value FROM " . $this->table . " WHERE name = ?;", array($key));
        if ($query->num_rows() > 0)
            return $query->row()->value;
        else {
            // On vérifie si il n'existe pas une valeur par défaut
            if (array_key_exists($key, $this->default_config)) {
                return $this->default_config[$key];
            } else {
                return "";
            }
        }
    }

    public function setConfig($key, $value) {
        $query = $this->CI->db->query("SELECT value FROM " . $this->table . " WHERE name = ?;", array($key));
        // Existe-t-il déjà une entrée pour cette config
        if ($query->num_rows() > 0)
            $this->CI->db->query("UPDATE " . $this->table . " SET value = ? WHERE name = ?;", array($value, $key));
        else
            $this->CI->db->query("INSERT INTO " . $this->table . "(name, value) VALUES(?, ?)", array($key, $value));
    }

    private $default_config = array();

}