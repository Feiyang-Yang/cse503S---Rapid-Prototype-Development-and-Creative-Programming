# README #
1.
The Screenshot of college.html on the server of EC2 is also pushed in Bitbucket, please check it.
I also upload the sreen shot of the other two which works under Node.JS.
The link of my EC2 to launch the files under Node.JS is in the following as the same in the sreen shot:
http://ec2-18-217-122-83.us-east-2.compute.amazonaws.com:3456/college.html
http://ec2-18-217-122-83.us-east-2.compute.amazonaws.com:3456/hello.js
http://ec2-18-217-122-83.us-east-2.compute.amazonaws.com:3456/brookings.jpg

2.
The hello.txt, brookings.jpg, and college.html files all load successfully.  Please check them.

3.
Trying to visit file does not exist inside the static directory results a file not found.
As the ScreenShot of 'ScreenShot-noexist file.png' demonstrates.

4.Why phpinfo.php behaves the way it does when loaded through Node.JS？
phpinfo.php does not show as the other three.  The browser asks if I need to download it.
I think the reason is that, under the catalogue I store it, there is no Apache server, and I equip the catalogue with Node.JS environment which does not support php files.

5.
The 'static_server.js' and the folder 'static' are pushed to bitbucket. 
