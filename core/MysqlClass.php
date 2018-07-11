<?php

class MysqlClass
{
    private $city_id = 0;

    /*подключение к бд*/
    private $db_user ="";
    private $db_password = "";
    private $db_host = "";
    private $db_name = "";

    private function connectionMysql()
    {
        $db = new PDO('mysql:host='.$this->db_host.'; dbname='.$this->db_name, $this->db_user, $this->db_password);
        return $db;
    }

    private function prepareMysql($data)
    {
        $stmt = $this->connectionMysql() -> prepare ($data);
        return $stmt;
    }

    public function insertIntoTable($name,$age,$city_id = 0)
    {
        /*$this->createTable();*/
        $stmt = $this->prepareMysql("INSERT INTO users ( name, age, city_id) VALUES (?, ?, ?)");
        $stmt -> bindParam(1 , $name, PDO::PARAM_STR);
        $stmt -> bindParam(2, $age, PDO::PARAM_INT);
        $stmt -> bindParam(3, $city_id, PDO::PARAM_INT);
        $stmt -> execute();
    }

    /*извлечение данных*/
    private function executeData($request){
        $stmt = $this->prepareMysql($request);
        $stmt -> execute();
        $result = $stmt->fetchAll();
        return $result;
    }

    private function htmlResultUsers($id,$name,$age)
    {
        echo "<div id='$id' class='table-row'>
                <div class='table-cell'>$id</div>
                <div id='name' class='table-cell'>$name</div>
                <div id='age' class='table-cell'>$age</div>
                <div id='city' class='table-cell' data-city='$this->city_id'>";
        $this->getCity();
        echo "</div></div>";
    }

    private function htmlResultCities($id,$city)
    {
        echo "<div id='$id' class='table-row'>
                <div class='table-cell'>$id</div>
                <div id='name' class='table-cell'>$city</div>
                </div>";
    }

    private function getCity()
    {
        $result = $this->executeData("SELECT * FROM cities WHERE id = $this->city_id");
        $this->htmlCity($result[0]["city"]);
    }

    private function htmlCity($city)
    {
        if(!$city)
        {
            echo "Город не выбран";
        }
        else{
            echo $city;
        }
    }

    private function htmlSelectCity($id,$city,$city_id)
    {
        if ($city_id == $id)
        {
            echo "
            <option selected value='$id'>$city</option>
            ";
        }
        else
        {
            echo "
            <option value='$id'>$city</option>
            ";
        }
    }

    private function updateTable($string, $id, $value)
    {
        $stmt = $this->prepareMysql($string);
        $stmt -> bindParam(1, $value);
        $stmt -> bindParam(2, $id);
        $stmt -> execute();
    }

    public function changeData($divname, $id, $value)
    {
        if ($divname == 'name')
        {
            $this->updateTable("UPDATE users SET name = ? WHERE id = ? ", $id, $value);
        }
        if ($divname == 'age')
        {
            $this->updateTable("UPDATE users SET age = ? WHERE id = ? ", $id, $value);
        }
        if ($divname == 'city')
        {
            $this->updateTable("UPDATE users SET city_id = ? WHERE id = ? ", $id, $value);
        }
        if ($divname == 'new_city')
        {
            $this->updateTable("UPDATE cities SET city = ? WHERE id = ? ", $id, $value);
        }
    }

    public function resultUsersTable()
    {
        $result = $this->executeData("SELECT * FROM users");
        for ($i=0; $i<count($result); $i++)
        {
            $this->city_id = $result["$i"]["city_id"];
            $this->htmlResultUsers($result["$i"]["id"],$result["$i"]["name"],$result["$i"]["age"]);
        }
    }

    public function getSelectCities()
    {
        $city = $_POST["cityId"];
        $result = $this->executeData("SELECT * FROM cities");
        for ($i=0; $i<count($result); $i++)
        {
            $this->htmlSelectCity($result["$i"]["id"],$result["$i"]["city"],$city);
        }
    }

    public function resultCitiesTable()
    {
        $result = $this->executeData("SELECT * FROM cities");
        for ($i=0; $i<count($result); $i++)
        {
            $this->htmlResultCities($result["$i"]["id"],$result["$i"]["city"]);
        }
    }

    public function ifCityExist($city)
    {
        $stmt = $this->prepareMysql("SELECT id FROM cities WHERE city = ?");
        $stmt->bindParam(1, $city, PDO::PARAM_STR);
        $stmt->execute();
        $res = $stmt -> fetchAll();
        return $res;
    }

    public function insertIntoTableCity($city)
    {
        if (!$this -> ifCityExist($city))
        {
            $stmt = $this->prepareMysql("INSERT INTO cities ( city ) VALUES (?)");
            $stmt->bindParam(1, $city, PDO::PARAM_STR);
            $stmt->execute();
        }
    }
}