# SpOvum_demo

Parse the information and visualize the data:

Unzip/extract the 7Z folder (available at jobs.spovum.com/Data_interview.2030.7z)

* The data contains 3 folders, each folder having one file named DM_values.txt

* The folder name is prefixed with a date of the format yyyymmdd (20301110 => 2030 Nov 10)

* The file DM_values.txt has data in 2 columns - colA and colB

Extract the 2 columns from the DM_values files (skip empty lines) using Python (how quickly can you piece together something in a new language?!) and insert it into a table with the following columns:

Sno, folderName, date, fileName, colA, colB

1, 20301112_8_20301112_23, 20301110,  8, 2

2, 20301110_8_20301112_23, 20301110, 7, 1

.

.

Plot the data using PHP and D3 (or a visualization library of your choice)

colA VS sno (horizontal axis)

colB VS sno (horizontal axis)

Average(colA) VS date

Average(colB) VS date

Kindly share the link to the git repo once you think you’ve coded enough!

We will be forced to not consider incomplete/ irreproducible codes (as you might have guessed it).

## Instructions on how to use this application.

1. We need to set up database. 
   
   * Manually create mysql database with name spovum_demo then import the sqldump under Mysql folder or
                                       
   * Run  extract_data_to_db.py with  
            DB_NAME = "spovum_demo"
            TABLE_NAME = "dm_values"   at line 26  & 27 which will create necessary database and tables.

            Also replace path name in gather_all_data() function with actual path of the extracted folder at line 131.

This will make sure all the data are populated in database as per the instruction.

    