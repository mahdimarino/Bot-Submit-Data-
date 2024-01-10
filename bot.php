<?php

require 'vendor/autoload.php';

use Box\Spout\Reader\Common\Creator\ReaderEntityFactory;
use Goutte\Client;

// Load Excel file
$reader = ReaderEntityFactory::createXLSXReader();
$reader->open('leads.xlsx');

// Create Goutte client


foreach ($reader->getSheetIterator() as $sheet) {
    foreach ($sheet->getRowIterator() as $row) {
        $data = $row->toArray(); // Use toArray() to get row data as an array
        $email = $data[0]; // Assuming email is in the first column
        $name = $data[1];  // Assuming name is in the second column
        $company = $data[2];  // Assuming company is in the third column
        $state = $data[3];  // Assuming state is in the fourth column

        // Create a new Goutte client
        $client = new Client();

        // Visit the website
        $crawler = $client->request('GET', 'https://mahdismahi.com/webs/robot/testbot.php');

        // Fill out the form (adjust field names accordingly)
        $form = $crawler->selectButton('Submit')->form();

        // Set form values using setValues
        $form->setValues([
            'email' => $email,
            'name' => $name,
            'company' => $company,
            'state' => $state,
        ]);

        // Submit the form
        $client->submit($form);

        echo "Form submitted for $name ($email)\n";
    }
}

$reader->close();

?>
