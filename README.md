# Rolly Polly Scheduling App
This project was bootstrapped by Team Alpha from Bob's CS 3550 Class at DSU.

Below you will find some information on how to the code works.<br>

## Table of Contents

- [Basic PHP Routing System](#basic-php-routing-system)
- [Basic DB Concepts](#basic-db-concepts)
- [Basic View Concepts](#basic-view-concepts)


## Basic PHP Routing System

Our system will run all runs via a helper function function `routerPost()` found in `js/script.js`. This function will be a single point of connection to our router in `php/router.php` to help simplify development/testing. 

## Basic DB Concepts

Our system will track teachers. It will associate teachers with classes tied to companies. It will associate events with teachers based on their roles (e.g. 'team lead' does 'weekly planning' and it takes one hour). This way the user can define new roles/events when needed. 

## Basic View Concepts

We are going to have at least three different views. 1) view the schedule/ editing the . 2) view for updating information on students, classes, events, roles. 3) view Inputing preliminary project info. 