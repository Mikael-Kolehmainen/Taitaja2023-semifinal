<?php

namespace api\model;

class UserModel
{
    private const TABLE_NAME = "users";
    private const FIELD_ID = "id";
    private const FIELD_USERNAME = "name";
    private const FIELD_PW = "password";
    private const FIELD_SESSION = "session";
    private const FIELD_ROLE = "role";

    /** @var Database */
    private $db;

    /** @var int */
    public $id;

    /** @var string */
    public $username;

    /** @var string */
    public $password;

    /** @var string */
    public $session;

    /** @var string */
    public $role;

    public function __construct($database)
    {
        $this->db = $database;
    }

    /** @return $this */
    public function load()
    {
        $records = $this->db->select(
            'SELECT * FROM ' . self::TABLE_NAME . ' WHERE ' . self::FIELD_USERNAME . ' = ?',
            [["s"], [$this->username]]
        );
        $record = array_pop($records);
        return $this->mapFromDbRecord($record);
    }

    public function loadWithSession()
    {
        $records = $this->db->select(
            'SELECT * FROM ' . self::TABLE_NAME . ' WHERE ' . self::FIELD_SESSION . ' = ?',
            [["s"], [$this->session]]
        );
        $record = array_pop($records);
        return $this->mapFromDbRecord($record);
    }

    /**
     * @param mixed[] $record Associative array of one db record
     * @return $this
     */
    public function mapFromDbRecord($record)
    {
        $this->id = $record[self::FIELD_ID];
        $this->username = $record[self::FIELD_USERNAME];
        $this->password = $record[self::FIELD_PW];
        $this->session = $record[self::FIELD_SESSION];
        $this->role = $record[self::FIELD_ROLE];

        return $this;
    }
}