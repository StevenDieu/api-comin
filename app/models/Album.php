<?php

class Album extends Database {

    private $id;
    private $titre;
    private $date;
    private $active;

    function __construct() {
        parent::__construct();
    }

    public function addAlbum() {
        $dateTime = new DateTime($this->date);
        $this->date = $dateTime->format('Y-m-d H:i:s');

        $stmt = $this->dbh->prepare("INSERT INTO album VALUES (null,?,?,?)");

        $stmt->bindParam(1, $this->titre);
        $stmt->bindParam(2, $this->date);
        $stmt->bindParam(3, $this->active);

        $stmt->execute();

        $this->id = $this->dbh->lastInsertId();
    }

    public function updateAlbum() {
        $dateTime = new DateTime($this->date);
        $this->date = $dateTime->format('Y-m-d H:i:s');

        $stmt = $this->dbh->prepare("UPDATE album
        SET titre = ?, date_debut = ?, active = ?
        WHERE id = ?");

        $stmt->bindParam(1, $this->titre);
        $stmt->bindParam(2, $this->date);
        $stmt->bindParam(3, $this->active);
        $stmt->bindParam(4, $this->id);

        $count = $stmt->execute();

        if ($count > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function getAlbumById() {
        $stmt = $this->dbh->prepare('SELECT * FROM album WHERE id = ?');

        $stmt->bindParam(1, $this->id);
        $stmt->execute();

        if ($stmt->rowCount()) {
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } else {
            return false;
        }
    }

    function getAlbumByIdActive() {
        $stmt = $this->dbh->prepare('SELECT * FROM album WHERE id = ? and active = 1');

        $stmt->bindParam(1, $this->id);
        $stmt->execute();

        if ($stmt->rowCount()) {
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } else {
            return false;
        }
    }

    public function getAllAlbum() {
        $stmt = $this->dbh->prepare('SELECT * FROM album');

        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            return $stmt->fetchAll();
        } else {
            return false;
        }
    }

    public function getAllAlbumByPage($start) {
        $stmt = $this->dbh->prepare('SELECT * FROM album order by date_debut desc LIMIT 10 OFFSET ?');

        $stmt->bindParam(1, $start, PDO::PARAM_INT);

        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            return $stmt->fetchAll();
        } else {
            return false;
        }
    }

    public function countAlbum() {
        $stmt = $this->dbh->prepare('select count(id) as numberAlbum from album');

        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            return $stmt->fetch(PDO::FETCH_ASSOC)["numberAlbum"];
        } else {
            return false;
        }
    }

    public function deleteAlbumById() {

        $stmt = $this->dbh->prepare('DELETE FROM album
        WHERE id = ?');

        $stmt->bindParam(1, $this->id);
        $count = $stmt->execute();
        
        if ($count > 0) {
            return true;
        } else {
            return false;
        }
    }

    function getNextId() {
        $stmt = $this->dbh->prepare("SHOW TABLE STATUS FROM com_fges LIKE 'album'");

        $stmt->execute();

        if ($stmt->rowCount()) {
            return $stmt->fetch(PDO::FETCH_ASSOC)["Auto_increment"];
        } else {
            return false;
        }
    }

    function getId() {
        return $this->id;
    }

    function getTitre() {
        return $this->titre;
    }

    function getDate() {
        return $this->date;
    }

    function getActive() {
        return $this->active;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setTitre($titre) {
        $this->titre = $titre;
    }

    function setDate($date) {
        $this->date = $date;
    }

    function setActive($active) {
        $this->active = $active;
    }

}
