<?php

namespace App\Models;
use App\Classes\Autoloader;
use App\Classes\Database;
use App\Classes\Schedule;
use DateTime;
use PDOException;

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

    /**
     * Vérifie si des horraires on été renseigné pour un magasin
     * @param $id
     */
    public function isRenseigner($id){

        if($id !== null && !empty($id)){
            $schedules = $this->getSchedulesByStoreId($id);

            if (!empty($schedules)){
                return true;
            }else{
                return false;
            }
        }
        return null;
    }

    public function updateSchedules($semaine, $storeId){
        foreach ($semaine as $dayNumber => $jour){
            $opAm = DateTime::createFromFormat('H\h i\m s\s', str_replace(":", "h ",$jour["opAm"]."m 00s"));
            $clAm = DateTime::createFromFormat('H\h i\m s\s', str_replace(":", "h ",$jour["clAm"]."m 00s"));
            $opPm = DateTime::createFromFormat('H\h i\m s\s', str_replace(":", "h ",$jour["opPm"]."m 00s"));
            $clPm = DateTime::createFromFormat('H\h i\m s\s', str_replace(":", "h ",$jour["clPm"]."m 00s"));
            $horraires = [
                "opAm" => $opAm,
                "clAm" =>$clAm,
                "opPm" =>$opPm,
                "clPm" =>$clPm
            ];

            $this->updateOneSchedule($dayNumber, $horraires, $storeId);
        }
    }

    public function updateOneSchedule($dayNumber ,$horraires, $storeId){
        foreach ($horraires as $key => $horraire){
            if ($horraire == false){
                $horraires[$key] = null;
            }else{
                $horraires[$key] = $horraire->format('Y-m-d H:i:s');
            }
        }
        try {
            $pdo = $this->db->getPDO();
            //prepare
            $sql = "UPDATE schedule SET  schedule.op_am = :opAm, schedule.cl_am = :clAm, schedule.op_pm = :opPm, schedule.cl_pm = :clPm WHERE schedule.day = :dayNumber AND schedule.store_id = :storeId";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                "dayNumber" => $dayNumber,
                "opAm" => $horraires["opAm"],
                "clAm" => $horraires["clAm"],
                "opPm" => $horraires["opPm"],
                "clPm" => $horraires["clPm"],
                "storeId" => $storeId
            ]);
        } catch (PDOException $e) {
            echo json_encode($e);
        }
    }

    public function createScheduleForStore($id)
    {
        if ($id){
            $pdo = $this->db->getPDO();
            for ($day = 1; $day<8; $day++){

                $sql = "INSERT INTO schedule(day, op_am, cl_am, op_pm, cl_pm, trash, store_id) VALUES ($day, null, null, null, null, 0, $id)";
                $stmt = $pdo->prepare($sql);
                $stmt->execute();
            }
        }
    }

    public function deleteScheduleForStore(string $id)
    {
        if ($id){
            $pdo = $this->db->getPDO();
            for ($day = 1; $day<8; $day++){
                $sql = "DELETE FROM schedule WHERE store_id = $id";
                $stmt = $pdo->prepare($sql);
                $stmt->execute();
            }
        }
    }
}