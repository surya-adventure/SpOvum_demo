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