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
  
// by John Schimmel 
// modified from the code at http://www.zend.com/pecl/tutorials/sockets.php
// 
// run this from terminal on mac os x or another command line interface.

// Set time limit to indefinite execution 
set_time_limit (0); 

// Set the ip and port we will listen on 
$address = '54.75.227.164'; 
$port = 9999; 

// Create a TCP Stream socket 
$sock = socket_create(AF_INET, SOCK_STREAM, 0); 
echo "PHP Socket Server started at " . $address . " " . $port . "\n";

// Bind the socket to an address/port 
socket_bind($sock, $address, $port) or die('Could not bind to address'); 
// Start listening for connections 
socket_listen($sock); 

//loop and listen

while (true) {
    /* Accept incoming requests and handle them as child processes */ 
    $client = socket_accept($sock); 
    
    // Read the input from the client – 1024 bytes 
    $input = socket_read($client, 1024); 
    
    // Strip all white spaces from input 
    $output = ereg_replace("[ \t\n\r]","",$input)."\0"; 
    
    // Display output back to client 
    socket_write($client, "you wrote " . $input . "\n"); 
    
    // display input on server side
    echo "received: " . $input . "\n";
}

// Close the client (child) socket 
socket_close($client); 

// Close the master sockets 
socket_close($sock); 

    }
}
