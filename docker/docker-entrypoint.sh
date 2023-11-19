#!/usr/bin/env sh
echo "Starting websockets servers"
echo "Nothing is started for yet"
echo "Add a websocket server file and modifiy the docker/docker-entrypoint.sh file"
echo "Rebuild your app"

# nohup /usr/bin/php7.4 /var/www/html/src/public/chat-server.php > /dev/stdout &

exec /usr/local/bin/docker-php-entrypoint "$@"
