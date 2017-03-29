<?php

require_once'Core/init.php';

?>

<!DOCTYPE html>
<html>
<head>
    <link rel="preload" as="script" href="Includes/js/materialize.min.js">
    <link rel="preload" as="script" href="https://use.fontawesome.com/819d78ad52.js">
    <link rel="preload" as="script" href="Includes/js/jquery.min.js">
    <!-- <link rel="preload" as="image" href="Includes/images/code5.jpeg">
    <link rel="preload" as="image" href="Includes/images/code3.png">
    <link rel="preload" as="image" href="Includes/images/code2.png">
    <link rel="preload" as="image" href="Includes/images/code4.png">
    <link rel="preload" as="image" href="Includes/images/code1.png"> -->
    <link rel="preload" as="style" href="http://fonts.googleapis.com/icon?family=Material+Icons">
    <title>
      Home
    </title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta name="keywords" content="blog, technology, code, program, alorithms"/>
    <meta name="description" content="Publish your passions your way. Whether you'd like to share your knowledge, experiences or the latest tech news, create a unique and beautiful blog for free.">
    <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.8/css/materialize.min.css">
    <style type="text/css">
        /* no added transitions for safari, mozilla, safari and other browsers*/
        .slider
        {
            z-index: -1;
        }
        nav
        {
            border-bottom: 1px white solid;
        }
        input[type="search"]
        {
            height: 64px !important; /* or height of nav */
        }
        .logo
        {
            height: auto;
            width: 50%;
        }
        #secondary-content
        {
            position: relative;
            top: 100vh;
        }
        .blockquote
        {
            font-size: 12px;
        }
        .description
        {
            font-size: 12px;
        }
/*        ._token
        {
            display: none;
        }*/
        a
        {
            text-decoration: none;
            color: none;
        }
        nav ul .dropdown-button
        {
            width: 200px !important;
        }
        /*nav ul .navbar-menu
        {
            width: 167px;
        }*/
    </style>
