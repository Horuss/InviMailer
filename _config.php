<?php
/**
 * InviMailer - PHP mailing application.
 * @copyright 2014 Jakub 'Horuss' Czajkowski
 * @license http://www.gnu.org/licenses/lgpl.txt GNU Lesser General Public License
 */
$config = array(
    /*
     * Database location/credentials
     */
    "db" => array(
        "dbname" => "jczajkow",
        "username" => "jczajkow",
        "password" => "Rp69s3Wz",
        "host" => "mysql.agh.edu.pl:3306"
    ),
    /*
     * TinyMCE lib localization (default: external CacheFly)
     */
    "paths" => array(
        "tinyMCE" => "http://tinymce.cachefly.net/4.1/tinymce.min.js"
    ),
    /*
     * Email settings. If your server has his own SMTP functionality, then 'isSMTP'
     * should be false and then all other SMTP settings can be ignored.
     */
    "mailing" => array(
        "sender" => "mailbot@student.agh.edu.pl",
        "smtp" => array(
            "isSMTP" => false,
            "Host" => 'smtp1.example.com;smtp2.example.com',
            "SMTPAuth" => true,
            "Username" => 'user@example.com',
            "Password" => 'secret',
            "SMTPSecure" => 'tls',
            "Port" => 587
        )
    )

);
