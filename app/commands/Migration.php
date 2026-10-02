<?php
/**
 * Command: Migration
 *
 * Auto-discovered by the LavaLust CLI.
 * No registration needed — just drop this file in app/commands/.
 */
class Migration
{
    /**
     * The CLI command name.
     * Usage: php lava migration
     */
    public static $command = 'migration';

    /** Short description shown in php lava help */
    public static $description = 'Run database migrations';

    /**
     * Argument/flag descriptions shown in help.
     *
     * Example:
     *   public static $arguments = [
     *       'name'        => 'A positional argument',
     *       '[--flag=<v>]' => 'An optional flag',
     *   ];
     */
    public static $arguments = [
        'action' => 'run, create-migration, rollback, rollback-all, refresh, or status',
        '[--name=<name>]' => 'Name used with create-migration',
    ];

    /**
     * Command entry point.
     *
     * @param string|null $input   First positional argument (php lava migration <input>)
     * @param array       $flags   Associative array of --flag=value pairs
     */
    public function handle($input = null, array $flags = [])
    {
        $routes = [
            'run' => 'migrate',
            'rollback' => 'rollback',
            'rollback-all' => 'rollback-all',
            'refresh' => 'refresh',
            'status' => 'status',
        ];

        if ($input === 'create-migration') {
            $name = $flags['name'] ?? null;
            if (!is_string($name) || !preg_match('/^[A-Za-z0-9_-]+$/D', $name)) {
                fwrite(STDERR, "A valid migration name is required. Example: php lava migration create-migration --name=create_orders_table\n");
                exit(1);
            }
            $route = 'create-migration/' . $name;
        } elseif (is_string($input) && isset($routes[$input])) {
            $route = $routes[$input];
        } else {
            fwrite(STDERR, "Unknown migration action. Use: run, create-migration, rollback, rollback-all, refresh, or status.\n");
            exit(1);
        }

        $script = PUBLIC_DIR . 'index.php';
        $command = escapeshellarg(PHP_BINARY) . ' '
            . escapeshellarg($script) . ' '
            . escapeshellarg('/' . $route);

        passthru($command, $exitCode);
        if ($exitCode !== 0) {
            exit($exitCode);
        }
    }
}