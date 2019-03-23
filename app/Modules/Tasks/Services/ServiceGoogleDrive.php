<?php
/**
 * Created by PhpStorm.
 * User: matheus
 * Date: 08/01/19
 * Time: 14:43
 */

namespace App\Modules\Tasks\Services;


class ServiceGoogleDrive
{
    protected $client;
    protected $service;

    public function __construct()
    {
        $this->client = new \Google_Client();
        $this->client->setClientId(env('GOOGLE_DRIVE_CLIENT_ID'));
        $this->client->setClientSecret(env('GOOGLE_DRIVE_CLIENT_SECRET'));
        $this->client->refreshToken(env('GOOGLE_DRIVE_REFRESH_TOKEN'));

        $this->service = new \Google_Service_Drive($this->client);
    }

    /**
     * this is the only method u need to call from ur controller.
     *
     * @param [type] $new_name [description]
     *
     * @return [type] [description]
     */
    public function upload_files()
    {
        $adapter    = new GoogleDriveAdapter($this->service, env('GOOGLE_DRIVE_INVOICES_FOLDER_ID'));
        $filesystem = new Filesystem($adapter);

        $files = Storage::files();

        // loop over the found files
        foreach ($files as $file) {
            // remove file from google drive in case we have something under the same name
            // comment out if its okay to have files under the same name
            $this->remove_duplicated($file);

            // read the file content
            $read = Storage::get($file);
            // save to google drive
            $filesystem->write($file, $read);
            // remove the local file
            Storage::delete($file);
        }
    }

    /**
     * in case u want to get the total file count
     * inside a specific folder.
     *
     * @return [type] [description]
     */
    public function files_count()
    {
        $response = $this->service->files->listFiles([
            'q' => "'$this->folder_id' in parents and trashed=false",
        ]);

        return count($response->files);
    }
}