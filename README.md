# InviMailer - PHP mailing application

## Features

- Create mailing 'events', grouped into 'projects'
- Send mails to specified addresses or whole defined 'group'
- Import mails for 'group' from CSV file
- Possibility for recipients to accept, refuse or unsubscribe from the 'groups' using links appended to mails
- Review responses from recipients for every 'event'

## License

This software is licenced under the [LGPL 3](http://www.gnu.org/licenses/lgpl.html).

## Installation & usage

Requirements:

- Server with PHP 5+ version
- MySQL database

To use this application you need:

- Upload all files (except [LICENSE](LICENSE), [README.md](README.md) and [schema.sql](schema.sql)) on your server.
- Import [schema.sql](schema.sql) file into your database. It inserts also default login credentials (login: `admin`, password MD5 hash: `admin`).
- Edit [_config.php](_config.php) file to properly configure the application.
- You can use the application! Default login credentials: `admin`/`admin`.

## Externals

InviMailer uses the following external components (both LGPL 2.1):

- basic functionality of [PHPMailer](https://github.com/PHPMailer/PHPMailer) (included in codebase)
- [TinyMCE](http://www.tinymce.com/) (linked from CacheFly)

