<?php
declare(strict_types=1);

namespace Eurosat7\Csvimporter;

use mysqli;

class MySqlConnection
{
    private readonly mysqli $mysqli;

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

    /**
     * @param array<int, array{0:string,1:string,2:int|string|float|null}> $struct
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
}
