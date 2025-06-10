<?php
namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DatabaseService
{
    protected $tableName;

    public function __construct($tableName)
    {
        if (!Schema::hasTable($tableName)) {
            throw new \Exception("Table '{$tableName}' does not exist.");
            exit;
        }
        $this->tableName = $tableName;
    }

    public function getAll()
    {
        return DB::connection('sqlsrv')->table($this->tableName)->get();
    }
}

