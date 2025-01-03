<?php

namespace App\Trait;

use Maatwebsite\Excel\Facades\Excel;

trait BulkRegistration
{
    public function registerUsersFromExcel($file, $eventId)
    {
        Excel::import(new UsersImport($eventId), $file);

        return response()->json(['message' => 'Users registered successfully']);
    }
}
