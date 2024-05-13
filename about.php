<?php
$currentPage = 'about';
$bodyId = 'about_page';
$banner = '<p id="banner">About Me</p>';
include_once 'header.inc';
?>

      <figure id="picture">
         <!--figure with picture-->
         <img src="images/picture.jpg" alt="Aniket Debnath">
         <figcaption>Aniket Debnath</figcaption>
      </figure>
      <section>
         <h1>Hi!</h1>
         My name is Aniket Debnath. I was born India and I came to Australia as an international student in 2021.<br>
         <h2>Personal Details</h2>
         <dl>
            <dt>Name</dt>
            <dd>Aniket Debnath</dd>
            <dt>Student ID</dt>
            <dd>103126828</dd>
            <dt>Tutor</dt>
            <dd>Zeqian Dong
            <dd>
            <dt>Course</dt>
            <dd>Bachelor of Engineering (Honours) - Software Major</dd>
            <dt>Email</dt>
            <dd><a href="mailto:103126828@student.swin.edu.au">103126828@student.swin.edu.au</a></dd>
         </dl>
         My Hobbies:
         <ol>
            <li>Video games</li>
            <li>Going to the gym</li>
            <li>Reading books</li>
            <li>Watching podcasts</li>
         </ol>
      </section>
      <section>
         <!-- the &nbsp; is used as a filler space for the cells which need to be empty.-->
         <h2 id="timetable_text">My Timetable</h2>
         <table id="timetable">
            <tr>
               <th>Time</th>
               <th>Monday</th>
               <th>Tuesday</th>
               <th>Wednesday</th>
               <th>Thursday</th>
               <th>Friday</th>
            </tr>
            <tr>
               <td>8:30 - 9:30 </td>
               <td></td>
               <td></td>
               <td></td>
               <td class="cos30008" rowspan="2">COS30008<br>Class 1(1)<br>Hawthorn EN310</td>
               <td></td>
            </tr>
            <tr>
               <td>9:30 - 10:30</td>
               <td></td>
               <td></td>
               <td></td>
               <td></td>
            </tr>
            <tr>
               <td>10:30 - 11:30</td>
               <td></td>
               <td></td>
               <td></td>
               <td></td>
               <td class="cos10011" rowspan="2">COS10011<br>Class 1 (1)<br>Hawthorn EN305</td>
            </tr>
            <tr>
               <td>11:30 - 12:30</td>
               <td></td>
               <td></td>
               <td></td>
               <td class="eee40002" rowspan="3">EEE40002<br>Lab 1 (1)<br>Hawthorn ATC302</td>
            </tr>
            <tr>
               <td>12:30 - 13:30</td>
               <td class="cos10011" rowspan="2">COS30008<br>Live Online<br>Hawthorn Online</td>
               <td></td>
               <td></td>
               <td></td>
            </tr>
            <tr>
               <td>13:30 - 14:30</td>
               <td></td>
               <td></td>
               <td class="tne10005" rowspan="2">TNE10005<br>Lecture 1 (1)<br>Hawthorn ATC101</td>
            </tr>
            <tr>
               <td>14:30 - 15:30</td>
               <td></td>
               <td></td>
               <td></td>
               <td class="tne10005" rowspan="3">TNE10005<br>Class 1 (10)<br>Hawthorn ATC626</td>
            </tr>
            <tr>
               <td>15:30 - 16:30</td>
               <td></td>
               <td></td>
               <td></td>
               <td></td>
            </tr>
            <tr>
               <td>16:30 - 17:30</td>
               <td class="eee40002">EEE40002<br>Live Online<br>Hawthorn Online</td>
               <td></td>
               <td></td>
               <td></td>
            </tr>
            <tr>
               <td>17:30 - 18:30</td>
               <td class="cos10011" rowspan="2">COS10011<br>Live Online<br>Hawthorn Online</td>
               <td></td>
               <td></td>
               <td></td>
               <td></td>
            </tr>
            <tr>
               <td>18:30 - 19:30</td>
               <td></td>
               <td></td>
               <td></td>
               <td></td>
         </table>
      </section>
      <br>
      <br>
<?php include_once 'footer.inc'; ?>