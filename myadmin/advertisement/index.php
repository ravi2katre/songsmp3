<?php include '../header.php'; ?>

<h2></h2>
<h2>&nbsp;&nbsp; Manage Advertisement</h2>
<br />
<?php
    $row = 35;
    $col = 150;
?>
<div class="center_content">
    <div class="sidebarmenu" style="width: 100%; padding: 0px">
        <form name="frmu" action="adver_db.php" method="post" class="niceform">
            <fieldset >
                <a class="menuitem submenuheader" href="">Home Top</a>
                <div class="submenu">
                    <h4>Mobile Version</h4>
                    <textarea name="home_topm" rows="<?=$row?>" cols="<?=$col?>"><?php
                            $File = "../../a.adv";
                            $Handle = fopen($File, 'r');
                            $theData = @fread($Handle, filesize($File));
                            fclose($Handle);
                            echo $theData;
                        ?></textarea>
                    <h4>Pc Version</h4>
                    <textarea name="home_topp" rows="<?=$row?>" cols="<?=$col?>"><?php
                            $File = "../../a.pdv";
                            $Handle = fopen($File, 'r');
                            $theData = @fread($Handle, filesize($File));
                            fclose($Handle);
                            echo $theData;
                        ?></textarea>
                </div>

                <a class="menuitem submenuheader" href="">Home Bottom</a>
                <div class="submenu">
                    <h4>Mobile Version</h4>
                    <textarea name="home_bottomm" rows="<?=$row?>" cols="<?=$col?>"><?php
                            $File = "../../b.adv";
                            $Handle = fopen($File, 'r');
                            $theData = @fread($Handle, filesize($File));
                            fclose($Handle);
                            echo $theData;
                        ?></textarea>
                    <h4>Pc Version</h4>
                    <textarea name="home_bottomp" rows="<?=$row?>" cols="<?=$col?>"><?php
                            $File = "../../b.pdv";
                            $Handle = fopen($File, 'r');
                            $theData = @fread($Handle, filesize($File));
                            fclose($Handle);
                            echo $theData;
                        ?></textarea>
                </div>

                <a class="menuitem submenuheader" href="">Home Category End</a>
                <div class="submenu">
                    <h4>Mobile Version</h4>
                    <textarea name="home_categorym" rows="<?=$row?>" cols="<?=$col?>"><?php
                            $File = "../../c.adv";
                            $Handle = fopen($File, 'r');
                            $theData = @fread($Handle, filesize($File));
                            fclose($Handle);
                            echo $theData;
                        ?></textarea>
                    <h4>Pc Version</h4>
                    <textarea name="home_categoryp" rows="<?=$row?>" cols="<?=$col?>"><?php
                            $File = "../../c.pdv";
                            $Handle = fopen($File, 'r');
                            $theData = @fread($Handle, filesize($File));
                            fclose($Handle);
                            echo $theData;
                        ?></textarea>
                </div>

                <a class="menuitem submenuheader" href="">All Page Top</a>
                <div class="submenu">
                    <h4>Mobile Version</h4>
                    <textarea name="all_page_topm" rows="<?=$row?>" cols="<?=$col?>"><?php
                            $File = "../../d.adv";
                            $Handle = fopen($File, 'r');
                            $theData = @fread($Handle, filesize($File));
                            fclose($Handle);
                            echo $theData;
                        ?></textarea>
                    <h4>Pc Version</h4>
                    <textarea name="all_page_topp" rows="<?=$row?>" cols="<?=$col?>"><?php
                            $File = "../../d.pdv";
                            $Handle = fopen($File, 'r');
                            $theData = @fread($Handle, filesize($File));
                            fclose($Handle);
                            echo $theData;
                        ?></textarea>
                </div>

                <a class="menuitem submenuheader" href="">All Page Bottom</a>
                <div class="submenu">
                    <h4>Mobile Version</h4>
                    <textarea name="all_page_bottomm" rows="<?=$row?>" cols="<?=$col?>"><?php
                            $File = "../../e.adv";
                            $Handle = fopen($File, 'r');
                            $theData = @fread($Handle, filesize($File));
                            fclose($Handle);
                            echo $theData;
                        ?></textarea>
                    <h4>Pc Version</h4>
                    <textarea name="all_page_bottomp" rows="<?=$row?>" cols="<?=$col?>"><?php
                            $File = "../../e.pdv";
                            $Handle = fopen($File, 'r');
                            $theData = @fread($Handle, filesize($File));
                            fclose($Handle);
                            echo $theData;
                        ?></textarea>
                </div>

                <a class="menuitem submenuheader" href="">After Download Link</a>
                <div class="submenu">
                    <h4>Mobile Version</h4>
                    <textarea name="after_download_linkm" rows="<?=$row?>" cols="<?=$col?>"><?php
                            $File = "../../f.adv";
                            $Handle = fopen($File, 'r');
                            $theData = @fread($Handle, filesize($File));
                            fclose($Handle);
                            echo $theData;
                        ?></textarea>
                    <h4>Pc Version</h4>
                    <textarea name="after_download_linkp" rows="<?=$row?>" cols="<?=$col?>"><?php
                            $File = "../../f.pdv";
                            $Handle = fopen($File, 'r');
                            $theData = @fread($Handle, filesize($File));
                            fclose($Handle);
                            echo $theData;
                        ?></textarea>
                </div>

                <a class="menuitem submenuheader" href="">Before Download Link</a>
                <div class="submenu">
                    <h4>Mobile Version</h4>
                    <textarea name="before_download_linkm" rows="<?=$row?>" cols="<?=$col?>"><?php
                            $File = "../../g.adv";
                            $Handle = fopen($File, 'r');
                            $theData = @fread($Handle, filesize($File));
                            fclose($Handle);
                            echo $theData;
                        ?></textarea>
                    <h4>Pc Version</h4>
                    <textarea name="before_download_linkp" rows="<?=$row?>" cols="<?=$col?>"><?php
                            $File = "../../g.pdv";
                            $Handle = fopen($File, 'r');
                            $theData = @fread($Handle, filesize($File));
                            fclose($Handle);
                            echo $theData;
                        ?></textarea>
                </div>

                <a class="menuitem submenuheader" href="">File List Start</a>
                <div class="submenu">
                    <h4>Mobile Version</h4>
                    <textarea name="file_list_startm" rows="<?=$row?>" cols="<?=$col?>"><?php
                            $File = "../../h.adv";
                            $Handle = fopen($File, 'r');
                            $theData = @fread($Handle, filesize($File));
                            fclose($Handle);
                            echo $theData;
                        ?></textarea>
                    <h4>Pc Version</h4>
                    <textarea name="file_list_startp" rows="<?=$row?>" cols="<?=$col?>"><?php
                            $File = "../../h.pdv";
                            $Handle = fopen($File, 'r');
                            $theData = @fread($Handle, filesize($File));
                            fclose($Handle);
                            echo $theData;
                        ?></textarea>
                </div>

                <a class="menuitem submenuheader" href="">File List End</a>
                <div class="submenu">
                    <h4>Mobile Version</h4>
                    <textarea name="file_list_endm" rows="<?=$row?>" cols="<?=$col?>"><?php
                            $File = "../../i.adv";
                            $Handle = fopen($File, 'r');
                            $theData = @fread($Handle, filesize($File));
                            fclose($Handle);
                            echo $theData;
                        ?></textarea>
                    <h4>Pc Version</h4>
                    <textarea name="file_list_endp" rows="<?=$row?>" cols="<?=$col?>"><?php
                            $File = "../../i.pdv";
                            $Handle = fopen($File, 'r');
                            $theData = @fread($Handle, filesize($File));
                            fclose($Handle);
                            echo $theData;
                        ?></textarea>

                </div>

                <a class="menuitem submenuheader" href="">File Page Top</a>
                <div class="submenu">
                    <h4>Mobile Version</h4>
                    <textarea name="file_page_topm" rows="<?=$row?>" cols="<?=$col?>"><?php
                            $File = "../../j.adv";
                            $Handle = fopen($File, 'r');
                            $theData = @fread($Handle, filesize($File));
                            fclose($Handle);
                            echo $theData;
                        ?></textarea>
                    <h4>Pc Version</h4>
                    <textarea name="file_page_topp" rows="<?=$row?>" cols="<?=$col?>"><?php
                            $File = "../../j.pdv";
                            $Handle = fopen($File, 'r');
                            $theData = @fread($Handle, filesize($File));
                            fclose($Handle);
                            echo $theData;
                        ?></textarea>
                </div>

                <a class="menuitem submenuheader" href="">File Page Bottom</a>
                <div class="submenu">
                    <h4>Mobile Version</h4>
                    <textarea name="file_page_bottomm" rows="<?=$row?>" cols="<?=$col?>"><?php
                            $File = "../../k.adv";
                            $Handle = fopen($File, 'r');
                            $theData = @fread($Handle, filesize($File));
                            fclose($Handle);
                            echo $theData;
                        ?></textarea>
                    <h4>Pc Version</h4>
                    <textarea name="file_page_bottomp" rows="<?=$row?>" cols="<?=$col?>"><?php
                            $File = "../../k.pdv";
                            $Handle = fopen($File, 'r');
                            $theData = @fread($Handle, filesize($File));
                            fclose($Handle);
                            echo $theData;
                        ?></textarea>
                </div>

                <a class="menuitem submenuheader" href="">Before Thumb</a>
                <div class="submenu">
                    <h4>Mobile Version</h4>
                    <textarea name="before_thumbm" rows="<?=$row?>" cols="<?=$col?>"><?php
                            $File = "../../l.adv";
                            $Handle = fopen($File, 'r');
                            $theData = @fread($Handle, filesize($File));
                            fclose($Handle);
                            echo $theData;
                        ?></textarea>
                    <h4>Pc Version</h4>
                    <textarea name="before_thumbp" rows="<?=$row?>" cols="<?=$col?>"><?php
                            $File = "../../l.pdv";
                            $Handle = fopen($File, 'r');
                            $theData = @fread($Handle, filesize($File));
                            fclose($Handle);
                            echo $theData;
                        ?></textarea>
                </div>

                <a class="menuitem submenuheader" href="">Related Download Start</a>
                <div class="submenu">
                    <h4>Mobile Version</h4>
                    <textarea name="related_download_startm" rows="<?=$row?>" cols="<?=$col?>"><?php
                            $File = "../../m.adv";
                            $Handle = fopen($File, 'r');
                            $theData = @fread($Handle, filesize($File));
                            fclose($Handle);
                            echo $theData;
                        ?></textarea>
                    <h4>Pc Version</h4>
                    <textarea name="related_download_startp" rows="<?=$row?>" cols="<?=$col?>"><?php
                            $File = "../../m.pdv";
                            $Handle = fopen($File, 'r');
                            $theData = @fread($Handle, filesize($File));
                            fclose($Handle);
                            echo $theData;
                        ?></textarea>
                </div>
                <a class="menuitem submenuheader" href="">Related Download End</a>
                <div class="submenu">
                    <h4>Mobile Version</h4>
                    <textarea name="related_download_endm" rows="<?=$row?>" cols="<?=$col?>"><?php
                            $File = "../../n.adv";
                            $Handle = fopen($File, 'r');
                            $theData = @fread($Handle, filesize($File));
                            fclose($Handle);
                            echo $theData;
                        ?></textarea>
                    <h4>Pc Version</h4>
                    <textarea name="related_download_endp" rows="<?=$row?>" cols="<?=$col?>"><?php
                            $File = "../../n.pdv";
                            $Handle = fopen($File, 'r');
                            $theData = @fread($Handle, filesize($File));
                            fclose($Handle);
                            echo $theData;
                        ?></textarea>
                </div>
                <br />
                <br />
                <input type="submit" name="submit" value="Save Advertisement" />
            </fieldset>
        </form>
    </div>
</div>
<?php include $adminfolder.'footer.php'; ?>