# PHP codeception automation

This project contains the automated tests of the tajawal.ae website

# Installation
- Downloaded codecept.phar from http://codeception.com/codecept.phar
- Download Selenium Sever Jar file: http://docs.seleniumhq.org/download/ I downloaded 3.8.1 just rename it to .jar
- Run this before running test suite This will bring up the selenium server java -jar selenium-server-standalone-3.8.1.jar -enablePassThrough false
- -Clone this repository

## Running the tests

To run the test cases php codecept.phar run --env chrome --env firefox --html
this should do the trick
