<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class MigrationController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        if (!defined('IS_CLI') || !IS_CLI) {
            http_response_code(403);
            exit('Migration commands are only available from the CLI.');
        }

        $this->call->library('migration');
    }

    public function create_migration($migration_class): void
    {
        if (!preg_match('/^[A-Za-z0-9_-]+$/D', (string) $migration_class)) {
            fwrite(STDERR, "Migration name may only contain letters, numbers, underscores, and hyphens.\n");
            exit(1);
        }

        $this->migration->create_migration($migration_class);
    }

    public function migrate(): void
    {
        $this->migration->migrate();
    }

    public function rollback(): void
    {
        $this->migration->rollback();
    }

    public function rollback_all(): void
    {
        $this->migration->rollback_all();
    }

    public function refresh(): void
    {
        $this->migration->refresh();
    }

    public function status(): void
    {
        $this->migration->status();
    }
}
