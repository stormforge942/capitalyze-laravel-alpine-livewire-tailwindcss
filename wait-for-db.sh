#!/bin/bash
# wait-for-db.sh

# PostgreSQL service host name and other connection details
DB_HOST=database
DB_PORT=5432
DB_USER=admin # Use the admin or a user that has access to both databases
DB_PASSWORD=admin # Password for the user

# Database names
DB_NAMES=("users" "xbrl")

# Wait for the PostgreSQL database to be ready
echo "Waiting for PostgreSQL databases to become available..."

for DB_NAME in "${DB_NAMES[@]}"; do
    until PGPASSWORD=$DB_PASSWORD psql -h $DB_HOST -p $DB_PORT -U $DB_USER -d $DB_NAME -c '\q' 2>/dev/null; do
      >&2 echo "Database $DB_NAME is unavailable - sleeping"
      sleep 1
    done
    >&2 echo "Database $DB_NAME is up"
done

>&2 echo "All databases are up - executing command"
exec "$@"