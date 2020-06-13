# concepts-app
A Site showcasing Nigeria postcode lookup proof of concept

## Development
### Dependencies
Ensure you have the following installed
* [VirtualBox](https://www.virtualbox.org/wiki/Downloads)
* [Vagrant](https://www.vagrantup.com/downloads.html)
* Node.js
    * [Windows](http://blog.teamtreehouse.com/install-node-js-npm-windows)
    * [Linux](http://blog.teamtreehouse.com/install-node-js-npm-linux)
    * [Mac](http://blog.teamtreehouse.com/install-node-js-npm-mac)
* Composer
    * [Windows](https://getcomposer.org/doc/00-intro.md#installation-windows)
    * [Linux](https://getcomposer.org/doc/00-intro.md#installation-linux-unix-osx)
    * [Mac](https://pilsniak.com/install-composer-mac-os/)

### Running Locally
* git clone this repository
* cd into the concepts-app folder
* Create an env file using the env.example template ==> ```cat .env.example > .env``` and update it with the necessary details or contact team lead for content on the file.

### Setup Locally
The project can be setup using a local development server or Laravel Homestead Virtual Machine

#### Local Development server
*   Ensure php >= 7.0 is installed. You can check the php version by running ```php -v```
* Run the command ```apt install php*-cli php*-curl php*-mbstring php*-mcrypt php*-xml php*-zip```. This installs the necessary extensions needed.
* Install composer by running(if it hasn't already been installed ) ```apt install composer``` 
* Next install laravel by running ```composer global require "laravel/installer"```
* Add composer's system wide vendor bin directory to your $PATH. The directory exists at ```$HOME/.composer/vendor/bin```
* Navigate to the project's directory and serve the application using the command ```php artisan serve```
* The command above starts a development server at ```https://localhost:8000```
* ```storage``` and ```bootstrap/cache``` directories should be writable by the web server for Laravel to run. To configure these permissions, run the following commands in the project's directory ```chmod 777 storage``` ```chmod 777 bootstrap/cache```

#### Laravel Homestead Virtual Machine
* Install Homestead - ```composer require laravel/homestead --dev```
* Use `make` command to generate the `Homestead.yaml file` - Run ```php vendor/bin/homestead make``` for Mac  or ```vendor\\bin\\homestead make``` for windows
* Open the `Homestead.yaml` file 
    * On line 14 rename `homestead.test` to `postcodes-ng`
    * Copy the ip-addrress on line 1. Then open your `hosts` file and on a new line paste in the ip-address mapping it to `postcodes-ng`. For example ```192.168.10.13   postcodes-ng```
* Run ```vagrant up```. This creates the VM for the project if run the first time
* Run ```npm install```
* Run ```npm run watch-poll```
* Once it's up, browse to ```http://homestead.test/```