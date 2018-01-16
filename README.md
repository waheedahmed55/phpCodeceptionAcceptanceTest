Download Selenium Sever Jar file: http://docs.seleniumhq.org/download/ I downloaded 3.8.1 just rename it to .jar

Download the chrome Driver https://chromedriver.storage.googleapis.com/index.html?path=2.28/ ChromeDriver 2.28 win32 and unzip it in codeception direcotry & Set the path in Envirnoment Varaiables

Download the GeckoDriver for FirFox https://github.com/mozilla/geckodriver/releases  geckodriver-v0.19.1-win64.zip & Set the path in Envirnoment Varaiables

Run this before running test suite This will bring up the selenium server
java -jar selenium-server-standalone-3.8.1.jar -enablePassThrough false

Downloaded codecept.phar from http://codeception.com/codecept.phar

Generate the test
php codecept.phar generate:cept acceptance FirstCest


IDE: https://devmind.io or https://atom.io/ download 64 bit version AtomSetup-x64.exe run it

To run the test cases
php codecept.phar run --env chrome --env firefox --html
