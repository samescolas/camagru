
# [Camagru](https://camagru.samescolas.me/)

A mini social network centered around taking webcam images with goofy overlay images. Dockerfile builds and compiles a Debian container with a mail server, Apache, and mysql.

## Getting Started

These instructions will get you a copy of the project up and running on your local machine for development and testing purposes: ```

`git clone https://github.com/samescolas/camagru`<br />
`docker build -t camagru camagru`<br />
`docker run -it -p80:80 camagru`

### Prerequisites

Camagru is set up to run inside a [Docker](https://docs.docker.com/engine/installation/) container.

## Built With

* [Docker](https://www.docker.com/) - Dependency Management
* [Debian](https://www.debian.org/) - Host OS
* [Apache2](https://www.apache.org/) - Server
* [MySQL](https://www.mysql.com/) - Database
* [PHP](http://php.net/) - Server side

## Screenshots

<div style="text-align:center">
  <img src="https://raw.githubusercontent.com/samescolas/camagru/master/login.png" width="20%" />
</div>

<br />

<div style="text-align:center;width:100%">
  <img src="https://raw.githubusercontent.com/samescolas/camagru/master/home.png" width="20%" />
</div>