</head>
<body>

    <?php

        include'header.php';

    ?>

    <div class="slider fullscreen" data-indicators="false">
        <ul class="slides">
            <li>
                <img src="Includes/images/1.jpg">
            </li>
            <li>
                <img src="Includes/images/2.jpg"> 
            </li>
            <li>
                <img src="Includes/images/3.jpg">
            </li>
            <li>
                <img src="Includes/images/4.jpg">
            </li>
            <li>
                <img src="Includes/images/5.jpg">
            </li>            
            <li>
                <img src="Includes/images/6.jpg">
            </li>
            <li>
                <img src="Includes/images/7.jpg"> 
            </li>
            <li>
                <img src="Includes/images/8.jpg">
            </li>
            <li>
                <img src="Includes/images/9.jpg">
            </li>
            <li>
                <img src="Includes/images/10.jpg">
            </li>   
        </ul>
    </div>
    <div id="secondary-content">
            <!-- <div class="row">
                <div class="col s10 offset-s1">
                    <div class="card horizontal">
                        <div class="card-stacked">
                            <div class="card-content">
                                <p>I am a very simple card. I am good at containing small bits of information.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div> -->
            <div class="row">
                <div class="col s7 offset-s1">
                    <div class="card">
                        <div class="card-image">
                            <img src="Includes/images/11.jpg">
                            <span class="card-title">JSS ACADEMY OF TECHNICAL EDUCATION, NOIDA</span>
                        </div>
                        <div class="card-content">
                            <p>JSS Academy of Technical Education Noida (JSSATEN) is one of the leading Technical Institutions in the National Capital Region in the State of Uttar Pradesh. Established in the year 1998 by JSS Mahavidyapeetha, Noida, the Institution has set bench marks every year, and grown into an Institution of Excellence in Technical Education. Located in the central part of NOIDA, JSSATEN has become a household name for its excellence in Discipline, Teaching, Training and Placement. Today, JSSATEN has total student strength of over 4000, who are mentored by more than 250 Faculty Members. The Campus has finest accommodation for girls and boys.</p><br>
                            <p>The Institution has MOUs with Colorado Heights University, Denver, USA for student exchange program. IBM Centre of Excellence, Nokia Mobile Innovation Labs, PLMCC and Schneider Electric Substation Automation Labs are additional facilities for the students to innovate new ideas. JSS Academy has Doctoral Programs in Computer Science & Engineering, Mechanical Engineering, Electronics & Communication Engineering and Physical Sciences under UP Technical University.</p>
                        </div>
                    </div>
                </div>
                <div class="col s3">
                    <div class="card">
                        <div class="card-image">
                            <img src="Includes/images/12.gif">
                            <span class="card-title">JSS MAHAVIDYAPEETHA</span>
                        </div>
                        <div class="card-content">
                            <p>Established in the year 1954 the Jagadguru Sri Shivarathreeswara Mahavidyapeetha has been described by many eminent educationists as greater than a University, because under its aegis a child can begin its education in the kindergarten and proceed to earn a degree as well as a doctorate in several branches of learning. Simultaneously the Mahavidyapeetha has not neglected to strengthen the roots of our ancient knowledge, wisdom and culture and their application in the day-to-day life.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col s7 offset-s1">
                    <div class="card">
                        <div class="card-image">
                            <img src="Includes/images/16.jpg">
                            <span class="card-title" style="color:black">MISSION</span>
                        </div>
                        <div class="card-content">
                            <p>JSS Academy of Technical Education, Noida has implemented Outcome Based Education (OBE) in the Academy. JSSATEN is proud to mention that it has created necessary manpower and infrastructure to implement Outcome Based Education from the year 2014-15. So far the Technical Institutions have been imparting teaching through a traditional system where the learning outcomes of the students are not clearly measured. The ’Washington Accord’ emphasise on outcome based education. There is a need to develop a standard approach to match quality assurance for Engineering Programs. The graduating Engineers of the future will need to be evaluated in their outlook and experience and be ready for global opportunities. So, there is a need and challenge for all Technical Institutions to aid and empower the future students for global environment.</p>
                        </div>
                    </div>
                </div>
                <div class="col s3">
                    <div class="card">
                        <div class="card-image">
                            <img src="Includes/images/14.png">
                            <span class="card-title">VISION</span>
                        </div>
                        <div class="card-content">
                            <p>Established in the year 1954 the Jagadguru Sri Shivarathreeswara Mahavidyapeetha has been described by many eminent educationists as greater than a University, because under its aegis a child can begin its education in the kindergarten and proceed to earn a degree as well as a doctorate in several branches of learning. Simultaneously the Mahavidyapeetha has not neglected to strengthen the roots of our ancient knowledge, wisdom and culture and their application in the day-to-day life.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col s7 offset-s1">
                    <div class="card">
                        <div class="card-image">
                            <img src="Includes/images/15.jpg">
                            <span class="card-title">PRINCIPAL'S DESK</span>
                        </div>
                        <div class="card-content">
                            <p>Being recognised as one of the best Technical Institutions, JSS Academy of Technical Education, Noida (JSSATEN) is adopting cautiously to the changing demands of technical manpower at global level. The Academy envisions to become an Institution of Excellence in imparting quality Outcome Based Education that empowers young generation with knowledge, skills, research aptitude, ethics and moral values. The Institutions has been making efforts to strictly implement OBE by preparing the faculty members to a system, where they measure the progress and competencies of the student as they go through a course in each Semester.</p>
                        </div>
                    </div>
                </div>
                <div class="col s3">
                    <div class="card blue-grey darken-1">
                        <div class="card-content white-text">
                            <span class="card-title">IMPORTANT LINKS</span>
                                <a href='' class='white-text'>Centenary Celebrations of His Holiness Jagadguru Dr. Sri Shivarathri Rajendra Mahaswamiji</a><br><br>
                                <a href='' class='white-text'>Academic Calendar 2016-17</a><br><br>
                                <a href='' class='white-text'>Image Gallery</a><br><br>
                                <a href='' class='white-text'>Videos</a><br><br>
                                <a href='' class='white-text'>Explore the College</a><br><br>
                                <a href='' class='white-text'>Staff Directory</a><br><br>
                                <a href='' class='white-text'>Department News Letter</a><br><br>
                            </div>
                      </div>
                </div>            
            </div>


        <footer class="page-footer blue lighten-1">
            <div class="container">
                <div class="row">
                    <div class="col l6 s12">
                        <h5 class="white-text">TechWit</h5>
                        <p class="grey-text text-lighten-4">Publish your passions your way. Whether you'd like to share your knowledge, experiences or the latest tech news, create a unique and beautiful blog for free.</p>
                    </div>
                    <div class="col l4 offset-l2 s12">
                        <h5 class="white-text">View Our Other Projects</h5>
                        <ul>
                            <li><a class="grey-text text-lighten-3" href="http://www.silive.in" target="blank">silive.in</a></li>
                            <li><a class="grey-text text-lighten-3" href="#!" target="blank">Blood Donation Campaign 2017</a></li>
                            <li><a class="grey-text text-lighten-3" href="#!" target="blank">Table Tennis Tournament</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="footer-copyright">
                <div class="container center-align">
                    © 2017 Software Incubator
                </div>
            </div>
        </footer>
    </div>

    <script src="Includes/js/jquery.min.js"></script>
    <script src="https://use.fontawesome.com/819d78ad52.js"></script>
    <script type="text/javascript" src="Includes/js/materialize.min.js"></script>
    <script>
        if(typeof(Storage) !== "undefined")
        {
            console.log('not undefined');
            if(sessionStorage.getItem("flashMessage") !== null)
            {
                Materialize.toast(sessionStorage.getItem("flashMessage"), 5000 ,'green');
                sessionStorage.removeItem('flashMessage');
            }
        }
        $(document).ready(function(){
            $('.slider').slider();  // activate slider

            $(".dropdown-button").dropdown({hover: false});   // activate dropdown in the nav-bar

            $(".button-collapse").sideNav();

            $('.blog-pagination').click(function(e){
                e.preventDefault();
                $('.active').removeClass('active');
                $(this).parent().addClass('active');
                var page_id = $(this).html();
                // var _token = $('#_token').attr('data-attribute');

                $.ajax({
                    type: 'POST',
                    url: 'pagination_backend.php',
                    data: {page_id: page_id},
                    dataType: "json",
                    cache: false,
                    success: function(response)
                    {
                        // var response = JSON.parse(response);
                        console.log(response);
                        if(response.error_status === true)
                        {
                            Materialize.toast(response.error, 5000, "red");
                        }
                        else
                        {
                            // console.log(response._token);
                            // $('#_token').attr('data-attribute', response._token);
                            $('.content').html(response.content);
                        }
                    }
                });
            });

            // $('.views').click(function(e){
            //     e.preventDefault();
            //     var blog_id = getBlogId(this);
            //     var _token = getToken();

            // });


            // $('.likes, .dislikes').click(function(e){
            //     e.preventDefault();
            //     var object = $(this);
                
            //     var blog_id = getBlogId(this);
            //     var _token = getToken();
            //     var count = $(this).attr('data-attribute');
            //     var className = getClassName(this);

            //     $.ajax({
            //         type: 'POST',
            //         url: 'blog_attributes.php',
            //         data: {blog_id: blog_id, _token: _token, field: className, count: count},
            //         cache: false,
            //         success: function(response)
            //         {
            //             var response = JSON.parse(response);
            //             console.log(response);
            //             $('#_token').attr('data-attribute', response._token);
            //             if(response.error_status)
            //             {
            //                 consol.log(response.error);
            //                 Materialize.toast(response.error, 5000, 'red');
            //                 return false;
            //             }
            //             else
            //             {
            //                 $(object).attr('data-attribute', response.count);
            //                 console.log(response.count);
            //                 console.log($(object).parent().next().text(response.count));
            //             }
            //         }
            //     });
            // });
   
            // function getToken()
            // {
            //     return $('#_token').attr('data-attribute');
            // } 

            // function getBlogId(object)
            // {
            //     return $(object).parent().parent().attr('data-attribute');
            // }

            // function getClassName(object)
            // {
            //     var className = $(object).attr('class');
            //     if(className === 'likes')
            //     {
            //         className = 'likes';
            //     }
            //     else if(className === 'dislikes')
            //     {
            //         className = 'dislikes';
            //     }

            //     return className;

            // }

        });
    </script>
</body>
</html>