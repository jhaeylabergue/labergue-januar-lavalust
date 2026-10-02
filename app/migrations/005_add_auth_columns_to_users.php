<?php

class Add_auth_columns_to_users {

    private $_lava;

    public function __construct()
    {
        $this->_lava = lava_instance();
        $this->_lava->call->dbforge();
    }

    public function up()
    {
        if (!$this->_lava->dbforge->table_exists('users')) {
            throw new RuntimeException('Cannot add authentication columns because the users table does not exist.');
        }

        if (!$this->_lava->dbforge->column_exists('users', 'email')) {
            throw new RuntimeException('Cannot add authentication columns because the users table has no email column.');
        }

        if (!$this->_lava->dbforge->column_exists('users', 'name')) {
            $this->_lava->dbforge->add_column('users', [
                'name' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 100,
                    'null'       => TRUE,
                ],
            ]);
        }

        if (!$this->_lava->dbforge->column_exists('users', 'password')) {
            $this->_lava->dbforge->add_column('users', [
                'password' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 255,
                    'null'       => TRUE,
                ],
            ]);
        } else {
            $this->_lava->dbforge->modify_column('users', [
                'password' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 255,
                    'null'       => TRUE,
                ],
            ]);
        }

        if (
            $this->_lava->dbforge->column_exists('users', 'firstname')
            && $this->_lava->dbforge->column_exists('users', 'lastname')
        ) {
            $this->_lava->db->raw(
                "UPDATE users
                 SET name = LEFT(NULLIF(TRIM(CONCAT_WS(' ', firstname, lastname)), ''), 100)
                 WHERE name IS NULL OR name = ''"
            );
        }

        if ($this->_lava->dbforge->column_exists('users', 'username')) {
            $this->_lava->db->raw(
                "UPDATE users SET name = LEFT(username, 100) WHERE name IS NULL OR name = ''"
            );
        }

        $this->_lava->db->raw(
            "UPDATE users SET name = LEFT(email, 100) WHERE name IS NULL OR name = ''"
        );

        $this->_lava->dbforge->modify_column('users', [
            'name' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => FALSE,
            ],
        ]);

    }

    public function down()
    {
        // Keep account data intact when rolling back application code.
    }
}
