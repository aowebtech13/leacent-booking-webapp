<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SqlImportSeeder extends Seeder
{
    public function run(): void
    {
        $sqlPath = base_path('database/database.sql');
        if (!file_exists($sqlPath)) {
            $this->command->error("SQL file not found at $sqlPath");
            return;
        }

        $content = file_get_contents($sqlPath);
        
        // MySQL foreign key check off
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        $this->importTable($content, 'users', [
            'id', 'name', 'email', 'email_verified_at', 'password', 'otp_code', 
            'otp_expires_at', 'otp_attempts', 'otp_verified_at', 'remember_token', 
            'created_at', 'updated_at'
        ]);

        $this->importTable($content, 'profiles', [
            'id', 'user_id', 'email', 'full_name', 'avatar_url', 'phone', 
            'company_name', 'phone_number', 'address', 'city', 'state', 
            'country', 'created_at', 'updated_at'
        ]);

        $this->importTable($content, 'user_roles', [
            'id', 'user_id', 'role', 'created_at', 'updated_at'
        ]);

        $this->importTable($content, 'subscriptions', [
            'id', 'user_id', 'plan', 'status', 'billing_cycle', 
            'flutterwave_transaction_id', 'flutterwave_tx_ref', 'amount', 
            'currency', 'start_date', 'end_date', 'auto_renew', 
            'cancelled_at', 'created_at', 'updated_at'
        ]);
        
        // Additional tables found in database.sql
        $this->importTable($content, 'case_reminders', [
            'id', 'user_id', 'case_id', 'case_name', 'recipient_email', 'subject', 'body', 
            'payload', 'type', 'status', 'scheduled_for', 'processing_started_at', 
            'sent_at', 'last_error', 'created_at', 'updated_at'
        ]);

        // MySQL foreign key check on
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }

    private function importTable($content, $tableName, $columns)
    {
        $colList = implode('`, `', $columns);
        $pattern = '/INSERT INTO `' . $tableName . '` \(`' . $colList . '`\) VALUES\s*(.*?);/s';
        
        if (preg_match_all($pattern, $content, $matches)) {
            $count = 0;
            foreach ($matches[1] as $valuesSql) {
                $records = preg_split('/\),\s*\(/', trim($valuesSql, "() \n\r\t"));
                
                foreach ($records as $record) {
                    $valPattern = "/'[^'\\\\]*(?:\\\\.[^'\\\\]*)*'|NULL|\d+(?:\.\d+)?/";
                    preg_match_all($valPattern, $record, $valMatches);
                    $vals = $valMatches[0];
                    
                    if (count($vals) >= count($columns)) {
                        $data = [];
                        foreach ($columns as $index => $col) {
                            $val = $vals[$index];
                            if ($val === 'NULL') {
                                $data[$col] = null;
                            } elseif (str_starts_with($val, "'") && str_ends_with($val, "'")) {
                                $data[$col] = str_replace(["\\'", "\\\\"], ["'", "\\"], substr($val, 1, -1));
                            } else {
                                $data[$col] = $val;
                            }
                        }
                        
                        DB::table($tableName)->updateOrInsert(['id' => $data['id']], $data);
                        $count++;
                    }
                }
            }
            $this->command->info("Imported $count records into $tableName.");
        } else {
            $this->command->error("Could not find INSERT statement for $tableName.");
        }
    }
}
