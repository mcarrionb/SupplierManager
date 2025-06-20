#!/bin/bash
set -e

# Parse host, user, and password from DATABASE_URL if available
if [[ -n "$DATABASE_URL" ]]; then
  export DATABASE_HOST=$(echo $DATABASE_URL | sed -E 's|.*://([^:]+):([^@]+)@([^:/]+):([0-9]+)/.*|\3|')
  export DATABASE_USER=$(echo $DATABASE_URL | sed -E 's|.*://([^:]+):([^@]+)@([^:/]+):([0-9]+)/.*|\1|')
  export DATABASE_PASSWORD=$(echo $DATABASE_URL | sed -E 's|.*://([^:]+):([^@]+)@([^:/]+):([0-9]+)/.*|\2|')
fi

# Wait for MySQL to be ready (max 60s)
COUNTER=0
until mysql -h "$DATABASE_HOST" -u "$DATABASE_USER" -p"$DATABASE_PASSWORD" -e 'select 1' &> /dev/null; do
  let COUNTER=COUNTER+1
  if [ $COUNTER -ge 30 ]; then
    echo "[ERROR] MySQL is not available after 60 seconds."
    echo "Tried: mysql -h $DATABASE_HOST -u $DATABASE_USER -p*****"
    exit 1
  fi
  echo "Waiting for MySQL... ($COUNTER)"
  sleep 2
  done

echo "MySQL is up. Running migrations..."
php bin/console doctrine:migrations:migrate --no-interaction

echo "Clearing cache..."
php bin/console cache:clear

echo "Creating sample suppliers..."
php bin/console app:create-suppliers

echo "Starting Apache..."
exec apache2-foreground 