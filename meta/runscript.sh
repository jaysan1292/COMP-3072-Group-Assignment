#!/bin/bash

# Helper script to easily run all three
# database creation scripts in one go

# Get the directory this script is located in
DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"

if [[ -z $(which mysql) ]]; then
    echo MySQL is not installed, or is not in your PATH.
    exit 1
fi

filename="$DIR/script.sql"

checkfile() {
    if [[ ! -f $1 ]]; then
        echo $1 is missing!
        exit 1
    fi
}

checkfile "$DIR/dbcreate.sql"
checkfile "$DIR/stored_procedures.sql"
checkfile "$DIR/testdata.sql"

cat "$DIR/dbcreate.sql" > "$filename"
cat "$DIR/stored_procedures.sql" >> "$filename"
cat "$DIR/testdata.sql" >> "$filename"

while [[ -z $pass ]]; do
    echo Enter database password for user '"'bohhls'"':
    read -s pass
done

mysql -h home.jaysan1292.com -u bohhls -p$pass < "$filename"

if [[ $? -ne 0 ]]; then
    echo Error executing script!
    exit 1
else
    echo Script executed successfully!
    rm "$filename"
fi
