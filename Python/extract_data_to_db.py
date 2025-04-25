"""
This script functionality

1. Make sure db and table exists

    input =>  Data_interview - main folder name

      steps :    loop through 3 folders and read DM_values.txt in all folders and get 
                    
                        1. folderName
                        2. date
                        3. fileName - DM_values.txt same for all
                        4. colA 
                        5. colB

                        connect to database
                        insert into table 

"""

import mysql.connector
from mysql.connector import errorcode
import os


# making sure  db and table exists

DB_NAME = "spovum_demo"
TABLE_NAME = "dm_values"

TABLE_DEFINITION = f"""
CREATE TABLE {TABLE_NAME} (
    Sno INT AUTO_INCREMENT PRIMARY KEY,
    folderName VARCHAR(255),
    date DATE,
    fileName VARCHAR(255),
    colA VARCHAR(255),
    colB VARCHAR(255)
)
"""

def create_database(cursor):
    try:
        cursor.execute(f"CREATE DATABASE {DB_NAME}")
        print(f"Database '{DB_NAME}' created successfully.")
    except mysql.connector.Error as err:
        if err.errno == errorcode.ER_DB_CREATE_EXISTS:
            print(f"Database '{DB_NAME}' already exists.")
        else:
            print(err.msg)

def create_table(cursor):
    cursor.execute(f"USE {DB_NAME}")
    cursor.execute(f"SHOW TABLES LIKE '{TABLE_NAME}'")
    result = cursor.fetchone()
    if result:
        print(f"Table '{TABLE_NAME}' already exists.")
    else:
        cursor.execute(TABLE_DEFINITION)
        print(f"Table '{TABLE_NAME}' created successfully.")

def main():
    try:
        conn = mysql.connector.connect(user='root', password='')
        cursor = conn.cursor()
        
        # Create DB if not exists
        cursor.execute("SHOW DATABASES")
        if DB_NAME in [db[0] for db in cursor.fetchall()]:
            print(f"Database '{DB_NAME}' already exists.")
        else:
            create_database(cursor)
        
        # Create table if not exists
        create_table(cursor)

    except mysql.connector.Error as err:
        print(f"Error: {err}")
    finally:
        cursor.close()
        conn.close()


def parse_dm_values(file_path):
    data = []
    with open(file_path, 'r') as file:
        for line in file:
            parts = line.strip().split()
            if len(parts) >= 2:
                colA, colB = parts[0], parts[1]
                data.append((colA, colB))
    print(data)
    return data

def gather_all_data(base_path):
    records = []
    for root, dirs, files in os.walk(base_path):
        for file in files:
            if file == "DM_values.txt":
                file_path = os.path.join(root, file)
                folder_name = os.path.basename(os.path.dirname(file_path))
                try:
                    date_part = folder_name.split('_')[0]
                    date_formatted = f"{date_part[:4]}-{date_part[4:6]}-{date_part[6:]}"
                except:
                    date_formatted = "1970-01-01"
                rows = parse_dm_values(file_path)
                for colA, colB in rows:
                    records.append((folder_name, date_formatted, "DM_values.txt", colA, colB))
    return records


def insert_data(records):
    try:
        conn = mysql.connector.connect(user='root', password='', database=DB_NAME)
        cursor = conn.cursor()
        for row in records:
            cursor.execute(f"""
                INSERT INTO {TABLE_NAME} (folderName, date, fileName, colA, colB)
                VALUES (%s, %s, %s, %s, %s)
            """, row)
        conn.commit()
        print(f"{cursor.rowcount} rows inserted.")
    except mysql.connector.Error as err:
        print(f"MySQL error: {err}")
    finally:
        cursor.close()
        conn.close()
        
        
if __name__ == "__main__":
    main()
    all_records = gather_all_data(r"C:\Users\surya\Downloads\Data_interview.2030\Data_interview")
    insert_data(all_records)
