<?php
include_once('./DbConnection.php');

class Contact extends DbConnection
{

    public function __construct()
    {

        parent::__construct();
    }

    public function ContactData($data = array())
    {


        $sql = "SELECT * FROM contacts ";
        if ($data['search'] != '') {
            $filter = $data['search'];
            $sql .= " WHERE first_name LIKE '%$filter%'";
        }

        $sql .= "ORDER BY first_name ";



        $limit = 5;
        if (isset($_GET["page"])) {
            $page  = $_GET["page"];
        } else {
            $page = 1;
        };
        $start_from = ($page - 1) * $limit;

        $sql .= "LIMIT $start_from, $limit ";


        $query = $this->connection->query($sql);

        if ($query->num_rows > 0) {
            $contacts = array();
            while ($row = mysqli_fetch_assoc($query)) {
                $contacts[] = $row;
            }
            return $contacts;
        } else {
            return false;
        }
    }

    public function details($sql)
    {

        $query = $this->connection->query($sql);

        $row = $query->fetch_array();

        return $row;
    }

    public function escape_string($value)
    {

        return $this->connection->real_escape_string($value);
    }


    public function Store($data = array())
    {
        $first_name = $data['contact_data']['first_name'];
        $last_name = $data['contact_data']['last_name'];
        $phone = $data['contact_data']['phone'];
        $city = $data['contact_data']['city'];

        $dateofbirth = $data['contact_data']['dateofbirth'];

        // return $data;


        $sql = "INSERT INTO contacts (first_name, last_name,phone,city,birthdate) VALUES ('$first_name', '$last_name','$phone','$city','$dateofbirth')";



        $result =  $this->connection->query($sql);

        $sql = "SELECT MAX(id) FROM contacts";

        // return true;







        if ($result === TRUE) {
            $maxid = $this->connection->query($sql);
            $maxid = $maxid->fetch_row()[0];
            $department_id = $data['contact_data']['department_id'];
            $sql = "INSERT INTO contacts_department (contact_id, department_id) VALUES ('$maxid','$department_id')";
            $this->connection->query($sql);


            return true;
        }
        return false;
    }


    public function deleteData($id = null)
    {
        $sql = "DELETE FROM contacts WHERE id = $id";

        $delete = $this->connection->query($sql);
        if ($delete === true) {
            return true;
        }
        return false;
    }
}
