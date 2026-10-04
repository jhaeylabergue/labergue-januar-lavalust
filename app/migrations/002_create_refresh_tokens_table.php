<?php

class Create_refresh_tokens_table {

    private $_lava;

    public function __construct()
    {
        $this->_lava = lava_instance();
        $this->_lava->call->dbforge();
    }

    public function up()
    {
        if ($this->_lava->dbforge->table_exists('refresh_tokens')) {
            return;
        }

        if (!$this->_lava->dbforge->table_exists('users')) {
            throw new RuntimeException('Cannot create refresh_tokens because users.id does not exist.');
        }

        $user_id = $this->_lava->db->raw(
            "SELECT DATA_TYPE, COLUMN_TYPE
             FROM information_schema.columns
             WHERE table_schema = DATABASE()
               AND table_name = 'users'
               AND column_name = 'id'"
        )->fetch(PDO::FETCH_ASSOC);

        if (!$user_id) {
            throw new RuntimeException('Cannot create refresh_tokens because users.id does not exist.');
        }

        $user_id_type = strtoupper($user_id['DATA_TYPE']);
        if (!in_array($user_id_type, ['TINYINT', 'SMALLINT', 'MEDIUMINT', 'INT', 'BIGINT'], TRUE)) {
            throw new RuntimeException('Cannot create refresh_tokens because users.id is not an integer column.');
        }

        $this->_lava->dbforge
            ->add_field([
                'id' => [
                    'type'           => 'INT',
                    'unsigned'       => TRUE,
                    'auto_increment' => TRUE,
                    'null'           => FALSE,
                ],
                'user_id' => [
                    'type'     => $user_id_type,
                    'unsigned' => stripos($user_id['COLUMN_TYPE'], 'unsigned') !== FALSE,
                    'null'     => FALSE,
                ],
                'token' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 64,
                    'null'       => FALSE,
                ],
                'expires_at' => [
                    'type' => 'DATETIME',
                    'null' => FALSE,
                ],
                'created_at' => [
                    'type'    => 'TIMESTAMP',
                    'null'    => FALSE,
                    'default' => 'CURRENT_TIMESTAMP',
                ],
            ])
            ->add_key('id', primary: TRUE)
            ->add_key('user_id', name: 'refresh_tokens_user_id_idx')
            ->add_key('token', unique: TRUE, name: 'refresh_tokens_token_unique')
            ->add_foreign_key('user_id', 'users', 'id', 'CASCADE', 'CASCADE')
            ->create_table('refresh_tokens');
    }

    public function down()
    {
        $this->_lava->dbforge->drop_table('refresh_tokens');
    }
}