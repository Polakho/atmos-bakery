<?php

namespace App\Models;
use App\Classes\Autoloader;
use App\Classes\Database;
use App\Classes\Schedule;

Autoloader::register();

class ScheduleModel
{
    private $db;

    public function __construct(){

        $this->db = new Database();
    }


    /**
     * Récupère toutes les horraires pour un magasin.
     * @param $id
     * @return array|null
     */
    public function getSchedulesByStoreId($id){

        $pdo = $this->db->getPDO();
        if($id !== null && !empty($id)){

            $sql= ("SELECT * FROM schedule WHERE store_id = $id");
            $stmt = $pdo->query($sql);
            $schedules = [];
            while ($schedule = $stmt->fetchObject("App\Classes\Schedule")) {
                $schedules[] = $schedule;
            }
            return $schedules;
        }
        return null;
    }
}