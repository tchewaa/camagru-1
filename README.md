<!--
*** Thanks for checking out the Best-README-Template. If you have a suggestion
*** that would make this better, please fork the repo and create a pull request
*** or simply open an issue with the tag "enhancement".
*** Thanks again! Now go create something AMAZING! :D
-->



<!-- PROJECT SHIELDS -->
<!--
*** I'm using markdown "reference style" links for readability.
*** Reference links are enclosed in brackets [ ] instead of parentheses ( ).
*** See the bottom of this document for the declaration of the reference variables
*** for contributors-url, forks-url, etc. This is an optional, concise syntax you may use.
*** https://www.markdownguide.org/basic-syntax/#reference-style-links
-->
[![Contributors][contributors-shield]][contributors-url]
[![Forks][forks-shield]][forks-url]
[![Stargazers][stars-shield]][stars-url]
[![Issues][issues-shield]][issues-url]
![GitHub last commit](https://img.shields.io/github/last-commit/martian1431/camagru?style=for-the-badge)




<!-- PROJECT LOGO -->
<br />

<p align="center">
  <a href="https://github.com/martian1431/camagru">
    <img src="images/logo.png" alt="Logo" width="80" height="80">
  </a>
  <h3 align="center">Camagru Documentation</h3>
  <p align="center">
    <a href="https://github.com/martian1431/camagru">View Demo</a>
    ·
    <a href="https://github.com/martian1431/camagru/issues">Report Bug</a>
    ·
    <a href="https://github.com/martian1431/camagru/issues">Request Feature</a>
  </p>
</p>



<!-- TABLE OF CONTENTS -->
<details>
  <summary>Table of Contents</summary>
  <ol>
    <li>
      <a href="#about-the-project">About The Project</a>
      <ul>
        <li><a href="#built-with">Built With</a></li>
      </ul>
    </li>
    <li>
      <a href="#getting-started">Getting Started</a>
      <ul>
        <li><a href="#prerequisites">Prerequisites</a></li>
        <li><a href="#installation">Installation</a></li>
      </ul>
    </li>
    <li><a href="#architecture">Architecture</a></li>
    <li><a href="#usage">Usage</a></li>
    <li><a href="#roadmap">Roadmap</a></li>
    <li><a href="#contributing">Contributing</a></li>
    <li><a href="#license">License</a></li>
    <li><a href="#contact">Contact</a></li>
    <li><a href="#acknowledgements">Acknowledgements</a></li>
  </ol>
</details>



<!-- ABOUT THE PROJECT -->
## About The Project

<!-- [![Product Name Screen Shot][product-screenshot]](https://example.com) -->

A small web application allowing you to make basic photo and video editing 
using your webcam, and some predefined images. Users are be able to select an 
image in a list of superposable images (for instance a picture frame, or stickers), 
a user can take a picture with his/her webcam and admire the result that should be mixing both pictures. 
All captured images are like-able and comment-able.

### Built With [XAMPP](https://www.apachefriends.org/index.html)

XAMPP is a free and open-source cross-platform web server solution stack package developed by Apache Friends, 
consisting mainly of the Apache HTTP Server, Mysql database, and interpreters for scripts written in the PHP 
and Perl programming languages. 

###### *Tools and Languages:*
* [Apache HTTP server](https://httpd.apache.org/)
* [Send Mail]()
* [PHP](https://www.php.net/)
* [Mysql](https://www.mysql.com/)
* [HTML](https://developer.mozilla.org/en-US/docs/Web/HTML)
* [CSS](https://www.w3.org/Style/CSS/Overview.en.html)
* [Bootstrap](https://getbootstrap.com)
* [Javascript](https://www.javascript.com/)

<!-- Architecture -->
## Architecture
 Model–view–controller is a software design pattern commonly used for developing 
 User interface that divides the related program logic into three interconnected elements. 
 This is done to separate internal representations of information from the ways 
 information is presented to and accepted from the user.
 
 <p align="center">
    <img src="images/screenshot1.png" alt="Architecture Screen Shot">
 </p>
 
##### *Controller*
Controllers act as an interface between Model and View components to process all the business logic 
and incoming requests, manipulate data using the Model component and interact with the Views to render 
the final output. For example, the Customer controller will handle all the interactions and inputs 
from the Customer View and update the database using the Customer Model. The same controller will be 
used to view the Customer data.
 
 ##### *Model*
  The Model component corresponds to all the data-related logic that the user works with. 
  This can represent either the data that is being transferred between the View and Controller 
  components or any other business logic-related data. For example, a Customer object will 
  retrieve the customer information from the database, manipulate it and update it data back 
  to the database or use it to render data.
  
  ##### *View*
  The View component is used for all the UI logic of the application. For example, the User view 
  will include all the UI components such as forms, dropdowns, etc. that the final user interacts with.


<!-- GETTING STARTED -->
## Getting Started

To run this application you need to follow the instruction below 

### Prerequisites
  <ol>
    <li>Download and install <a href=""> XAMPP </a></li>
    <li>
        Enable send mail function using PHP.ini file. Add or Edit the following
        <ul>
            <li>
                sendmail_path = "\"C:\xampp\sendmail\sendmail.exe\" -t"
            </li>
        </ul>
    </li>
    <li>
        Configure sendmail. Add or Edit the following
        <ul>
            <li>
                smtp_server = smtp.gmail.com
            </li>
            <li>
                smtp_port = 587
            </li>
            <li>
                auth_username = example@domain.com
            </li>
            <li>
                auth_password = password
            </li>
        </ul>
    </li>
  </ol>


> **_NOTE:_**  
>You can use this default email address if you don't wanna spend extra time configuring\  
>Email: camagru1431@gmail.com\
>Password: martian1431@


### Installation

1. Using your terminal cd into htdocs directory
    ```sh
   $ cd "C:/xampp/htdocs"
   ```
2. Clone the repo
   ```sh
   git clone https://github.com/martian1431/camagru.git
   ```
3. Open Xampp control panel
4. Start Apache and Mysql servers
5. Open browser and enter url localhost/camagru

<!-- USAGE EXAMPLES -->
## Usage

Use this space to show useful examples of how a project can be used. Additional screenshots, code examples and demos work well in this space. You may also link to more resources.

_For more examples, please refer to the [Documentation](https://example.com)_



<!-- ROADMAP -->
## Roadmap

See the [open issues](https://github.com/martian1431/camagru/issues) for a list of proposed features (and known issues).



<!-- CONTRIBUTING -->
## Contributing

Contributions are what make the open source community such an amazing place to be learn, inspire, and create. Any contributions you make are **greatly appreciated**.

1. Fork the Project
2. Create your Feature Branch (`git checkout -b feature/AmazingFeature`)
3. Commit your Changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the Branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request



<!-- LICENSE -->
## License

Distributed under the MIT License. See `LICENSE` for more information.

<!-- ACKNOWLEDGEMENTS -->
## Acknowledgements
* [Curtis Parham](https://bitbucket.org/parhamcurtis/ruahmvcyoutubecourse/src/master/)
* [Ruah MVC YouTube Course](https://www.youtube.com/watch?v=rkaLJrYnpOM&list=PLFPkAJFH7I0keB1qpWk5qVVUYdNLTEUs3&index=1&ab_channel=CurtisParham)

<!--
* [Img Shields](https://shields.io)
* [Choose an Open Source License](https://choosealicense.com)
* [GitHub Pages](https://pages.github.com)
* [Animate.css](https://daneden.github.io/animate.css)
* [Loaders.css](https://connoratherton.com/loaders)
* [Slick Carousel](https://kenwheeler.github.io/slick)
* [Smooth Scroll](https://github.com/cferdinandi/smooth-scroll)
* [Sticky Kit](http://leafo.net/sticky-kit)
* [JVectorMap](http://jvectormap.com)
* [Font Awesome](https://fontawesome.com)
-->




<!-- MARKDOWN LINKS & IMAGES -->
<!-- https://www.markdownguide.org/basic-syntax/#reference-style-links -->
[contributors-shield]: https://img.shields.io/github/contributors/martian1431/camagru.svg?style=for-the-badge
[contributors-url]: https://github.com/martian1431/camagru/graphs/contributors
[forks-shield]: https://img.shields.io/github/forks/martian1431/camagru.svg?style=for-the-badge
[forks-url]: https://github.com/martian1431/camagru/network/members
[stars-shield]: https://img.shields.io/github/stars/martian1431/camagru.svg?style=for-the-badge
[stars-url]: https://github.com/martian1431/camagru/stargazers
[issues-shield]: https://img.shields.io/github/issues/martian1431/camagru.svg?style=for-the-badge
[issues-url]: https://github.com/martian1431/camagru/issues
[license-shield]: https://img.shields.io/github/license/martian1431/camagru.svg?style=for-the-badge
[license-url]: https://github.com/martian1431/camagru/blob/master/LICENSE.txt
[linkedin-shield]: https://img.shields.io/badge/-LinkedIn-black.svg?style=for-the-badge&logo=linkedin&colorB=555
[linkedin-url]: https://linkedin.com/in/othneildrew
[product-screenshot]: images/screenshot.png
[product-screenshot1]: images/screenshot1.png 
[last-commit-shield]: https://img.shields.io/github/contributors/martian1431/camagru.svg?style=for-the-badge
[last-commit-url]: https://github.com/martian1431/camagru/graphs/contributors
