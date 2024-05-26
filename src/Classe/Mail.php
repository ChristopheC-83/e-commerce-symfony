<?php

namespace App\Classe;

use Mailjet\Client; // Import the Mailjet\Client class
use Mailjet\Resources; // Import the Mailjet\Resources class

class Mail
{
    public function send(
        $to_email,
        $to_name,
        $subject,
        $template,
        // on peut passer des variables à notre template ou pas ! , d'où le null
        $vars = null   
    ) {
        // recup template
        // __dir__ donne le chemin jusqu'au fichier qui appelle __dir__
        // avec dirname on remonte d'un niveau dans l'arborescence.
        $content = file_get_contents(dirname(__DIR__) . '/Mail/' . $template);


        // recup variables facultatives
        if($vars != null) {
            foreach($vars as $key => $var) {
                $content = str_replace('{'. $key .'}', $var, $content);
            }
        }


        $mj = new Client($_ENV['MJ_APIKEY_PUBLIC'], $_ENV['MJ_APIKEY_PRIVATE'], true, ['version' => 'v3.1']);

        $body = [
            'Messages' => [
                [
                    'From' => [
                        'Email' => "kiketdule@gmail.com",
                        'Name' => "e-commerce from kiki"
                    ],
                    'To' => [
                        [
                            'Email' => $to_email,
                            'Name' => $to_name
                        ]
                    ],

                    'TemplateID' => 5997711,
                    'TemplateLanguage' => true,
                    'Subject' => $subject,
                    'Variables' => [
                        'content' => $content
                    ]
                ]
            ]
        ];

        $mj->post(Resources::$Email, ['body' => $body]);
    }
}