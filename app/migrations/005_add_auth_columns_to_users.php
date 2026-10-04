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
            $this->_lava->dbforge->add_column('users', [
                'email' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 255,
                    'null'       => TRUE,
                ],
            ]);
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
        }
    }

    public function down()
    {
        // Keep account data intact when rolling back application code.
    }
}
