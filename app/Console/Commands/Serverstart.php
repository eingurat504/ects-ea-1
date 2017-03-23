<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class Serverstart extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'server:start';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Start server';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //Reduce errors
        error_reporting(~E_WARNING);

//Create a UDP socket
        if(!($sock = socket_create(AF_INET, SOCK_DGRAM, 0)))
        {
            $errorcode = socket_last_error();
            $errormsg = socket_strerror($errorcode);

            die("Couldn't create socket: [$errorcode] $errormsg \n");
        }

//echo "SERVER HAS STARTED AND ITS LISTENING \n";

// Bind the source address
        if( !socket_bind($sock, "0.0.0.0" , 9999) )
        {
            $errorcode = socket_last_error();
            $errormsg = socket_strerror($errorcode);

            die("Could not bind socket : [$errorcode] $errormsg \n");
        }

//echo "Socket bind OK \n";
        echo "SERVER ONLINE ... \n";
//Do some communication, this loop can handle multiple clients
        while(1)
        {
            //Receive some data
            $r = socket_recvfrom($sock, $buf, 512, 0, $remote_ip, $remote_port);
            echo "$remote_ip : $remote_port \n " . $buf;
            //Send back the data to the client
            socket_sendto($sock, "OK " . $buf , 100 , 0 , $remote_ip , $remote_port);


        }

        socket_close($sock);



    }
}
