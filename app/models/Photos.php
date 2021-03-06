<?php

class Photos extends Database
{

    private $id;
    private $url;
    private $name;
    private $id_album;

    function __construct()
    {
        parent::__construct();
    }

    public function addPhotos()
    {
        $stmt = $this->dbh->prepare("INSERT INTO photos VALUES (null,?,?,?)");

        $stmt->bindParam(1, $this->url);
        $stmt->bindParam(2, $this->name);
        $stmt->bindParam(3, $this->id_album);

        $stmt->execute();

        $this->id = $this->dbh->lastInsertId();
    }

    public function getAllPhotosByAlbum()
    {
        $stmt = $this->dbh->prepare('SELECT * FROM photos where id_album = ?');

        $stmt->bindParam(1, $this->id_album);

        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            return $stmt->fetchAll();
        } else {
            return false;
        }
    }

    public function getAllPhotosByPage($start)
    {
        $stmt = $this->dbh->prepare('SELECT * FROM photos LIMIT 10 OFFSET ?');

        $stmt->bindParam(1, $start, PDO::PARAM_INT);

        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            return $stmt->fetchAll();
        } else {
            return false;
        }
    }

    public function getPhotoById()
    {
        $stmt = $this->dbh->prepare('SELECT * FROM photos where id = ?');

        $stmt->bindParam(1, $this->id);

        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } else {
            return false;
        }
    }

    public function countPhotosByIdAlbum()
    {
        $stmt = $this->dbh->prepare('select count(id) as numberPhotos from photos where id_album = ?');

        $stmt->bindParam(1, $this->id_album);

        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } else {
            return false;
        }
    }

    public function getPreviousPhotoByPage()
    {
        $stmt = $this->dbh->prepare('SELECT id_album,id FROM photos WHERE id_album = ? and id < ? ORDER BY id DESC LIMIT 1;');

        $stmt->bindParam(1, $this->id_album);
        $stmt->bindParam(2, $this->id);

        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } else {
            return false;
        }
    }

    public function getNextPhotoByPage()
    {
        $stmt = $this->dbh->prepare('SELECT id_album,id FROM photos WHERE id_album = ? and id > ? ORDER BY id LIMIT 1;');

        $stmt->bindParam(1, $this->id_album);
        $stmt->bindParam(2, $this->id);

        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } else {
            return false;
        }
    }

    public function getAllPhotosByPageAndIdAlbum($start)
    {
        $startInt = intval($start);

        $stmt = $this->dbh->prepare('SELECT * FROM photos where id_album = ? ORDER BY id ASC LIMIT 10 OFFSET ?');

        $stmt->bindParam(1, $this->id_album);
        $stmt->bindParam(2, $startInt, PDO::PARAM_INT);

        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            return $stmt->fetchAll();
        } else {
            return false;
        }
    }

    public function deletePhotosByIdAlbum()
    {

        $stmt = $this->dbh->prepare('DELETE FROM photos
        WHERE id_album = ?');

        $stmt->bindParam(1, $this->id_album);
        $count = $stmt->execute();

        if ($count > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function deletePhotosById()
    {

        $stmt = $this->dbh->prepare('DELETE FROM photos
        WHERE id = ?');

        $stmt->bindParam(1, $this->id);
        $count = $stmt->execute();

        if ($count > 0) {
            return true;
        } else {
            return false;
        }
    }

    function getId()
    {
        return $this->id;
    }

    function setId($id)
    {
        $this->id = $id;
    }

    function getUrl()
    {
        return $this->url;
    }

    function setUrl($url)
    {
        $this->url = $url;
    }

    function getId_album()
    {
        return $this->id_album;
    }

    function setId_album($id_album)
    {
        $this->id_album = $id_album;
    }

    function getName()
    {
        return $this->name;
    }

    function setName($name)
    {
        $this->name = $name;
    }

}
