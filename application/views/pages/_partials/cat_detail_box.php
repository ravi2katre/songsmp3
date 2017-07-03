<?php
$name = (isset($cat_name))?$cat_name:$mPageTitle;
?>
<div class="card">
    <h3 class="card-header title_bar"><i class="fa fa-music"></i> <?php echo $name; ?></h3>
    <div class="card-block">
        <div class="movie_cover_box">
            <div class="movie_cover">
                <?php
                if(empty($thumb)){
                    // echo '<img  class="card-img-top img-fluid" src="https://scontent.fnag1-1.fna.fbcdn.net/v/t1.0-9/12821427_1140809332604262_1569773744317899529_n.jpg?oh=4b61a93d146354771040b15c962db90e&oe=59C8F62F" alt="'.$mPageTitle.'">';

                }else{
                    echo '<img class="card-img-top img-fluid" src="uploads/cat_images/'.$thumb.'" alt="'.$mPageTitle.'">';
                }
                ?>            </div>
            <div class="movie_details">
                <table style="font-family: arial;">
                    <tbody>
                    <tr>
                        <td class="m_d_title" valign="top">
                            Staring
                        </td>
                        <td class="m_d_title2" valign="top">
                            :
                        </td>
                        <td class="m_d_title3">
                            <a href="/stars/salman-khan.html">Salman Khan</a>, &nbsp;<a href="/stars/sohail-khan.html">Sohail Khan</a>, &nbsp;<a href="/stars/zhu-zhu.html">Zhu Zhu</a>				</td>
                    </tr>
                    <tr>
                        <td class="m_d_title" valign="top">
                            Director
                        </td>
                        <td class="m_d_title2" valign="top">
                            :
                        </td>
                        <td class="m_d_title3">
                            <a href="/directors/kabir-khan.html">Kabir Khan</a>				</td>
                    </tr>
                    <tr>
                        <td class="m_d_title" valign="top">
                            Music Director(s)
                        </td>
                        <td class="m_d_title2" valign="top">
                            :
                        </td>
                        <td class="m_d_title3">
                            <a href="/music-directors/pritam.html">Pritam</a>				</td>
                    </tr>
                    <tr>
                        <td class="m_d_title" valign="top">
                            Composer(s)
                        </td>
                        <td class="m_d_title2" valign="top">
                            :
                        </td>
                        <td class="m_d_title3">
                            <a href="/composers/manurishi-chadha.html">Manurishi Chadha</a>				</td>
                    </tr>
                    <tr>
                        <td class="m_d_title" valign="top">
                            Singer(s)
                        </td>
                        <td class="m_d_title2" valign="top">
                            :
                        </td>
                        <td class="m_d_title3">
                            <a href="/singers/kamaal-khan.html">Kamaal Khan</a>, &nbsp;<a href="/singers/amit-mishra.html">Amit Mishra</a>, &nbsp;<a href="/singers/akashdeep-sengupta.html">Akashdeep Sengupta</a>, &nbsp;<a href="/singers/pritam.html">Pritam</a>, &nbsp;<a href="/singers/rahat-fateh-ali-khan.html">Rahat Fateh Ali Khan</a>, &nbsp;<a href="/singers/jubin-nautiyal.html">Jubin Nautiyal</a>				</td>
                    </tr>
                    </tbody></table>
            </div>
        </div>
    </div>
</div>



