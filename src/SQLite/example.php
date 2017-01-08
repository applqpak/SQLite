<?php

  include 'Main.php';

  /*##########################
   *# Create SQLite database #
   *##########################
   */
   $n   = 'test';
   $db  = new SQLite($n);

  /*#######################
   *# Create SQLite table #
   *#######################
   */
   $sql = 'CREATE TABLE IF NOT EXISTS test(id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT, name VARCHAR NOT NULL, message VARCHAR NOT NULL);';
   $db->prepare($n, $sql);
   $db->execute($n);

  /*#######################
   *# Insert example data #
   *#######################
   */
   $sql = 'INSERT INTO test(name, message) VALUES(:name, :message);';
   $db->prepare($n, $sql);
   $db->bind($n, 'name', 'applqpak');
   $db->bind($n, 'message', 'Hello, world!');
   $db->execute($n);

  /*################
   *# Get all rows #
   *################
   */
   $sql = 'SELECT * FROM test;';
   $db->prepare($n, $sql);
   $db->execute($n);
   $res = $db->fetch($n);

  /*########################
   *# Display all messages #
   *########################
   */
   foreach($res as $row)
   {
     echo 'ID: ' . $row['id'] . ' | ' . $row['name'] . ' | ' . $row['message'] . '<br >';
   }
