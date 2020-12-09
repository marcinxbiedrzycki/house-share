# Docker for Symfony project template

Template for Symfony 4/5 projects with nginx, PHP and MySQL (MariaDB).

### Tech data

Nginx serve project on [port 8000](http://localhost:8000). Also PHPMyAdmin is
 served on [port 8001](http://localhost:8001).

Access to MySQL: `mysql://root:password@database:3306/project` (put it in
 **/.env** file).

Remember to uncomment schema update or migrations in
 **/_misc/docker/php/start.sh**. You can also add own start commands to this
 file.

After each change in **/_misc/docker/** you have to rebuild docker images.
