<?php
declare(strict_types=1);

namespace Eurosat7\Csvimporter;

use mysqli;

class MySqlConnection
{
    private readonly mysqli $mysqli;
    private bool $has_transaction = false;

    public function __construct(
        private readonly string $host,
        private readonly string $user,
        private readonly string $password,
        private readonly string $database,
    )
    {
        $this->mysqli = new mysqli(
            $this->host,
            $this->user,
            $this->password,
            $this->database,
        );
    }

    public function __destruct()
    {
        if ($this->has_transaction) {
            echo "error: transation was not commited!";
        }
    }

    /**
     * @param array<int, array{0:string,1:string,2:int|string|float|bool|null}> $struct
     */
    public function insertIgnore(string $table, array $struct): bool
    {
        $sql = "INSERT IGNORE INTO `$table` SET ";
        $types = "";
        $values = [];
        foreach ($struct as [$type, $field, $value]) {
            $sql .= "$field = ? ,";
            $types .= $type;
            $values[] = $value;
        }
        $sql = rtrim($sql, ",");
        $stmt = $this->mysqli->prepare($sql);
        if ($stmt === false) {
            return false;
        }
        $stmt->bind_param($types, ...$values);

        return $stmt->execute();
    }

    public function transaction_begin(): void
    {
        if ($this->has_transaction) {
            echo "warning: transation already running.";
        }
        $this->mysqli->autocommit(false);
        $this->mysqli->begin_transaction();
        $this->has_transaction = true;
    }

    public function transaction_commit(): void
    {
        if (!$this->has_transaction) {
            echo "warning: no transation running. nothing to commit.";
        }
        $this->mysqli->commit();
        $this->mysqli->autocommit(true);
        $this->has_transaction = false;
    }

}
