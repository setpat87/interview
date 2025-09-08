<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


class ImportUsersFromCsv extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'users:import {file}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import users from a csv file';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $filePath = $this->argument('file');

        if(! file_exists($filePath) || ! is_readable($filePath)) {
            $this->error('Csv file is not found or nor readable : ' . $filePath);
            Log::error('Csv file is not found or nor readable : ' . $filePath);

            return Command::FAILURE;
        }

        $header = null;
        $data = [];
        if (($handle = fopen($filePath, 'r')) !== false) {
            while (($row = fgetcsv($handle, 1000, ',')) !== false) {
                if (! $header) {
                    $header = $row;
                    continue;
                }

                $data = array_combine($header, $row);

                $validatedData = Validator::make($data, [
                    'username' => 'required|alpha_num|min:3|max:20|unique:users,username',
                    'email' => 'required|email|unique:users,email',
                    'password' => 'required|min:8',
                ]);

                if ($validatedData->fails()) {
                    $this->warning('Validation failed:'. implode(',', $validatedData->errors()->all()));

                    Log::warning('Validation failed for row:', $data);
                    return false;
                }

                try {
                    User::create([
                        'username' => $data['username'],
                        'email' => $data['email'],
                        'password' => Hash::make($data['password']),
                    ]);
                } catch(\Exception $e) {
                    $this->error('Error while inserting user:' . $e->getMessage());
                    Log::error('Error while inserting user:' . $e->getMessage(), $data);

                    return false;
                }
                
            }

        }
        fclose($handle);

        $this->info('User import completed succussfully!');

        Log::info('User import completed succussfully!',[
            'file' => $filePath,
        ]);

        return Command::SUCCESS;
    }
}
