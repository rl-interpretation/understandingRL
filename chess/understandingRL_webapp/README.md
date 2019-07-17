__Note : Exact names to are to be used__
## Setting Up Xampp

Download xampp from 
    https://www.apachefriends.org/download.html

## Web-App Database Setup

* Start xampp using command 
    ```sh
    sudo /opt/lampp/lampp start 
    ```
* Go to
    [phpmyadmin](localhost/phpmyadmin)
* Create a new database named 'chess_results' with collation 'utf8_bin'
* Give global previleges, also add username 'admin' with password 'admin123'

## Create table for the human studies

* Create a table named 'studies' with 5 columns
* Create 5 columns with names and respective data types:
    * 'id' : int
    * 'game_id' : int
    * 'saliency' : int
    * 'solved' : int
    * 'time_taken' : float
* Make 'id' the primary key

## Chess Web-App
* Clear '/opt/lampp/htdocs' folder
* Download 'understandingRL_webapp' into path '/opt/lampp/htdocs'
* Go to [localhost](localhost)
